<template>
  <form
    novalidate
    @submit.prevent="validate"
    id="formForgotPasswordStepThree"
    class="form-forgot-password-step-3"
  >
    <h4 class="forgot-password-description text-center mb-4">
      Please enter your new passwords.
    </h4>
    <div class="form-field mb-3">
      <label
        for="registerPassword"
        class="control-label mb-1"
      >
        Password <span class="text--error">*</span>
      </label>
      <input
        v-model="password"
        type="password"
        name="password"
        placeholder="Your password"
        id="resetPassword"
        :class="{
          'form-control': true,
          'is-invalid': passwordErrors.length > 0,
        }"
        required
        @input="$v.password.$touch()"
        @blur="$v.password.$touch()"
      />
      <div
        class="invalid-feedback text-left"
        v-show="passwordErrors.length > 0"
      >
        {{ passwordErrors[0] }}
      </div>
    </div>
    <div class="form-field mb-3">
      <label
        for="resetConfirmPassword"
        class="control-label mb-1"
      >
        Confirm password <span class="text--error">*</span>
      </label>
      <input
        v-model="confirmPassword"
        type="password"
        name="confirm_password"
        placeholder="Your confirm password"
        id="resetConfirmPassword"
        :class="{
          'form-control': true,
          'is-invalid': confirmPasswordErrors.length > 0,
        }"
        required
        @input="$v.confirmPassword.$touch()"
        @blur="$v.confirmPassword.$touch()"
      />
      <div
        class="invalid-feedback text-left"
        v-show="confirmPasswordErrors.length > 0"
      >
        {{ confirmPasswordErrors[0] }}
      </div>
    </div>
    <div class="mt-2">
      <button type="submit" class="btn2">Reset</button>
      <button type="button" class="btn mt-2" @click="handleBackToLogin">
        Back to login
      </button>
    </div>
  </form>
</template>
<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required, sameAs } from "vuelidate/lib/validators";

export default {
  name: "FormForgotPasswordStepTwo",
  props: ['email', 'code'],
  mixins: [validationMixin],
  validations: {
    password: {
      required,
    },
    confirmPassword: {
      required,
      sameAsPassword: sameAs('password')
    },
  },

  data: () => ({
    password: null,
    confirmPassword: null,
  }),

  computed: {
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required && errors.push("Please enter your password.");
      return errors;
    },

    confirmPasswordErrors() {
      const errors = [];
      if (!this.$v.confirmPassword.$dirty) return errors;
      !this.$v.confirmPassword.required && errors.push("Please enter your confirm password.");
      !this.$v.confirmPassword.sameAsPassword && errors.push("Passwords do not match.");
      return errors;
    },
  },

  methods: {
    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.submit();
      }
    },

    submit () {
      // Show loading
      this.$store.commit("setLoading", true);

      // Handle submit here
      axios
        .post("https://offlist.de/api/password/reset", {
          token: this.code,
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          const { data } = response;

          // Show success notification
          this.$store.commit('openNotification', {
            message: "Your password has been changed successfully!",
            type: "success",
          });

          setTimeout(() => {
            // Close notification
            this.$store.commit('closeNotification');

            // Complete all steps
            this.$emit('complete');

            // Hide loading
            this.$store.commit('setLoading', false);
          }, 2000);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit("setLoading", false);
          this.$store.commit("openNotification", {
            message: "Your code is invalid!",
            type: "error",
          });
          setTimeout(() => {
            this.$store.commit('closeNotification');
          }, 2000);
        });
    },

    handleBackToLogin() {
      this.$emit('back');
    },

    clearForm () {
      this.$v.$reset();
    },
  },
}

</script>
