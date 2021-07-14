<template>
  <div class="my-contacts-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Contacts</h3>
        </div>
      </div>
    </section>
    <section class="section-my-contacts">
      <div class="container">
        <div class="contact-list">
          <contact-component
            v-for="contact in contacts"
            :key="`contact_item_${contact.id}`"
            :contact="contact"
            @edit="handleEdit"
          />
        </div>
      </div>
    </section>
    <modal-edit-contact-component
      :contact="editedContact"
      @update="handleUpdate"
    />
  </div>
</template>
<script>
import axios from "axios";

/* Components */
import ContactComponent from './my-contacts/ContactComponent.vue';
import ModalEditContactComponent from './my-contacts/ModalEditContactComponent.vue';

export default {
  components: {
    ContactComponent,
    ModalEditContactComponent
  },

  data: () => ({
    contacts: [],
    editedContact: null,
  }),

  created() {
    const jsonUser = localStorage.getItem('user');
    if (!jsonUser) {
      window.location.replace('/');
    } else {
      this.$store.commit('setLoading', true);

      /* Fetch data */
      this.fetchContacts();
    }
  },

  methods: {
    fetchContacts() {
      const user = JSON.parse(localStorage.getItem('user'));
      axios
        .get('https://offlist.de/api/contacts', {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.contacts = data;
          }
          this.$store.commit('setLoading', false);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit('setLoading', false);
        });
    },

    handleEdit(contact) {
      this.$store.commit('setLoading', true);

      // Set edited contact
      this.editedContact = contact;

      setTimeout(() => {
        this.$store.commit('setLoading', false);
        this.openEditContactModal();
      }, 1000);
    },

    handleUpdate(contact) {
      const contactIndex = this.contacts.findIndex((contactItem) => contactItem.id === contact.id);
      if (contactIndex !== -1) {
        this.contacts.splice(contactIndex, 1);
        this.contacts.splice(contactIndex, 0, JSON.parse(JSON.stringify(contact)));
      }
    },

    openEditContactModal() {
      $('#modalEditContact').modal('show');
    },

    closeEditContactModal() {
      $('#modalEditContact').modal('hide');
    },
  },
}
</script>
