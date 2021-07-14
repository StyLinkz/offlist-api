<template>
  <div
    class="modal modal-edit-contact fade"
    id="modalEditContact"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalEditContactLabel"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form
          novalidate
          @submit.prevent="validate"
          id="formEditContact"
          class="form-editproperty form-horizontal selio-form"
          method="post"
        >
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditContactLabel">
              Edit Contact
            </h5>
          </div>
          <div class="modal-body">
            <div
              class="
                contact-new-avatar
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <img
                :src="avatarPreview"
                :alt="`${prename} ${name}`"
                class="rounded-circle img--cover"
              />
              <div class="upload-btn-wrapper upload-contact-avatar-btn ml-3">
                <input
                  name="avatar"
                  type="file"
                  id="contactAvatar"
                  @change="handleChangeAvatar"
                />
                <label for="contactAvatar">
                  <i class="la la-edit"></i>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label
                for="contactPrename"
                class="control-label"
              >
                Prename
              </label>
              <div class="form-field">
                <input
                  v-model="prename"
                  type="text"
                  name="prename"
                  id="contactPrename"
                  class="form-control"
                  :class="{
                    'is-invalid': prenameErrors.length > 0,
                  }"
                  :error-messages="prenameErrors"
                  @input="$v.prename.$touch()"
                  @blur="$v.prename.$touch()"
                />
                <div
                  class="invalid-feedback text-left"
                  v-show="prenameErrors.length > 0"
                >
                  {{ prenameErrors[0] }}
                </div>
              </div>
            </div>
            <div class="form-group">
              <label
                for="contactName"
                class="control-label"
              >
                Name
              </label>
              <div class="form-field">
                <input
                  v-model="name"
                  type="text"
                  name="name"
                  id="contactName"
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
                for="contactEmail"
                class="control-label"
              >
                Email address
              </label>
              <div class="form-field">
                <input
                  v-model="email"
                  type="text"
                  name="email"
                  id="contactEmail"
                  class="form-control"
                  :class="{
                    'is-invalid': emailErrors.length > 0,
                  }"
                  :error-messages="emailErrors"
                  @input="$v.email.$touch()"
                  @blur="$v.email.$touch()"
                />
                <div
                  class="invalid-feedback text-left"
                  v-show="emailErrors.length > 0"
                >
                  {{ emailErrors[0] }}
                </div>
              </div>
            </div>
            <div class="form-group">
              <label
                for="contactPhone"
                class="control-label"
              >
                Phone
              </label>
              <div class="form-field">
                <input
                  v-model="phone"
                  type="text"
                  name="phone"
                  id="contactPhone"
                  class="form-control"
                />
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
              Send
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
import { required, email } from "vuelidate/lib/validators";

export default {
  props: ['contact'],
  mixins: [validationMixin],
  name: "FormEditContact",
  validations: {
    prename: {
      required,
    },
    name: {
      required,
    },
    email: {
      required,
      email,
    },
  },

  data: () => ({
    prename: '',
    name: '',
    email: '',
    phone: '',
    avatar: '',
    uploadedAvatar: '',
    avatarPreview: "https://via.placeholder.com/200x200",
  }),

  watch: {
    contact: function (newContact) {
      this.prename = newContact.prename;
      this.name = newContact.name;
      this.email = newContact.email;
      this.phone = newContact.phone;
      this.avatar = newContact.avatar;
      this.avatarPreview = newContact.avatar;
    },
  },

  created() {
    if (this.contact) {
      this.prename = this.contact.prename;
      this.name = this.contact.name;
      this.email = this.contact.email;
      this.phone = this.contact.phone;
      this.avatar = this.contact.avatar;
      this.avatarPreview = this.contact.avatar;
    }
  },

  computed: {
    prenameErrors() {
      const errors = [];
      if (!this.$v.prename.$dirty) return errors;
      !this.$v.prename.required &&
        errors.push("Please enter the prename.");

      return errors;
    },

    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.required &&
        errors.push("Please enter the name.");

      return errors;
    },

    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.required &&
        errors.push("Please enter the email.");
      !this.$v.email.email &&
        errors.push("Please enter a valid email.");

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

      const uploadedAvatar = await this.handleUploadAvatar();
      const user = JSON.parse(localStorage.getItem('user'));
      const url = `https://offlist.de/api/contacts/${this.contact.id}`;
      const data = {
        prename: this.prename,
        name: this.name,
        email: this.email,
        phone: this.phone,
        avatar: !!uploadedAvatar ? uploadedAvatar : (this.avatar || ""),
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
            this.$store.commit('openNotification', {
              message: 'Your contact has been updated successfully!',
              type: 'success',
            });

            // Update the selected contact in the list
            this.$emit('update', {
              ...this.contact,
              ...data,
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

    async handleUploadAvatar() {
      const user = JSON.parse(localStorage.getItem("user"));
      let contactAvatar = "";

      if (this.uploadedAvatar) {
        const formData = new FormData();
        formData.append("file[]", this.uploadedAvatar);
        contactAvatar = await axios
          .post("https://offlist.de/api/offer-images", formData, {
            headers: {
              Authorization: `Bearer ${user.api_token}`,
            },
          })
          .then(({ data }) => data["files"][0]["url"]);
      }

      return contactAvatar;
    },

    handleChangeAvatar(event) {
      const reader = new FileReader();
      const file = event.target.files[0];

      reader.onload = () => {
        this.avatarPreview = reader.result;
      };
      reader.readAsDataURL(file);

      this.uploadedAvatar = file;
    },

    closeModal() {
      $('#modalEditContact').modal('hide');
    }
  },
};
</script>
