<template>
  <div class="my-requests-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Applications</h3>
        </div>
      </div>
    </section>
    <section class="section-my-requests">
      <div class="container">
        <div class="offers-wrapper">
          <div class="listing-directs">
            <h3 v-if="applications.length === 0">You have no applications at the moment.</h3>
            <div class="list_products" v-else>
              <div class="row">
                <div
                  class="col-lg-4 col-md-6"
                  v-for="application in applications"
                  :key="`application_item_${application.id}`"
                >
                  <application-component :offer="application.offer" :application="application" />
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
import ApplicationComponent from "./my-applications/ApplicationComponent.vue";

export default {
  components: {
    ApplicationComponent,
  },

  data: () => ({
    applications: [],
  }),

  created() {
    const jsonUser = localStorage.getItem("user");
    if (!jsonUser) {
      window.location.replace("/");
    } else {
      this.$store.commit('setLoading', true);

      /* Fetch data */
      this.fetchApplications();
    }
  },

  methods: {
    fetchApplications() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .get(`${window.location.origin}/api/auth-applications`, {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.applications = data.map((item) => {
              const images = Object.values(item.offer.images);
              return {
                id: item.id,
                user: item.user,
                sender: item.sender,
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
                  phone: item.sender_phone,
                  prename: item.sender_prename,
                  name: item.sender_name,
                  message: item.sender_message,
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
