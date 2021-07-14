<template>
  <div class="my-requests-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Requests</h3>
        </div>
      </div>
    </section>
    <section class="section-my-requests">
      <div class="container">
        <div class="offers-wrapper">
          <div class="listing-directs">
            <div class="list_products" v-if="requests.length > 0">
              <div class="row">
                <div
                  class="col-lg-4 col-md-6"
                  v-for="request in requests"
                  :key="`request_item_${request.id}`"
                >
                  <request-component :offer="request.offer" :request="request" />
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
import RequestComponent from "./my-requests/RequestComponent.vue";

export default {
  components: {
    RequestComponent,
  },

  data: () => ({
    requests: [],
  }),

  created() {
    const jsonUser = localStorage.getItem("user");
    if (!jsonUser) {
      window.location.replace("/");
    } else {
      this.$store.commit('setLoading', true);

      /* Fetch data */
      this.fetchRequests();
    }
  },

  methods: {
    fetchRequests() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .get("https://offlist.de/api/auth-applications", {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.requests = data.map((item) => {
              const images = Object.values(item.offer.images);
              return {
                id: item.id,
                user: item.user,
                offer: {
                  id: item.offer.id,
                  title: item.offer.title,
                  thumbnail: images.length
                    ? images[0].url
                    : "https://via.placeholder.com/370x295",
                  price: item.offer.price,
                  status: item.offer.status === "activated",
                  location: item.offer.location,
                  primaryData: item.offer.data.primary.data,
                  secondaryData: item.offer.data.secondary ? item.offer.data.secondary.data : null,
                  createdAt: item.created_at,
                },
                contact: {
                  email: item.sender_email,
                  prename: item.sender_prename,
                  name: item.sender_name,
                },
                date: item.created_at,
              };
            });
          }
          this.$store.commit('setLoading', false);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit('setLoading', false);
        });
    },
  },
}
</script>
