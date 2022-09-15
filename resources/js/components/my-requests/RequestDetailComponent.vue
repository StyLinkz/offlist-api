<template>
  <section class="property-single-pg">
    <div class="container">
      <div class="property-single-header">
        <a
          href="javascript:void(0);"
          role="button"
          class="back"
          @click="goBack"
        >
          <i class="la la-arrow-left"></i>
        </a>
      </div>
      <div class="property-hd-sec">
        <OverviewComponent :offer="form.offer" v-if="form.offer.title" />
      </div>
      <div class="property-single-page-content">
        <div class="row">
          <div class="col-lg-8 pl-0 pr-0">
            <div class="property-pg-left">
              <GalleryComponent
                :images="form.offer.images"
                :image-alt="form.offer.title"
                v-if="form.offer.images && form.offer.images.length"
              />
              <DescriptionComponent
                :offer="form.offer"
                v-if="form.offer.location"
              />
              <DetailComponent
                :offer="form.offer"
                v-if="form.offer.data.primary"
              />
              <LocationComponent
                :offer="form.offer"
                v-if="form.offer.location"
              />
              <FloorPlanComponent
                :images="form.offer.floorPlans"
                :image-alt="form.offer.title"
                v-if="form.offer.floorPlans && form.offer.floorPlans.length"
              />
            </div>
          </div>
          <div class="col-lg-4 pr-0">
            <div class="sidebar layout2">
              <request-sender-component :sender="form.contact" v-if="form.contact.email" />
              <div class="clearfix"></div>
              <div class="border-top pt-4 mt-0 w-100" v-if="form.status && form.status !== 'deleted'" >
                <request-form-component :request="form"/>
              </div>
              <div class="clearfix"></div>
              <div class="border-top pt-5 mt-0 w-100" v-if="form.status && form.status !== 'deleted'">
                <button type="button" class="btn2 btn-delete" data-toggle="modal" data-target="#modalDeleteOfferWarning">
                  Delete this offer
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <offer-delete-modal-component :offerId="form.offer.id" :onDeleteSuccess="handleDeleteSuccess" v-if="form.offer.id" />
  </section>
</template>

<script>
import axios from 'axios';

/* Layout */
import HeaderComponent from '../HeaderComponent';
import FooterComponent from '../FooterComponent';

/* Components */
import HeaderSearchFormComponent from '../common/HeaderSearchFormComponent';
import CategoriesComponent from '../common/CategoriesComponent';
import PopularOffersComponent from '../common/PopularOffersComponent';
import OverviewComponent from '../offer-detail/OverviewComponent';
import GalleryComponent from '../offer-detail/GalleryComponent';
import DescriptionComponent from '../offer-detail/DescriptionComponent';
import DetailComponent from '../offer-detail/DetailComponent';
import FeatureComponent from '../offer-detail/FeatureComponent';
import FloorPlanComponent from '../offer-detail/FloorPlanComponent';
import LocationComponent from '../offer-detail/LocationComponent';
import ReviewComponent from '../offer-detail/ReviewComponent';
import RelatedOffersComponent from '../offer-detail/RelatedOffersComponent';
import ContactFormComponent from '../offer-detail/ContactFormComponent';
import CalculatorComponent from '../offer-detail/CalculatorComponent';
import RequestSenderComponent from '../my-requests/RequestSenderComponent.vue';
import RequestFormComponent from '../my-requests/RequestFormComponent.vue';
import OfferDeleteModalComponent from '../OfferDeleteModalComponent.vue';

