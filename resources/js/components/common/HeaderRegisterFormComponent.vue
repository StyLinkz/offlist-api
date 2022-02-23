<template>
  <div class="form-register-wrapper">
    <form
      novalidate
      @submit.prevent="validate"
      id="formRegister"
      class="form-register"
      v-if="!isRegisterSuccess"
    >
      <div class="row">
        <div class="col-lg-6">
          <div class="form-field mb-4">
            <label
              for="registerPrename"
              class="control-label mb-1"
            >
              Prename <span class="text--error">*</span>
            </label>
            <input
              v-model="prename"
              type="text"
              name="prename"
              id="registerPrename"
              placeholder="Your prename"
              :class="{
                'form-control': true,
                'is-invalid': prenameErrors.length > 0,
              }"
              required
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
        <div class="col-lg-6">
          <div class="form-field mb-4">
            <label
              for="registerName"
              class="control-label mb-1"
            >
              Name <span class="text--error">*</span>
            </label>
            <input
              v-model="name"
              type="text"
              name="name"
              placeholder="Your name"
              id="registerName"
              :class="{
                'form-control': true,
                'is-invalid': nameErrors.length > 0,
              }"
              required
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
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="form-field mb-4">
            <label
              for="registerEmail"
              class="control-label mb-1"
            >
              Email address <span class="text--error">*</span>
            </label>
            <input
              v-model="email"
              type="email"
              name="email"
              placeholder="Your email address"
              id="registerEmail"
              :class="{
                'form-control': true,
                'is-invalid': emailErrors.length > 0,
              }"
              required
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
        <div class="col-lg-6">
          <div class="form-field mb-4">
            <label
              for="registerPhone"
              class="control-label mb-1"
            >
              Phone
            </label>
            <input
              v-model="phone"
              type="text"
              name="phone"
              id="registerPhone"
              class="form-control"
            />
          </div>
        </div>
      </div>
      <div class="form-field mb-4">
        <label
          for="registerCompany"
          class="control-label mb-1"
        >
          Company name
        </label>
        <input
          v-model="company"
          type="text"
          name="company"
          id="registerCompany"
          class="form-control"
        />
      </div>
      <div class="row">
        <div class="col-lg-6">
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
              id="registerPassword"
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
        </div>
        <div class="col-lg-6">
          <div class="form-field mb-3">
            <label
              for="registerConfirmPassword"
              class="control-label mb-1"
            >
              Confirm password <span class="text--error">*</span>
            </label>
            <input
              v-model="confirmPassword"
              type="password"
              name="confirm_password"
              placeholder="Your confirm password"
              id="registerConfirmPassword"
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
        </div>
      </div>
      <div class="form-cp">
        <div class="form-field">
          <div class="input-field">
            <input type="checkbox" name="ccc" id="cc2" />
            <label for="cc2">
              <span></span>
              <small>I agree with terms</small>
            </label>
          </div>
        </div>
        <a href="javascript:void(0);" title="Have an account?" class="signin-op">Have an account?</a>
      </div>
      <!--form-cp end-->
      <div class="mt-5">
        <button type="submit" class="btn2">Register</button>
        <button type="button" class="btn mt-2" @click="handleClose">
          Close
        </button>
      </div>
    </form>
    <div class="form-register-message" v-else>
      <h4 class="text-center mt-5 mb-4">
        We have sent a verifcation link to your email address. Please verify.
      </h4>
      <button
        type="button"
        class="btn2"
        @click="handleClose"
      >
        Close
      </button>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required, email, sameAs } from "vuelidate/lib/validators";

export default {
  name: "FormRegister",
  props: ['invitation'],
  mixins: [validationMixin],
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
    password: {
      required,
    },
    confirmPassword: {
      required,
      sameAsPassword: sameAs('password')
    },
  },

  data: () => ({
    prename: null,
    name: null,
    email: null,
    phone: null,
    company: null,
    password: null,
    confirmPassword: null,
    offerTypes: [],
    isRegisterSuccess: false,
  }),

  created() {
    if (this.invitation) {
      this.prename = this.invitation.receiver_prename;
      this.name = this.invitation.receiver_name;
      this.email = this.invitation.receiver_email;
    }
  },

  computed: {
    prenameErrors() {
      const errors = [];
      if (!this.$v.prename.$dirty) return errors;
      !this.$v.prename.required &&
        errors.push("Please enter your prename.");
      return errors;
    },

    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.required &&
        errors.push("Please enter your name.");
      return errors;
    },

    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.required &&
        errors.push("Please enter your email address.");
      !this.$v.email.email &&
        errors.push("Please enter a valid email address.");
      return errors;
    },

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
        .post("https://offlist.de/api/register", {
          prename: this.prename,
          name: this.name,
          email: this.email,
          phone: this.phone,
          company: this.company,
          password: this.password,
          password_confirmation: this.confirmPassword,
          offer_types: this.offerTypes.join(','),
        })
        .then((response) => {
          const { data } = response.data;

          // Update invitation
          axios
            .post(`https://offlist.de/api/update-invitation/${this.invitation.id}`, {
              status: 'accepted',
              contact_prename: this.prename,
              contact_name: this.name,
              contact_email: this.email,
              contact_user_id: data['id'].toString()
            })
            .then(() => {
              this.isRegisterSuccess = true;
              this.$emit('registerSuccess');
            });

          // Redirect to the offer list page
          setTimeout(() => {
            // Clear form
            this.clearForm();

            // Hide loading
            this.$store.commit('setLoading', false);
          }, 2000);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit("setLoading", false);
          this.$store.commit("openNotification", {
            message: "Register failed! Please try again later",
            type: "error",
          });
        });
    },

    handleClose() {
      this.$store.commit('closeSignUpModal');
    },

    clearForm () {
      this.$v.$reset();
      this.name = null;
      this.prename = null;
      this.email = null;
      this.phone = null;
      this.company = null;
      this.password = null;
      this.confirmPassword = null;
    },
  },
};

</script>
