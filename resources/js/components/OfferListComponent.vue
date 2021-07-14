<template>
  <div class="wrapper">
    <header-component />
    <main>
      <header-map-component />
      <section class="listing-main-sec section-padding">
        <div class="container">
          <div class="listing-main-sec-details">
            <div class="row">
              <div class="col-lg-8">
                <div class="listing-directs">
                  <list-head-component />
                  <tabs-component />
                  <pagination-component />
                </div>
                <!-- list-products end-->
              </div>
              <div class="col-lg-4">
                <div class="sidebar layout2">
                  <search-component />
                  <categories-component />
                  <popular-offers-component />
                </div>
                <!--sidebar end-->
              </div>
            </div>
          </div>
          <!--listing-main-sec-details end-->
        </div>
      </section>
      <!--listing-main-sec end-->
    </main>
    <footer-component />
  </div>
</template>

<script>
import axios from "axios";

/* Layout */
import HeaderComponent from "./HeaderComponent.vue";
import FooterComponent from "./FooterComponent.vue";

/* Components */
import HeaderMapComponent from "./common/HeaderMapComponent.vue";
import CategoriesComponent from "./common/CategoriesComponent.vue";
import PopularOffersComponent from "./common/PopularOffersComponent.vue";
import ListHeadComponent from "./offers/ListHeadComponent.vue";
import TabsComponent from "./offers/TabsComponent.vue";
import PaginationComponent from "./offers/PaginationComponent.vue";
import SearchComponent from "./offer-list/SearchComponent.vue";

export default {
  data: () => ({
      isLoading: false,
      error: null,
  }),

  components: {
    HeaderComponent,
    FooterComponent,
    HeaderMapComponent,
    ListHeadComponent,
    TabsComponent,
    PaginationComponent,
    SearchComponent,
    CategoriesComponent,
    PopularOffersComponent,
  },

  created () {
      this.fetchFreeOffers();
  },

  watch: {
    // call again the method if the route changes
    '$route': 'fetchFreeOffers'
  },

  methods: {
    fetchFreeOffers () {
      this.error = null
      this.isLoading = true

      axios.get('/api/free-offers')
        .then((response) => {
            console.log({ response });
        })
        .catch((error) => {
            console.log({ error });
        });
    }
  },
};
</script>