export default {
  data: () => ({
    error: null,
    form: {
      offer: {
        data: {},
        images: [],
        documents: [],
        floorPlans: [],
        title: ''
      },
      contact: {}
    },
    tagOptions: [],
    groupOptions: [],
  }),

  components: {
    HeaderComponent,
    FooterComponent,
    HeaderSearchFormComponent,
    OverviewComponent,
    GalleryComponent,
    DescriptionComponent,
    DetailComponent,
    FeatureComponent,
    FloorPlanComponent,
    LocationComponent,
    ReviewComponent,
    RelatedOffersComponent,
    ContactFormComponent,
    CategoriesComponent,
    PopularOffersComponent,
    CalculatorComponent,
    RequestSenderComponent,
    RequestFormComponent,
    OfferDeleteModalComponent,
  },

  created() {
    const { requestId } = this.$route.params;

    if (requestId) {
      // Show loading
      this.$store.commit('setLoading', true);

      // Fetchd data
      Promise.all([
        this.fetchTags(),
        this.fetchGroups(),
        this.getRequest(requestId)
      ]).then(values => {
        const [tagResponse, groupResponse, applicationResponse] = values;
        if (tagResponse.status === 200) {
          const { data } = tagResponse;
          this.tagOptions = data.map(item => ({
            value: item.id,
            label: item.display_name
          }));
        }
        if (groupResponse.status === 200) {
          this.groupOptions = groupResponse.data;
        }
        if (applicationResponse.status === 200) {
          const { data } = applicationResponse;

          /* Contact */
          this.form.id = data.id;
          this.form.date = data.created_at;
          this.form.status = data.status;
          this.form.contact = {
            email: data.sender_email,
            phone: data.sender_phone,
            prename: data.sender_prename,
            name: data.sender_name,
            message: data.sender_message
          };

          /* Get offer details */
          const user = JSON.parse(localStorage.getItem('user'));
          axios
            .get(`${window.location.origin}/api/offers/${data.offer.id}`, {
              headers: { Authorization: `Bearer ${user.api_token}` }
            })
            .then(offerResponse => {
              const applicationOffer = offerResponse.data;

              /* Offer */
              this.form.offer.id = applicationOffer.id;
              this.form.offer.title = applicationOffer.title;
              this.form.offer.offer_type_id = applicationOffer.offer_type_id;
              this.form.offer.offer_category_id =
                applicationOffer.offer_category_id;
              this.form.offer.type = this.getOfferType(
                applicationOffer.offer_type_id
              );
              this.form.offer.status = applicationOffer.status === 'activated';
              this.form.offer.tags = applicationOffer.tags
                ? applicationOffer.tags.map(tag => tag.id)
                : [];
              this.form.offer.price = applicationOffer.price;
              this.form.offer.commission = applicationOffer.commission;
              this.form.offer.seller = applicationOffer.seller;
              this.form.offer.user_id = applicationOffer.user_id;

              /* Privacy */
              this.form.offer.privacy = applicationOffer.privacy;
              if (applicationOffer.privacy === 'private') {
                this.form.offer.privacyGroups = applicationOffer.groups
                  ? applicationOffer.groups.map(group => {
                      const index = this.groupOptions.findIndex(
                        item => item.id === group.id
                      );
                      return index;
                    })
                  : [];
              }

              /* Populate location */
              this.form.offer.location = applicationOffer.location;
              this.form.offer.locationText = applicationOffer.location.address;

              /* Seller information */
              if (applicationOffer.seller.contact_mode === 'profile') {
                this.form.offer.seller = {
                  avatar: applicationOffer.user.avatar,
                  name: applicationOffer.user.name,
                  prename: applicationOffer.user.prename,
                  address: applicationOffer.user.address,
                  city: applicationOffer.user.city,
                  company: applicationOffer.user.company,
                  email: applicationOffer.user.email,
                  phone: applicationOffer.user.phone,
                  website: applicationOffer.user.website,
                  zipcode: applicationOffer.user.zip_code
                };
              }

              /* Images */
              const imageKeys = Object.keys(applicationOffer.images);
              if (imageKeys.length) {
                imageKeys.forEach(key => {
                  const image = applicationOffer.images[key];
                  this.form.offer.images.push(image.url);
                });
              }

              const primary = applicationOffer.data.primary.data;
              if (applicationOffer.type.name === 'real_estate') {
                const secondary = applicationOffer.data.secondary.data;
                const floorPlan =
                  applicationOffer.data.floor_plan.data.images.value;
                const buildingFabric =
                  applicationOffer.data.building_fabric.data;
                const furnishing = applicationOffer.data.furnishing.data;
                const documents = applicationOffer.documents;

                /* Floor Plan */
                const floorPlanKeys = floorPlan ? Object.keys(floorPlan) : [];
                if (floorPlanKeys.length) {
                  floorPlanKeys.forEach(key => {
                    const image = floorPlan[key];
                    this.form.offer.floorPlans.push(image.url);
                  });
                }

                /* Documents */
                const documentKeys = documents ? Object.keys(documents) : [];
                if (documentKeys.length) {
                  documentKeys.forEach(key => {
                    const image = documents[key];
                    this.form.offer.documents.push(image.url);
                  });
                }

                /* Primary */
                this.form.offer.data.primary = {
                  currency: primary.currency.value,
                  size: primary.size.value,
                  free_from: primary.free_from.value,
                  year_of_construction: primary.year_of_construction.value,
                  status: primary.status.value
                };

                /* Secondary */
                this.form.offer.data.secondary = {
                  rooms: secondary.rooms.value,
                  bedroom: secondary.bedroom.value,
                  bath_room: secondary.bath_room.value,
                  living_room: secondary.living_room.value,
                  parking_space: secondary.parking_space.value,
                  cellars: secondary.cellars.value,
                  floor_in_total: secondary.floor_in_total.value
                };

                /* Building Fabric */
                this.form.offer.data.building_fabric = {
                  object_state: buildingFabric.object_state.value,
                  equipment: buildingFabric.equipment.value,
                  energy_source: buildingFabric.energy_source.value,
                  heating_type: buildingFabric.heating_type.value
                };

                /* Furnishing */
                this.form.offer.data.furnishing = furnishing.description.value;
              } else if (applicationOffer.type.name === 'car') {
                /* Primary */
                this.form.offer.data.primary = {
                  currency: primary.currency.value,
                  brand: primary.brand.value,
                  model: primary.model.value,
                  year_of_construction: primary.year_of_construction.value,
                  status: primary.status.value,
                  variant: primary.variant.value,
                  mileage: primary.mileage.value,
                  gearbox: primary.gearbox.value,
                  fuel_type: primary.fuel_type.value,
                  color: primary.color.value,
                  interior_color: primary.interior_color.value
                };
              } else if (applicationOffer.type.name === 'art') {
                this.form.offer.data.primary = {
                  currency: primary.currency.value,
                  artist_name: primary.artist_name.value,
                  technique: primary.technique.value,
                  year_of_construction: primary.year_of_construction.value,
                  dimensions: primary.dimensions.value,
                  fabrication: primary.fabrication.value
                };
              }

              // Hide loading
              this.$store.commit('setLoading', false);
            });
        }
      });
    }
  },

  methods: {
    getRequest() {
      const user = JSON.parse(localStorage.getItem('user'));
      if (!user) return;
    },

    async getRequest(requestId) {
      const user = JSON.parse(localStorage.getItem('user'));
      return axios.get(`${window.location.origin}/api/applications/${requestId}`, {
        headers: { Authorization: `Bearer ${user.api_token}` }
      });
    },

    async fetchTags() {
      const user = JSON.parse(localStorage.getItem('user'));
      return axios.get(`${window.location.origin}/api/tags`, {
        headers: { Authorization: `Bearer ${user.api_token}` }
      });
    },

    async fetchGroups() {
      const user = JSON.parse(localStorage.getItem('user'));
      return axios.get(`${window.location.origin}/api/groups`, {
        headers: { Authorization: `Bearer ${user.api_token}` }
      });
    },

    handleDeleteSuccess() {
      this.goBack();
    },

    getOfferTypeId() {
      const types = [
        'none',
        'real_estate',
        'car',
        'art',
        'horse',
        'yacht',
        'jet'
      ];
      const index = types.indexOf(this.form.type);
      return index !== -1 ? index : 1;
    },

    getOfferType(typeId) {
      const types = [
        'none',
        'real_estate',
        'car',
        'art',
        'horse',
        'yacht',
        'jet'
      ];
      return types[typeId] ? types[typeId] : 'real_estate';
    },

    getOfferCategoryId() {
      if (['car', 'art'].indexOf(this.form.type) != -1) {
        return 1;
      }
      return this.form.offer.offer_category_id;
    },

    goBack() {
      this.$router.go(-1);
    }
  }
};
</script>
