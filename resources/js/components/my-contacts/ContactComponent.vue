<template>
  <div class="contact-item d-flex justify-content-between align-items-center py-4">
    <div class="d-flex align-items-center">
      <div class="contact-item__avatar rounded-circle p-1 mr-4">
        <img
          :src="contact.avatar"
          :alt="contactFullName"
          class="rounded-circle img--cover"
        />
      </div>
      <div class="contact-item__info d-flex flex-column">
        <span class="contact-item__name">
          {{ contactFullName }}
        </span>
        <a :href="`mailTo:${contact.email}`" class="contact-item__email d-flex align-items-center mt-2">
          <i class="la la-envelope"></i>
          <span class="ml-2">{{ contact.email }}</span>
        </a>
        <a :href="`tel:${contact.phone}`" class="contact-item__phone d-flex align-items-center mt-2">
          <i class="la la-phone"></i>
          <span class="ml-2">{{ contact.phone }}</span>
        </a>
      </div>
    </div>
    <div class="contact-item__action d-flex justify-content-end align-items-center">
      <a
        href="javascript:void(0);"
        class="contact-item__edit button-icon button-icon--large"
        role="button"
        @click="handleEdit"
      >
        <i class="la la-pencil"></i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["contact"],

  data: () => ({}),

  // watch: {
  //   contact: function (newContact) {
  //     this.contact = newContact;
  //   },
  // },

  computed: {
    contactFullName() {
      return `${this.contact.prename} ${this.contact.name}`;
    },
  },

  methods: {
    handleEdit() {
      this.$emit('edit', this.contact);
    }
  },
};
</script>
