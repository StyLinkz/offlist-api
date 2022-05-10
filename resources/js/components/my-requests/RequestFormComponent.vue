<template>
  <div class="widget widget-form">
    <h3 class="widget-title">Status</h3>
    <div class="post-comment-sec mt-0">
      <form novalidate id="formUpdateRequest" method="post" @submit="submit">
        <div class="form-group">
          <!-- <label for="">Status</label> -->
          <div class="request-status-options">
            <div
              class="
                custom-control custom-radio
              "
            >
              <input
                v-model="status"
                type="radio"
                id="requestStatusContact"
                name="status"
                value="contact"
                class="custom-control-input"
              />
              <label
                class="custom-control-label"
                for="requestStatusContact"
                >Contact</label
              >
            </div>
            <div
              class="
                custom-control custom-radio
              "
            >
              <input
                v-model="status"
                type="radio"
                id="requestStatusViewing"
                name="status"
                value="viewing"
                class="custom-control-input"
              />
              <label
                class="custom-control-label"
                for="requestStatusViewing"
                >Viewing</label
              >
            </div>
            <div
              class="
                custom-control custom-radio
              "
            >
              <input
                v-model="status"
                type="radio"
                id="requestStatusContract"
                name="status"
                value="contract"
                class="custom-control-input"
              />
              <label
                class="custom-control-label"
                for="requestStatusContract"
                >Contract Documents</label
              >
            </div>
            <div
              class="
                custom-control custom-radio
              "
            >
              <input
                v-model="status"
                type="radio"
                id="requestStatusConclusion"
                name="status"
                value="conclusion"
                class="custom-control-input"
              />
              <label
                class="custom-control-label"
                for="requestStatusConclusion"
                >Conclusion</label
              >
            </div>
          </div>
        </div>
        <!-- END request-status -->
        <div class="clearfix"></div>
        <div class="mt-4">
          <button type="submit" class="btn2">
            Apply
          </button>
        </div>
      </form>
    </div>
    <!--post-comment-sec end-->
  </div>
  <!--widget-form end-->
</template>

<script>
import axios from "axios";

export default {
  name: "FormUpdateRequest",
  props: ['request'],

  data: () => ({
    status: 'contact',
  }),

  mounted() {
    this.status = this.request.status;
  },

  methods: {
    submit(e) {
      e.preventDefault();

      // Show loading
      this.$store.commit('setLoading', true);

      const user = JSON.parse(localStorage.getItem('user'));
      const url = `https://offlist.de/api/applications/${this.request.id}`;
      const data = {
        "status": this.status,
      };
      axios({
        method: 'put',
        url,
        data,
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((response) => {
          if (response.status === 200) {
            // Open success notification
            this.$store.commit('openNotification', {
              message: 'Your request has been updated successfully!',
              type: 'success',
            });

            // Redirect to the offer list page
            setTimeout(() => {
              // Close notification
              this.$store.commit('closeNotification');

              // Hide loading
              this.$store.commit('setLoading', false);
            }, 2000);
          }
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit('setLoading', false);
          this.$store.commit('openNotification', {
            message: 'Failed! Please try again later',
            type: 'error',
          });
        });
    },
  },
};
</script>
