<template>
  <div
    class="modal modal-edit-group fade"
    id="modalEditGroup"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalEditGroupLabel"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form
          novalidate
          @submit.prevent="validate"
          id="formEditGroup"
          class="form-editproperty form-horizontal selio-form"
          method="post"
        >
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditGroupLabel">
              {{ !!group ? 'Edit Group' : 'Add Group' }}
            </h5>
          </div>
          <div class="modal-body">
            <div class="modal-edit-group__main">
              <div class="form-group">
                <label
                  for="groupName"
                  class="control-label"
                >
                  Name
                </label>
                <div class="form-field">
                  <input
                    v-model="name"
                    type="text"
                    name="name"
                    id="groupName"
                    class="form-control"
                    :class="{
                      'is-invalid': nameErrors.length > 0,
                    }"
                    :error-messages="nameErrors"
                    @input="$v.name.$touch()"
                    @blur="$v.name.$touch()"
                  />
                  <div
                    class="invalid-feedback text-left"
                    v-show="nameErrors.length > 0"
                  >
                    {{ nameErrors[0] }}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label
                  for="groupDescription"
                  class="control-label"
                >
                  Description
                </label>
                <div class="form-field">
                  <textarea
                    v-model="description"
                    name="description"
                    id="groupDescription"
                    class="form-control"
                  ></textarea>
                </div>
              </div>
              <div class="group-contacts">
                <h4 class="group-contacts__title">Members</h4>
                <div class="group-contacts__search mt-2">
                  <div class="form-group">
                    <div class="form-field">
                      <input
                        v-model="search"
                        type="text"
                        name="search"
                        id="groupSearch"
                        class="form-control"
                        placeholder="Search members"
                        @input="handleSearch"
                      />
                    </div>
                  </div>
                </div>
                <div class="group-contact-list" v-if="searchContacts && searchContacts.length">
                  <div
                    v-for="contact in searchContacts"
                    :key="`group_contact_${contact.id}`"
                    class="group-contact d-flex justify-content-between align-items-center py-3"
                  >
                    <div class="group-contact__content d-flex align-items-center">
                      <div class="group-contact__avatar rounded-circle p-1 mr-3">
                        <img
                          :src="contact.avatar"
                          :alt="`${contact.prename} ${contact.name}`"
                          class="rounded-circle img--cover"
                        />
                      </div>
                      <div class="group-contact__info d-flex flex-column">
                        <span class="group-contact__name">
                          {{ `${contact.prename} ${contact.name}` }}
                        </span>
                        <a :href="`mailTo:${contact.email}`" class="group-contact__email d-flex align-items-center mt-1">
                          <i class="la la-envelope"></i>
                          <span class="ml-2">{{ contact.email }}</span>
                        </a>
                        <a :href="`tel:${contact.phone}`" class="group-contact__phone d-flex align-items-center mt-1">
                          <i class="la la-phone"></i>
                          <span class="ml-2">{{ contact.phone }}</span>
                        </a>
                      </div>
                    </div>
                    <i class="group-contact__icon la la-check" v-if="isContactSelected(contact)"></i>
                    <a
                      href="javascript:void(0);"
                      class="group-contact__select"
                      :class="{ selected: isContactSelected(contact) }"
                      role="button"
                      @click="toggleSelect(contact)"
                    >
                      Select contact
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              type="submit"
              class="btn btn-primary"
            >
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END modal-offer-groups -->
</template>
<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  props: ['group', 'allContacts'],
  mixins: [validationMixin],
  name: "FormEditGroup",
  validations: {
    name: {
      required,
    },
  },

  data: () => ({
    name: '',
    description: '',
    contacts: [],
    search: '',
    searchContacts: [],
  }),

  watch: {
    group: function (newGroup) {
      if (newGroup) {
        this.name = newGroup.name;
        this.description = newGroup.description;
        this.contacts = newGroup.contacts;
      } else {
        this.name = '';
        this.description = '';
        this.contacts = [];
        this.search = '';
        this.searchContacts = this.allContacts;
      }
    },
    allContacts: function (newAllContacts) {
      this.searchContacts = newAllContacts;
    },
  },

  created() {
    if (this.group) {
      this.name = this.group.name;
      this.description = this.group.description;
      this.contacts = this.group.contacts;
    }
  },

  computed: {
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.required &&
        errors.push("Please enter the name.");
      return errors;
    },
  },

  methods: {
    validate() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.$store.commit('openNotification', {
          message: "Some data are not valid!",
          type: "error",
        });
        setTimeout(() => {
          this.$store.commit('closeNotification');
        }, 3000);
        return;
      }

      /* In case of new offer, just show the available type dialog */
      this.submit();
    },

    async submit() {
      this.$store.commit('setLoading', true);

      const user = JSON.parse(localStorage.getItem('user'));
      const url = this.group
        ? `${window.location.origin}/api/groups/${this.group.id}`
        : `${window.location.origin}/api/groups`;
      const method = this.group ? 'put' : 'post';
      const data = {
        user_id: user.id.toString(),
        name: this.name,
        description: this.description,
        contacts: this.contacts.map((contact) => contact.id),
      };

      axios({
        url,
        method,
        data,
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((response) => {
          if (response.status === 200 || response.status === 201) {
            let message;
            if (response.status === 200) {
              message = 'Your group has been updated successfully!';
            } else {
              message = 'Your group has been created successfully!';
            }
            this.$store.commit('openNotification', {
              message,
              type: 'success',
            });

            // Update the selected group in the list
            const { data } = response;
            this.$emit('update', {
              id: data.id,
              user_id: data.user_id,
              name: data.name,
              description: data.description,
              contacts: this.contacts, // This should be a list of contact objects instead of ids
            });

            // Redirect to the offer list page
            setTimeout(() => {
              // Close notification
              this.$store.commit('closeNotification');

              // Hide loading
              this.$store.commit('setLoading', false);

              // Close modal
              this.closeModal();
            }, 2000);
          }
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit('setLoading', false);
          this.$store.commit('openNotification', {
            message: 'Failed! Please try to send later',
            type: 'error',
          });
        });
    },

    handleSearch() {
      this.searchContacts = this.allContacts.reduce((results, contact) => {
        const nextResults = [...results];
        const { prename, name } = contact;
        const fullName = `${prename} ${name}`.toLowerCase();
        if (fullName.indexOf(this.search.toLowerCase()) !== -1) {
          nextResults.push(contact);
        }
        return nextResults;
      }, []);
    },

    toggleSelect(contact) {
      const contactIndex = this.contacts.findIndex((item) => item.id === contact.id);
      if (contactIndex !== -1) {
        this.contacts.splice(contactIndex, 1);
      } else {
        this.contacts.push(contact);
      }
    },

    isContactSelected(contact) {
      const contactIndex = this.contacts.findIndex((item) => item.id === contact.id);
      return contactIndex !== -1;
    },

    closeModal() {
      $('#modalEditGroup').modal('hide');
    },
  },
};
</script>
