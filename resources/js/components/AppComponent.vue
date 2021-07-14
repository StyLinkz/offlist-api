<template>
  <div class="wrapper" :class="{ 'overlay-bgg': isSignInModalOpen }">
    <header-component :isFixed="isHeaderFixed" />
    <main>
      <router-view></router-view>
    </main>
    <footer-component />
    <div
      class="modal modal-submit-listing fade"
      id="modalSubmitListing"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalSubmitListingLabel"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalSubmitListingLabel">
              Select a type
            </h5>
          </div>
          <div class="modal-body">
            <div class="offer-submit-listing-options mt-3">
              <div
                class="custom-control custom-radio"
                v-for="type in offerTypes"
                :key="type.value"
              >
                <input
                  v-model="selectedOfferType"
                  :value="type.value"
                  type="radio"
                  :id="`offerType_${type.value}`"
                  name="offer_type"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="`offerType_${type.value}`"
                >{{ type.label }}</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="handleSubmitListing"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- END modal-submit-listing -->
  </div>
</template>

<script>
import HeaderComponent from "./HeaderComponent.vue";
import FooterComponent from "./FooterComponent.vue";

export default {
  data: () => ({
    loading: false,
    fixedHeaderPages: [],
    selectedOfferType: 'real_estate',
    offerTypes: [
      {
        value: 'real_estate',
        label: 'Real Estate',
      },
      {
        value: 'car',
        label: 'Luxury Cars',
      },
      {
        value: 'art',
        label: 'Art',
      },
    ],
  }),

  computed: {
    isSignInModalOpen () {
      return this.$store.state.isSignInModalOpen;
    },

    isHeaderFixed () {
      return this.fixedHeaderPages.includes(this.$route.name);
    },
  },

  components: {
    HeaderComponent,
    FooterComponent,
  },

  methods: {
    handleSubmitListing () {
      this.$router.push(`/submit-listing?type=${this.selectedOfferType}`);
    },
  },
};
</script>
