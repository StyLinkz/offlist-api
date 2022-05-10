<template>
  <div
    class="modal modal-delete-offer-warning fade"
    id="modalDeleteOfferWarning"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalDeleteOfferWarningLabel"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDeleteOfferWarningLabel">
            Why do you want to delete this offer?
          </h5>
        </div>
        <div class="modal-body">
          <div class="offer-delete-reason-options">
            <div
              class="custom-control custom-radio mb-1"
              v-for="reason in reasons"
              :key="reason.value"
            >
              <input
                v-model="selectedReason"
                :value="reason.value"
                type="radio"
                :id="`offerDeleteReason_${reason.value}`"
                name="offer_delete_reason"
                class="custom-control-input"
              />
              <label
                class="custom-control-label"
                :for="`offerDeleteReason_${reason.value}`"
              >{{ reason.label }}</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
          >
            Cancel
          </button>
          <button
            type="button"
            class="btn btn-delete"
            data-dismiss="modal"
            @click="handleDelete"
          >
            Delete offer permanently
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- END modal-submit-listing -->
</template>
<script>
import axios from "axios";

export default {
  props: ["offerId", "onDeleteSuccess"],

  data: () => ({
    selectedReason: 'sold_via_offlist_private_group',
    reasons: [
      {
        value: 'sold_via_offlist_private_group',
        label: 'It was sold via Offlist in a private group',
      },
      {
        value: 'sold_via_offlist_offerboard',
        label: 'It was sold via Offlist on the offerboard',
      },
      {
        value: 'sold_somewhere',
        label: 'It was sold somewhere else',
      },
      {
        value: 'no_longer_want_to_sell',
        label: 'I no longer want to sell it',
      },
      {
        value: 'other',
        label: 'Other reasons',
      },
    ],
  }),

  created() {
    const jsonUser = localStorage.getItem("user");
    if (!jsonUser) {
      window.location.replace("/");
    }
  },

  methods: {
    handleDelete() {
      const user = JSON.parse(localStorage.getItem("user"));

      // Show loading
      this.$store.commit('setLoading', true);

      // Delete all relevant offer requests (applications) first
      axios({
        method: 'post',
        url: `https://offlist.de/api/delete-offer-applications`,
        data: {
          offerId: this.offerId,
        },
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((deleteApplicationsResponse) => {
          if (deleteApplicationsResponse.status === 200) {
            // Delete the offer
            axios({
              method: 'put',
              url: `https://offlist.de/api/offers/${this.offerId}`,
              data: {
                status: 'deleted',
                deleted_reason: this.selectedReason,
              },
              headers: {
                Authorization: `Bearer ${user.api_token}`,
              },
            })
              .then((response) => {
                if (response.status === 200) {
                  this.$store.commit('setLoading', false);
                  this.$store.commit("openNotification", {
                    message: "The offer has been deleted successfully!",
                    type: "success",
                  });

                  setTimeout(() => {
                    this.$store.commit('closeNotification');
                    if (typeof this.onDeleteSuccess === 'function') {
                      this.onDeleteSuccess();
                    }
                  }, 2000);
                }
              })
              .catch((error) => {
                console.log({ error });

                this.$store.commit("openNotification", {
                  message: "Delete failed! Please try again later",
                  type: "error",
                });

                setTimeout(() => {
                  this.$store.commit('closeNotification');
                  this.$store.commit('setLoading', false);
                }, 2000);
              });
          }
        })
    }
  },
}
</script>
