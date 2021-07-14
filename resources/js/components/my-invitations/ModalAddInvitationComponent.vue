<template>
  <div
    class="modal modal-add-invitation fade"
    id="modalAddInvitation"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalAddInvitationLabel"
    aria-hidden="true"
    data-backdrop="static"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form
          novalidate
          @submit.prevent="validate"
          id="formAddInvitation"
          class="form-editproperty form-horizontal selio-form"
          method="post"
        >
          <div class="modal-header">
            <h5 class="modal-title" id="modalAddInvitationLabel">
              Add Invitation
            </h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label
                for="invitationPrename"
                class="control-label"
              >
                Prename
              </label>
              <div class="form-field">
                <input
                  v-model="prename"
                  type="text"
                  name="prename"
                  id="invitationPrename"
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
                for="invitationName"
                class="control-label"
              >
                Name
              </label>
              <div class="form-field">
                <input
                  v-model="name"
                  type="text"
                  name="name"
                  id="invitationName"
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
                for="invitationEmail"
                class="control-label"
              >
                Email address
              </label>
              <div class="form-field">
                <input
                  v-model="email"
                  type="text"
                  name="email"
                  id="invitationEmail"
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
  mixins: [validationMixin],
  name: "FormAddInvitation",
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
  }),

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

    submit() {
      this.$store.commit('setLoading', true);

      const user = JSON.parse(localStorage.getItem('user'));
      const url = 'https://offlist.de/api/invitations';
      const data = {
        receiver_prename: this.prename,
        receiver_name: this.name,
        receiver_email: this.email,
      };

      axios({
        method: 'post',
        url,
        data,
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((response) => {
          if (response.status === 201) {
            this.$store.commit('openNotification', {
              message: 'Your invitation has been sent successfully!',
              type: 'success',
            });

            // Redirect to the offer list page
            setTimeout(() => {
              // Clear form
              this.clearForm();

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
            message: 'Failed! Please try to send later',
            type: 'error',
          });
        });
    },

    clearForm() {
      this.$v.$reset();
      this.prename = '';
      this.name = '';
      this.email = '';
    },
  },
};
</script>
