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
        <OverviewComponent :offer="form" v-if="form.title" />
      </div>
      <!---property-hd-sec end-->
      <div class="property-single-page-content">
        <div class="row">
          <div class="col-lg-8 pl-0 pr-0">
            <div class="property-pg-left">
              <GalleryComponent
                :images="form.images"
                :image-alt="form.title"
                v-if="form.images && form.images.length"
              />
              <DescriptionComponent :offer="form" v-if="form.location" />
              <DetailComponent :offer="form" v-if="form.data.primary" />
              <LocationComponent :offer="form" v-if="form.location" />
              <FloorPlanComponent
                :images="form.floorPlans"
                :image-alt="form.title"
                v-if="form.floorPlans && form.floorPlans.length"
              />
            </div>
            <!--property-pg-left end-->
          </div>
          <div class="col-lg-4 pr-0">
            <div class="sidebar layout2">
              <ContactFormComponent :offer="form" v-if="form.seller" />
            </div>
            <!--sidebar end-->
          </div>
        </div>
      </div>
      <!--property-single-page-content end-->
      <div class="clearfix"></div>
      <div class="property-single-footer">
        <div class="psf__buttons">
          <a :href="`/offers/${prevOfferId}?type=${this.$route.query.type || ''}`" class="btn2" v-if="!!prevOfferId">
            <i class="la la-angle-left"></i>
            Previous offer
          </a>
          <a :href="`/offers/${nextOfferId}?type=${this.$route.query.type || ''}`" class="btn2" v-if="!!nextOfferId">
            Next offer
            <i class="la la-angle-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";

/* Layout */
import HeaderComponent from "./HeaderComponent";
import FooterComponent from "./FooterComponent";

/* Components */
import HeaderSearchFormComponent from "./common/HeaderSearchFormComponent";
import CategoriesComponent from "./common/CategoriesComponent";
import PopularOffersComponent from "./common/PopularOffersComponent";
import OverviewComponent from "./offer-detail/OverviewComponent";
import GalleryComponent from "./offer-detail/GalleryComponent";
import DescriptionComponent from "./offer-detail/DescriptionComponent";
import DetailComponent from "./offer-detail/DetailComponent";
import FeatureComponent from "./offer-detail/FeatureComponent";
import FloorPlanComponent from "./offer-detail/FloorPlanComponent";
import LocationComponent from "./offer-detail/LocationComponent";
import ReviewComponent from "./offer-detail/ReviewComponent";
import RelatedOffersComponent from "./offer-detail/RelatedOffersComponent";
import ContactFormComponent from "./offer-detail/ContactFormComponent";
import CalculatorComponent from "./offer-detail/CalculatorComponent";

