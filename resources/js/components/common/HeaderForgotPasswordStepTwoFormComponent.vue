<template>
  <form
    novalidate
    @submit.prevent="validate"
    id="formForgotPasswordStepTwo"
    class="form-forgot-password-step-2"
  >
    <h4 class="forgot-password-description text-center mb-4">
      We have sent a verifcation code to your email address.
    </h4>
    <div class="form-field mb-3">
      <input
        v-model="code"
        type="text"
        name="code"
        placeholder="Enter your code"
        :class="{
          'form-control': true,
          'is-invalid': codeErrors.length > 0,
        }"
        required
        :error-messages="codeErrors"
        @input="$v.code.$touch()"
        @blur="$v.code.$touch()"
      />
      <div
        class="invalid-feedback text-left"
        v-show="codeErrors.length > 0"
      >
        {{ codeErrors[0] }}
      </div>
    </div>
    <div class="mt-2">
      <button type="submit" class="btn2">Continue</button>
      <button type="button" class="btn mt-2" @click="handleBackToLogin">Back to login</button>
    </div>
  </form>
</template>
<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "FormForgotPasswordStepTwo",
  props: ['email'],
  mixins: [validationMixin],
  validations: {
    code: {
      required,
    },
  },

  data: () => ({
    code: null,
  }),

  computed: {
    codeErrors() {
      const errors = [];
      if (!this.$v.code.$dirty) return errors;
      !this.$v.code.required &&
        errors.push("Please enter your code.");
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
        .post(`${window.location.origin}/api/password/verify`, {
          token: this.code,
          email: this.email,
        })
        .then((response) => {
          const { data } = response;

          setTimeout(() => {
            // Update step
            this.$emit('complete', this.code);

            // Hide loading
            this.$store.commit('setLoading', false);
          }, 1000);
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
      this.code = null;
    },
  },
}

</script>
