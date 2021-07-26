<template>
  <div class="my-invitations-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Invitations</h3>
        </div>
      </div>
    </section>
    <section class="section-my-invitations">
      <div class="container">
        <div class="d-flex justify-content-end border-bottom pb-4">
          <button
            type="button"
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#modalAddInvitation"
          >Add Invitation</button>
        </div>
        <div class="invitation-list">
          <invitation-component
            v-for="invitation in invitations"
            :key="`invitation_item_${invitation.id}`"
            :invitation="invitation"
          />
        </div>
      </div>
    </section>
    <modal-add-invitation-component @update="handleAddNewInvitation" />
  </div>
</template>
<script>
import axios from "axios";

/* Components */
import InvitationComponent from './my-invitations/InvitationComponent.vue';
import ModalAddInvitationComponent from './my-invitations/ModalAddInvitationComponent.vue';

export default {
  components: {
    InvitationComponent,
    ModalAddInvitationComponent,
  },

  data: () => ({
    invitations: [],
  }),

  created() {
    const jsonUser = localStorage.getItem('user');
    if (!jsonUser) {
      window.location.replace('/');
    } else {
      this.$store.commit('setLoading', true);

      /* Fetch data */
      this.fetchInvitations();
    }
  },

  methods: {
    fetchInvitations() {
      const user = JSON.parse(localStorage.getItem('user'));
      axios
        .get('https://offlist.de/api/auth-invitations', {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.invitations = data.map((item) => {
              return {
                id: item.id,
                code: item.code,
                status: item.status,
                receiver: {
                  id: item.receiver_id,
                  prename: item.receiver_prename,
                  name: item.receiver_name,
                  email: item.receiver_email,
                },
                createdAt: item.created_at,
                expiredAt: item.expired_at,
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

    handleAddNewInvitation(newInvitation) {
      this.invitations.unshift({
        id: newInvitation.id,
        code: newInvitation.code,
        receiver: {
          prename: newInvitation.receiver_prename,
          name: newInvitation.receiver_name,
          email: newInvitation.receiver_email,
        },
        createdAt: newInvitation.created_at,
        expiredAt: newInvitation.expired_at,
      });
    }
  },
}
</script>