export default {
  data: () => ({
    error: null,
    form: {
      data: {},
      images: [],
      documents: [],
      floorPlans: [],
      title: '',
    },
    tagOptions: [],
    groupOptions: [],
    prevOfferId: null,
    nextOfferId: null,
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
  },

  created() {
    const { offerId } = this.$route.params;

    if (offerId) {
      // Show loading
      this.$store.commit("setLoading", true);

      // Fetchd data
      Promise.all([
        this.fetchTags(),
        this.fetchGroups(),
        this.getOffer(offerId),
      ]).then((values) => {
        const [tagResponse, groupResponse, offerResponse] = values;
        if (tagResponse.status === 200) {
          const { data } = tagResponse;
          this.tagOptions = data.map((item) => ({
            value: item.id,
            label: item.display_name,
          }));
        }
        if (groupResponse.status === 200) {
          this.groupOptions = groupResponse.data;
        }
        if (offerResponse.status === 200) {
          const { data } = offerResponse;

          this.form.id = data.id;
          this.form.title = data.title;
          this.form.offer_type_id = data.offer_type_id;
          this.form.offer_category_id = data.offer_category_id;
          this.form.type = this.getOfferType(data.offer_type_id);
          this.form.status = data.status === "activated";
          this.form.tags = data.tags ? data.tags.map((tag) => tag.id) : [];
          this.form.price = data.price;
          this.form.commission = data.commission;
          this.form.seller = data.seller;
          this.form.user_id = data.user_id;

          /* Privacy */
          this.form.privacy = data.privacy;
          if (data.privacy === "private") {
            this.form.privacyGroups = data.groups
              ? data.groups.map((group) => {
                const index = this.groupOptions.findIndex(
                  (item) => item.id === group.id
                );
                return index;
              })
              : [];
          }

          /* Populate location */
          this.form.location = data.location;
          this.form.locationText = data.location.address;

          /* Seller information */
          if (data.seller.contact_mode === 'profile') {
            this.form.seller = {
              avatar: data.user.avatar,
              name: data.user.name,
              prename: data.user.prename,
              address: data.user.address,
              city: data.user.city,
              company: data.user.company,
              email: data.user.email,
              phone: data.user.phone,
              website: data.user.website,
              zipcode: data.user.zip_code,
            };
          }

          /* Images */
          const imageKeys = Object.keys(data.images);
          if (imageKeys.length) {
            imageKeys.forEach((key) => {
              const image = data.images[key];
              this.form.images.push(image.url);
            });
          }

          const primary = data.data.primary.data;
          if (data.type.name === "real_estate") {
            const secondary = data.data.secondary.data;
            const floorPlan = data.data.floor_plan.data.images.value;
            const buildingFabric = data.data.building_fabric.data;
            const furnishing = data.data.furnishing.data;
            const documents = data.documents;

            /* Floor Plan */
            const floorPlanKeys = floorPlan ? Object.keys(floorPlan) : [];
            if (floorPlanKeys.length) {
              floorPlanKeys.forEach((key) => {
                const image = floorPlan[key];
                this.form.floorPlans.push(image.url)
              });
            }

            /* Documents */
            const documentKeys = documents ? Object.keys(documents) : [];
            if (documentKeys.length) {
              documentKeys.forEach((key) => {
                const image = documents[key];
                this.form.documents.push(image.url)
              });
            }

            /* Primary */
            this.form.data.primary = {
              currency: primary.currency.value,
              size: primary.size.value,
              free_from: primary.free_from.value,
              year_of_construction: primary.year_of_construction.value,
              status: primary.status.value,
            };

            /* Secondary */
            this.form.data.secondary = {
              rooms: secondary.rooms.value,
              bedroom: secondary.bedroom.value,
              bath_room: secondary.bath_room.value,
              living_room: secondary.living_room.value,
              parking_space: secondary.parking_space.value,
              cellars: secondary.cellars.value,
              floor_in_total: secondary.floor_in_total.value,
            };

            /* Building Fabric */
            this.form.data.building_fabric = {
              object_state: buildingFabric.object_state.value,
              equipment: buildingFabric.equipment.value,
              energy_source: buildingFabric.energy_source.value,
              heating_type: buildingFabric.heating_type.value,
            };

            /* Furnishing */
            this.form.data.furnishing = furnishing.description.value;
          } else if (data.type.name === "car") {
            /* Primary */
            this.form.data.primary = {
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
              interior_color: primary.interior_color.value,
            };
          } else if (data.type.name === "art") {
            this.form.data.primary = {
              currency: primary.currency.value,
              artist_name: primary.artist_name.value,
              technique: primary.technique.value,
              year_of_construction: primary.year_of_construction.value,
              dimensions: primary.dimensions.value,
              fabrication: primary.fabrication.value,
            };
          }
        }

        // Hide loading
        this.$store.commit("setLoading", false);

        console.log({ form: this.form });
      });
    }
  },

  mounted() {
    try {
      const offerId = parseInt(this.$route.params.offerId);
      const jsonOffers = localStorage.getItem('offers');
      const offerList = JSON.parse(jsonOffers);
      const foundIndex = offerList.findIndex((o) => o.id === offerId);
      if (foundIndex !== -1) {
        if (foundIndex > 0) {
          this.prevOfferId = offerList[foundIndex - 1].id;
        }
        if (foundIndex < offerList.length - 1) {
          this.nextOfferId = offerList[foundIndex + 1].id;
        }
      }
      console.log({ prev: this.prevOfferId, next: this.nextOfferId });
    } catch (error) {
      console.log({error});
    }
  },

  methods: {
    getOffer() {
      const user = JSON.parse(localStorage.getItem("user"));

      if (!user) return;
    },

    async getOffer(offerId) {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get(`https://offlist.de/api/offers/${offerId}`, {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },

    async fetchTags() {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get("https://offlist.de/api/tags", {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },

    async fetchGroups() {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get("https://offlist.de/api/groups", {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },

    getOfferTypeId () {
      const types = [
        'none',
        'real_estate',
        'car',
        'art',
        'horse',
        'yacht',
        'jet',
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
        'jet',
      ];
      return types[typeId] ? types[typeId] : 'real_estate';
    },

    getOfferCategoryId() {
      if (['car', 'art'].indexOf(this.form.type) != -1) {
        return 1;
      }
      return this.form.offer_category_id;
    },

    goBack() {
      this.$router.go(-1);
    },
  },
};
</script>
