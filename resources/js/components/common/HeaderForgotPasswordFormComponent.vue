<template>
  <div class="forgot-password-wrapper">
    <form
      novalidate
      @submit.prevent="validate"
      id="formForgotPassword"
      class="form-forgot-password"
      v-if="currentStep === 1"
    >
      <div class="form-field mb-3">
        <input
          v-model="email"
          type="text"
          name="email"
          placeholder="Enter your email address"
          :class="{
            'form-control': true,
            'is-invalid': emailErrors.length > 0,
          }"
          required
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
      <div class="mt-2">
        <button type="submit" class="btn2">Continue</button>
        <button type="button" class="btn mt-2" @click="handleBackToLogin">Back to login</button>
      </div>
    </form>
    <header-forgot-password-step-two-form-component
      :email="email"
      @back="handleBackToLogin"
      @complete="handleCompleteStepTwo"
      v-if="currentStep === 2"
    />
    <header-forgot-password-step-three-form-component
      :email="email"
      :code="code"
      @back="handleBackToLogin"
      @complete="handleCompleteStepThree"
      v-if="currentStep === 3"
    />
  </div>
</template>
<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";

/* Components */
import HeaderForgotPasswordStepTwoFormComponent from './HeaderForgotPasswordStepTwoFormComponent.vue';
import HeaderForgotPasswordStepThreeFormComponent from './HeaderForgotPasswordStepThreeFormComponent.vue';

export default {
  name: "FormForgotPassword",
  mixins: [validationMixin],
  validations: {
    email: {
      required,
      email,
    },
  },

  components: {
    HeaderForgotPasswordStepTwoFormComponent,
    HeaderForgotPasswordStepThreeFormComponent,
  },

  data: () => ({
    email: null,
    code: null,
    currentStep: 1,
  }),

  computed: {
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.required &&
        errors.push("Please enter your email address.");
      !this.$v.email.email &&
        errors.push("Please enter a valid email address.");
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
        .post(`${window.location.origin}/api/password/email`, {
          email: this.email,
        })
        .then((response) => {
          const { data } = response;

          setTimeout(() => {
            // Complete step one
            this.handleCompleteStepOne();

            // Hide loading
            this.$store.commit('setLoading', false);
          }, 1000);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit("setLoading", false);
          this.$store.commit("openNotification", {
            message: "Your email is invalid!",
            type: "error",
          });
          setTimeout(() => {
            this.$store.commit('closeNotification');
          }, 2000);
        });
    },

    handleCompleteStepOne() {
      this.currentStep = 2;
    },

    handleCompleteStepTwo(code) {
      this.code = code;
      this.currentStep = 3;
    },

    handleCompleteStepThree() {
      this.$emit('complete');
    },

    handleBackToLogin() {
      this.$emit('back');
    },

    clearForm () {
      this.$v.$reset();
      this.email = null;
    },
  },
}

</script>
