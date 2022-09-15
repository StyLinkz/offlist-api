<template>
  <div class="my-groups-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Groups</h3>
        </div>
      </div>
    </section>
    <section class="section-my-groups">
      <div class="container">
        <div class="d-flex justify-content-end border-bottom pb-4">
          <button
            type="button"
            class="btn btn-primary btn-add-group"
            @click="handleAddGroup"
          >
            Add Group
          </button>
        </div>
        <div class="group-list">
          <group-component
            v-for="group in groups"
            :key="`group_item_${group.id}`"
            :group="group"
            @edit="handleEdit"
            @delete="handleDelete"
          />
        </div>
      </div>
    </section>
    <modal-edit-group-component
      :group="editedGroup"
      :allContacts="contacts"
      @update="handleUpdate"
    />
  </div>
</template>
<script>
import axios from "axios";

/* Components */
import GroupComponent from './my-groups/GroupComponent.vue';
import ModalEditGroupComponent from './my-groups/ModalEditGroupComponent.vue';

export default {
  components: {
    GroupComponent,
    ModalEditGroupComponent,
  },

  data: () => ({
    groups: [],
    contacts: [],
    editedGroup: null,
  }),

  created() {
    const jsonUser = localStorage.getItem('user');
    if (!jsonUser) {
      window.location.replace('/');
    } else {
      this.$store.commit('setLoading', true);
      this.fetchData();
    }
  },

  methods: {
    fetchData() {
      /* Fetch data */
      Promise.all([
        this.fetchGroups(),
        this.fetchContacts(),
      ])
        .then((values) => {
          const [groupResponse, contactResponse] = values;
          if (groupResponse.status === 200) {
            const { data } = groupResponse;
            this.groups = data;
          }
          if (contactResponse.status === 200) {
            const { data } = contactResponse;
            this.contacts = data;
          }
          this.$store.commit('setLoading', false);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit('setLoading', false);
        });
    },

    fetchGroups() {
      const user = JSON.parse(localStorage.getItem('user'));
      return axios
        .get(`${window.location.origin}/api/groups`, {
          headers: { Authorization: `Bearer ${user.api_token}` },
        });
    },

    fetchContacts() {
      const user = JSON.parse(localStorage.getItem('user'));
      return axios
        .get(`${window.location.origin}/api/contacts`, {
          headers: { Authorization: `Bearer ${user.api_token}` },
        });
    },

    handleEdit(group) {
      this.$store.commit('setLoading', true);

      // Set edited group
      this.editedGroup = group;

      setTimeout(() => {
        this.$store.commit('setLoading', false);
        this.openEditGroupModal();
      }, 1000);
    },

    handleDelete(group) {
      if (confirm('Are you sure you want to delete this group?')) {
        this.$store.commit('setLoading', true);

        const user = JSON.parse(localStorage.getItem('user'));
        const url = `${window.location.origin}/api/groups/${group.id}`
        axios({
          url,
          method: 'delete',
          headers: {
            Authorization: `Bearer ${user.api_token}`,
          },
        })
          .then((response) => {
            if (response.status === 204) {
              // Delete the group from the list
              const groupIndex = this.groups.findIndex((groupItem) => groupItem.id === group.id);
              this.groups.splice(groupIndex, 1);

              // Show success message
              this.$store.commit('openNotification', {
                message: 'Delete successfully!',
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
          });
      }
    },

    handleUpdate(group) {
      const groupIndex = this.groups.findIndex((groupItem) => groupItem.id === group.id);
      if (groupIndex !== -1) {
        this.groups.splice(groupIndex, 1);
        this.groups.splice(groupIndex, 0, JSON.parse(JSON.stringify(group)));
      } else {
        this.groups.unshift(group);
      }
    },

    handleAddGroup() {
      this.editedGroup = null;
      this.openEditGroupModal();
    },

    openEditGroupModal() {
      $('#modalEditGroup').modal('show');
    },

    closeEditGroupModal() {
      $('#modalEditGroup').modal('hide');
    },
  },
}
</script>
