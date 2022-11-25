<template>
  <div class="my-profile-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>Change password</h3>
        </div>
        <!--pager-sec-details end-->
      </div>
    </section>
    <section class="section-padding">
      <div class="container">
        <div class="blog-single-details">
          <form
            novalidate
            @submit.prevent="validate"
            id="formChangePassword"
            class="form-editproperty form-horizontal selio-form"
            method="post"
          >
            <div class="row">
              <div class="col-lg-8">
                <div class="blog-posts">
                  <div class="blog-single-post status-publish hentry">
                    <div class="post_info" style="border-top: 1px solid #dfe0e5;">
                      <div class="post-content clearfix">
                        <div class="selio_sw_win_wrapper">
                          <div class="ci sw_widget sw_wrap">
                            <div class="bootstrap-wrapper quick-submission">
                              <div
                                id="quick_submission_form"
                                class="widget widget-styles clearfix mb-0"
                              >
                                <div class="content-box">
                                  <div class="row">
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="userPassword"
                                        class="control-label"
                                      >
                                        Current password
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="currentPassword"
                                          type="password"
                                          name="current_password"
                                          placeholder="Enter your current password"
                                          :class="{
                                            'form-control': true,
                                            'is-invalid': currentPasswordErrors.length > 0,
                                          }"
                                          id="userPassword"
                                          required
                                          :error-messages="currentPasswordErrors"
                                          @input="$v.currentPassword.$touch()"
                                          @blur="$v.currentPassword.$touch()"
                                        />
                                        <div
                                          class="invalid-feedback text-left"
                                          v-show="currentPasswordErrors.length > 0"
                                        >
                                          {{ currentPasswordErrors[0] }}
                                        </div>
                                      </div>
                                      <!--form-field end-->
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="userNewPassword"
                                        class="control-label"
                                      >
                                        New password
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="password"
                                          type="password"
                                          name="password"
                                          placeholder="Enter your new password"
                                          :class="{
                                            'form-control': true,
                                            'is-invalid': passwordErrors.length > 0,
                                          }"
                                          id="userPassword"
                                          required
                                          :error-messages="passwordErrors"
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
                                      <!--form-field end-->
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="userConfirmPassword"
                                        class="control-label"
                                      >
                                        Confirm password
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="confirmPassword"
                                          type="password"
                                          name="confirmPassword"
                                          placeholder="Enter your confirm password"
                                          :class="{
                                            'form-control': true,
                                            'is-invalid': confirmPasswordErrors.length > 0,
                                          }"
                                          id="userConfirmPassword"
                                          required
                                          :error-messages="confirmPasswordErrors"
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
                                      <!--form-field end-->
                                    </div>
                                    <div
                                      class="
                                        d-flex
                                        justify-content-end
                                        border-top
                                        pt-4
                                        mt-5
                                        w-100
                                      "
                                    >
                                      <button
                                        type="submit"
                                        class="btn btn-primary"
                                      >
                                        Save
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required, sameAs } from "vuelidate/lib/validators";
import "jquery-ui";
import "jquery-ui/ui/widgets/sortable";
import "jquery-ui/ui/disable-selection";

/* Layout */
import HeaderComponent from "./HeaderComponent.vue";
import FooterComponent from "./FooterComponent.vue";

export default {
  name: "FormChangePassword",
  components: {
    HeaderComponent,
    FooterComponent,
  },
  mixins: [validationMixin],
  validations: {
    currentPassword: {
      required,
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
    currentPassword: '',
    password: '',
    confirmPassword: '',
    isProcessing: false,
  }),

  computed: {
    currentPasswordErrors() {
      const errors = [];
      if (!this.$v.currentPassword.$dirty) return errors;
      !this.$v.currentPassword.required && errors.push("Please enter your current password.");
      return errors;
    },
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required &&
        errors.push("Please enter your new password.");
      return errors;
    },
    confirmPasswordErrors() {
      const errors = [];
      if (!this.$v.confirmPassword.$dirty) return errors;
      !this.$v.confirmPassword.required && errors.push("Please enter the confirm password.");
      !this.$v.confirmPassword.sameAsPassword && errors.push("Passwords do not match.");
      return errors;
    },
  },

  methods: {
    isRegularUser () {
      const user = JSON.parse(localStorage.getItem('user'))
      return user && user.role === 'user';
    },

    isLoggedIn () {
      const user = localStorage.getItem('user')
        ? JSON.parse(localStorage.getItem('user'))
        : null;
      return user && user.api_token;
    },

    clearForm () {
      this.$v.$reset();
      this.password = '';
      this.confirmPassword = '';
      this.currentPassword = '';
    },

    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.submit();
      }
    },

    submit() {
      // Show loading
      this.$store.commit('setLoading', true);

      const user = JSON.parse(localStorage.getItem('user'));
      const url = `${window.location.origin}/api/change-password`;
      const data = {
        "current_password": this.currentPassword,
        "password": this.password,
        "confirm_password": this.confirmPassword,
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
            // Open success notification
            this.$store.commit('openNotification', {
              message: 'Your password has been updated successfully!',
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
            message: error.response.data,
            type: 'error',
          });
        });
    },
  },
}
</script>
