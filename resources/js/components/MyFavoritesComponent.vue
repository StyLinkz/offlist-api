<template>
  <div class="my-favorites-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Favorites</h3>
        </div>
      </div>
    </section>
    <section class="section-my-offers">
      <div class="container">
        <div class="offers-wrapper">
          <div class="listing-directs">
            <div class="list_products" v-if="offers.length > 0">
              <div class="row">
                <div
                  class="col-lg-4 col-md-6"
                  v-for="offer in offers"
                  :key="`offer_row_${offer.id}`"
                >
                  <list-item-component :offer="offer" :isOwner="true" type="wishlist" />
                </div>
              </div>
            </div>
            <!--list_products end-->
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import axios from "axios";

/* Components */
import ListItemComponent from "./offers/ListItemComponent.vue";

export default {
  components: {
    ListItemComponent,
  },

  data: () => ({
    key: new Date().valueOf(),
    logoImage: "/images/logo.svg",
    loading: false,
    offers: [],
    tagOptions: [],
    types: [
      {
        value: "real_estate",
        label: "Real Estate",
      },
      {
        value: "car",
        label: "Luxury Cars",
      },
      {
        value: "art",
        label: "Art",
      },
    ],
    realEstateCategoryOptions: [
      {
        text: "Apartment",
        value: 1,
      },
      {
        text: "House",
        value: 2,
      },
      {
        text: "Commercial property",
        value: 3,
      },
      {
        text: "Hotel",
        value: 4,
      },
      {
        text: "Resort",
        value: 5,
      },
      {
        text: "Property",
        value: 6,
      },
      {
        text: "Miscellaneous",
        value: 7,
      },
    ],
  }),

  created() {
    const jsonUser = localStorage.getItem('user');
    if (!jsonUser) {
      window.location.replace('/');
    } else {
      this.$store.commit('setLoading', true);

      /* Fetch data */
      this.fetchFavorites();
    }
  },

  methods: {
    fetchTags() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .get(`${window.location.origin}/api/tags`, {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.tagOptions = data.map((item) => ({
              value: item.id,
              label: item.display_name,
            }));
          }
        })
        .catch((error) => {
          console.log({ error });
        });
    },

    fetchFavorites() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .get(`${window.location.origin}/api/wishlist`, {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
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
                title: item.title,
                thumbnail: images.length
                  ? images[0].url
                  : "https://via.placeholder.com/370x295",
                category: this.getOfferType(item.offer_type_id),
                price: item.price,
                currency: this.getCurrencySign(currency),
                commission: `${commission}%`,
                privacy:
                  item.privacy === "public"
                    ? "Public Offerboard"
                    : "Private Group",
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
          this.loading = false;
          this.$store.commit('setLoading', false);

          // Save offers to local storage for later use (on the offer detail page)
          localStorage.setItem('offers', JSON.stringify(this.offers));
        })
        .catch((error) => {
          console.log({ error });
          this.loading = false;
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

    getOfferCategory(offer) {
      const type = this.getOfferType(offer.offer_type_id);
      switch (type) {
        case "real_estate":
          return offer.category.display_name;
        case "car":
          return "Luxury Cars";
        case "art":
          return "Art";
        default:
          return "";
      }
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
  },
}
</script>
