<template>
  <div class="public-offerboard-page">
    <!-- <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>Public Offerboard</h3>
          <ul>
            <li class="item">
              <a href="#">Home</a>
            </li>
          </ul>
        </div>
      </div>
    </section> -->
    <section class="half-map-sec mt-0">
      <div class="container">
        <div class="row">
          <div class="col-xl-6 col-lg-12">
            <map-component :offers="offers" />
          </div>
          <div class="col-xl-6 col-lg-12">
            <div class="offers-wrapper" style="padding-bottom: 100px;">
              <search-component @search="fetchOffers" />
              <div class="listing-directs">
                <!-- <list-head-component /> -->
                <tabs-component type="feed" v-if="offers.length > 0" :offers="offers" />
                <!-- <pagination-component /> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";

/* Layout */
import HeaderComponent from "./HeaderComponent.vue";
import FooterComponent from "./FooterComponent.vue";

/* Components */
import MapComponent from "./offers/MapComponent.vue";
import SearchComponent from "./offers/SearchComponent.vue";
import ListHeadComponent from "./offers/ListHeadComponent.vue";
import TabsComponent from "./offers/TabsComponent.vue";
import PaginationComponent from "./offers/PaginationComponent.vue";

export default {
  data: () => ({
    offers: [],
    isLoading: false,
    error: null,
  }),

  components: {
    HeaderComponent,
    FooterComponent,
    MapComponent,
    SearchComponent,
    TabsComponent,
    ListHeadComponent,
    PaginationComponent,
  },

  mounted() {
    const hd_height = $("header").innerHeight();
    $(".half-map-sec #map-container.fullwidth-home-map").css({
      top: hd_height,
    });
    $(".half-map-sec").css({
      "margin-top": hd_height,
    });
  },

  created() {
    this.fetchOffers();
  },

  // watch: {
  //   // call again the method if the route changes
  //   $route: "fetchFreeOffers",
  // },

  methods: {
    fetchOffers(searchParams = null) {
      // const user = this.$store.state.user;
      const user = JSON.parse(localStorage.getItem('user'));

      if (!user) return;

      // Show loading
      this.$store.commit('setLoading', true);

      let url = `${window.location.origin}/api/feed-offers`;
      if (searchParams) {
        if (searchParams.marketTypes && searchParams.types) {
          url += `?market_types=${searchParams.marketTypes}&types=${searchParams.types}`;
        } else if (searchParams.marketTypes) {
          url += `?market_types=${searchParams.marketTypes}`;
        } else if (searchParams.types) {
          url += `?types=${searchParams.types}`;
        }
      }

      axios
        .get(
          url,
          {
            headers: { Authorization: `Bearer ${user.api_token}` },
          }
        )
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;

            this.offers = data.map((item) => {
              const currency = item.data.primary.data.currency
                ? item.data.primary.data.currency.value
                : "EUR";
              const commission = item.commission.replace(",", ".");
              const images = Object.values(item.images);
              return {
                id: item.id,
                thumbnail: images.length
                  ? images[0].url
                  : "https://via.placeholder.com/370x295",
                title: item.title,
                category: this.getOfferType(item.offer_type_id),
                price: item.price,
                currency: this.getCurrencySign(currency),
                commission: `${commission}%`,
                privacy: item.privacy,
                status: item.status === "activated",
                location: item.location,
                primaryData: item.data.primary.data,
                secondaryData: item.data.secondary ? item.data.secondary.data : null,
                createdAt: item.created_at,
                wisthlistUsers: item.wishlist_users,
                isAddedToWishlist: item.wishlist_users ? !!item.wishlist_users.find((u) => u.id === user.id) : false,
              };
            });
          }

          this.$store.commit('setLoading', false);

          // Close the filter box if it's opening
          $('.widget-property-search').removeClass('active');

          // Save offers to local storage for later use (on the offer detail page)
          localStorage.setItem('offers', JSON.stringify(this.offers));
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit('setLoading', false);
        });
    },

    getCurrencySign(currency) {
      switch (currency) {
        case "EUR":
          return "€";
        case "GBP":
          return "£";
        case "USD":
          return "$";
        case "RMB":
          return "元";
        case "JPY":
          return "¥";
        default:
          return "€";
      }
    },

    getOfferTypeId(type) {
      const types = [
        "none",
        "real_estate",
        "car",
        "art",
        "horse",
        "yacht",
        "jet",
      ];
      const index = types.indexOf(type);
      return index !== -1 ? index : 1;
    },

    getOfferType(typeId) {
      const types = [
        "none",
        "real_estate",
        "car",
        "art",
        "horse",
        "yacht",
        "jet",
      ];
      return types[typeId];
    },

    // getOfferCategory(offer) {
    //   const type = this.getOfferType(offer.offer_type_id);
    //   switch (type) {
    //     case "real_estate":
    //       return offer.category.display_name;
    //     case "car":
    //       return "Luxury Cars";
    //     case "art":
    //       return "Art";
    //     default:
    //       return "";
    //   }
    // },
  },
};
</script>
