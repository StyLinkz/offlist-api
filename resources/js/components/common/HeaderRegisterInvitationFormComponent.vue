<template>
  <form
    novalidate
    @submit.prevent="validate"
    id="formRegisterInvitation"
    class="form-register-invitation"
  >
    <h4 class="register-invitation-description text-center mb-4">
      This marketplace is closed and is only available to invited users.
    </h4>
    <div class="form-field mb-4">
      <input
        v-model="invitationCode"
        type="text"
        name="invitationCode"
        placeholder="Your invitation code"
        id="registerInvitationCode"
        :class="{
          'form-control': true,
          'is-invalid': invitationCodeErrors.length > 0
        }"
        required
        :error-messages="invitationCodeErrors"
        @input="$v.invitationCode.$touch()"
        @blur="$v.invitationCode.$touch()"
      />
      <div
        class="invalid-feedback text-left"
        v-show="invitationCodeErrors.length > 0"
      >
        {{ invitationCodeErrors[0] }}
      </div>
    </div>
    <div class="mt-4">
      <button type="submit" class="btn2">Continue</button>
      <button type="button" class="btn mt-2" @click="handleClose">
        Close
      </button>
    </div>
  </form>
</template>
<script>
import axios from 'axios';
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';

export default {
  name: 'FormRegisterInvitation',
  mixins: [validationMixin],
  validations: {
    invitationCode: {
      required
    }
  },

  data: () => ({
    invitationCode: null
  }),

  computed: {
    invitationCodeErrors() {
      const errors = [];
      if (!this.$v.invitationCode.$dirty) return errors;
      !this.$v.invitationCode.required &&
        errors.push('Please enter your invitation code.');
      return errors;
    }
  },

  methods: {
    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.submit();
      }
    },

    submit() {
      // Show loading
      this.$store.commit('setLoading', true);

      // Handle submit here
      axios
        .post('https://offlist.de/api/check-invitation', {
          code: this.invitationCode
        })
        .then(response => {
          const { data } = response;

          // Redirect to the offer list page
          setTimeout(() => {
            // Clear form
            this.clearForm();

            // Close notification
            this.$store.commit('closeNotification');

            // Hide loading
            this.$store.commit('setLoading', false);

            // Trigger save invitation onto the parent component
            this.$emit('onSuccess', data);

            // Close sign-in popup
            this.$store.commit('closeSignInModal');
          }, 2000);
        })
        .catch(error => {
          console.log({ error });
          this.$store.commit('setLoading', false);
          this.$store.commit('openNotification', {
            message: 'Your invitation code is invalid!',
            type: 'error'
          });
          setTimeout(() => {
            this.$store.commit('closeNotification');
          }, 2000);
        });
    },

    handleClose() {
      this.$store.commit('closeSignUpModal');
    },

    clearForm() {
      this.$v.$reset();
      this.invitationCode = null;
    }
  }
};
</script>
