<template>
  <div class="my-profile-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>Profile</h3>
        </div>
        <!--pager-sec-details end-->
      </div>
    </section>
    <section class="blog-standard section-padding">
      <div class="container">
        <div class="blog-single-details">
          <form
            novalidate
            @submit.prevent="validate"
            id="formProfile"
            class="form-editproperty form-horizontal selio-form"
            method="post"
          >
            <div class="row">
              <div class="col-lg-8">
                <div class="blog-posts">
                  <div class="blog-single-post status-publish hentry">
                    <div class="post_info">
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
                                        for="profilePrename"
                                        class="control-label"
                                      >
                                        Your prename
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="prename"
                                          type="text"
                                          name="prename"
                                          :class="{
                                            'form-control': true,
                                            'is-invalid': prenameErrors.length > 0,
                                          }"
                                          id="profilePrename"
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
                                      <!--form-field end-->
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="profileName"
                                        class="control-label"
                                      >
                                        Your name
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="name"
                                          type="text"
                                          name="name"
                                          :class="{
                                            'form-control': true,
                                            'is-invalid': nameErrors.length > 0,
                                          }"
                                          id="profileName"
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
                                      <!--form-field end-->
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="profileEmail"
                                        class="control-label"
                                      >
                                        Email
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="email"
                                          type="email"
                                          name="email"
                                          :class="{
                                            'form-control': true,
                                            'is-invalid': emailErrors.length > 0,
                                          }"
                                          id="profileEmail"
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
                                      <!--form-field end-->
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="profilePhone"
                                        class="control-label"
                                      >
                                        Phone number
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="phone"
                                          type="text"
                                          name="phone"
                                          id="profilePhone"
                                        />
                                      </div>
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="profileCompany"
                                        class="control-label"
                                      >
                                        Company
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="company"
                                          type="text"
                                          name="company"
                                          id="profileCompany"
                                        />
                                      </div>
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="profileAddress"
                                        class="control-label"
                                      >
                                        Address
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="address"
                                          type="text"
                                          name="address"
                                          id="profileAddress"
                                        />
                                      </div>
                                    </div>
                                    <div class="form-group IS-INPUTBOX">
                                      <label
                                        for="profileWebsite"
                                        class="control-label"
                                      >
                                        Website
                                      </label>
                                      <div class="form-field">
                                        <input
                                          v-model="website"
                                          type="text"
                                          name="website"
                                          id="profileWebsite"
                                        />
                                      </div>
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
import { required, email, numeric } from "vuelidate/lib/validators";
import "jquery-ui";
import "jquery-ui/ui/widgets/sortable";
import "jquery-ui/ui/disable-selection";

/* Layout */
import HeaderComponent from "./HeaderComponent.vue";
import FooterComponent from "./FooterComponent.vue";

export default {
  name: "FormProfile",
  components: {
    HeaderComponent,
    FooterComponent,
  },
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
  },

  data: () => ({
    prename: '',
    name: '',
    email: '',
    phone: '',
    company: '',
    address: '',
    website: '',
    isProcessing: false,
  }),

  computed: {
    prenameErrors() {
      const errors = [];
      if (!this.$v.prename.$dirty) return errors;
      !this.$v.prename.required && errors.push("Please enter your prename.");
      return errors;
    },
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.required && errors.push("Please enter your name.");
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
  },

  created () {
    const user = JSON.parse(localStorage.getItem("user"));
    axios.get(`${window.location.origin}/api/profile`, {
      headers: { Authorization: `Bearer ${user.api_token}` },
    }).then((profileResponse) => {
      if (profileResponse.status === 200) {
        const { data } = profileResponse;
        this.prename = data.prename;
        this.name = data.name;
        this.email = data.email;
        this.phone = data.phone || '';
        this.company = data.company || '';
        this.address = data.address || '';
        this.website = data.website || '';
      }
    });
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
      const url = `${window.location.origin}/api/profile`;
      const data = {
        "name": this.name,
        "prename": this.prename,
        "email": this.email,
        "phone": this.phone,
        "company": this.company,
        "address": this.address,
        "website": this.website,
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
              message: 'Your profile has been updated successfully!',
              type: 'success',
            });

            // Redirect to the offer list page
            setTimeout(() => {
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
            message: 'Failed! Please try to update later',
            type: 'error',
          });
        });
    },

    async getProfile() {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get(`${window.location.origin}/api/profile`, {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },
  },
}
</script>
