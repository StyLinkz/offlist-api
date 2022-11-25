<template>
  <header :class="{ fix: isFixed }">
    <div class="header__inner">
      <div class="header shd">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <nav class="navbar navbar-expand-lg navbar-light">
                <router-link
                  class="navbar-brand"
                  :to="{name: 'index'}"
                >
                  <img :src="logoImage" alt="offlist" />
                </router-link>
                <button
                  class="menu-button"
                  type="button"
                  data-toggle="collapse"
                  data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent"
                >
                  <span class="icon-spar"></span>
                  <span class="icon-spar"></span>
                  <span class="icon-spar"></span>
                </button>

                <div class="navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item" :class="[{active: $route.name === 'index'}]">
                      <router-link
                        class="nav-link"
                        :to="{name: 'index'}"
                      >
                        Home
                      </router-link>
                    </li>
                    <li
                      class="nav-item"
                      :class="[{active: $route.name === 'offers'}]"
                      v-if="isLoggedIn() && isRegularUser()"
                    >
                      <router-link
                        class="nav-link"
                        :to="{name: 'offers'}"
                      >
                        Public Offerboard
                      </router-link>
                    </li>
                  </ul>
                  <div class="d-inline my-2 my-lg-0">
                    <ul class="navbar-nav">
                      <li class="nav-item signin-btn" v-if="!isLoggedIn()">
                        <a href="#" class="nav-link">
                          <i class="la la-sign-in"></i>
                          <span>
                            <b class="signin-op" @click="handleClickSignInButton">Sign in</b> or
                            <b class="reg-op" @click="handleClickSignUpButton">Register</b>
                          </span>
                        </a>
                      </li>
                      <li class="nav-item nav-item-account dropdown" v-else>
                        <a
                          class="nav-link dropdown-toggle"
                          href="javascript:void(0);"
                          data-toggle="dropdown"
                        >
                          <i class="fa fa-user-circle fa-lg" v-if="!userAvatar"></i>
                          <img class="img--cover" :src="userAvatar" :alt="userFullName" v-else />
                          <span class="ml-2 mr-2">{{ userFullName }}</span>
                        </a>
                        <div class="dropdown-menu">
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myOffers'}"
                          >
                            Offers
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myRequests'}"
                            v-if="isRegularUser()"
                          >
                            Requests
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myApplications'}"
                            v-if="isRegularUser()"
                          >
                            Applications
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myInvitations'}"
                            v-if="isRegularUser()"
                          >
                            Invitations
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myGroups'}"
                            v-if="isRegularUser()"
                          >
                            Groups
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myFavorites'}"
                            v-if="isRegularUser()"
                          >
                            Favorites
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myContacts'}"
                            v-if="isRegularUser()"
                          >
                            Contacts
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'myProfile'}"
                          >
                            My profile
                          </router-link>
                          <router-link
                            class="dropdown-item"
                            :to="{name: 'changePassword'}"
                          >
                            Change password
                          </router-link>
                          <a
                            class="dropdown-item"
                            href="javascript:void(0);"
                            @click="logOut"
                          >Log out</a>
                        </div>
                      </li>
                      <li class="nav-item submit-btn">
                        <a
                          role="button"
                          href="javascript:void(0);"
                          class="my-2 my-sm-0 nav-link sbmt-btn"
                          data-toggle="modal"
                          data-target="#modalSubmitListing"
                          v-if="isLoggedIn() && isRegularUser()"
                        >
                          <i class="icon-plus"></i>
                          <span>Submit Listing</span>
                        </a>
                        <a
                          role="button"
                          href="javascript:void(0);"
                          class="my-2 my-sm-0 nav-link sbmt-btn"
                          data-toggle="modal"
                          data-target="#modalSubmitFreeListing"
                          v-if="!isLoggedIn() || !isRegularUser()"
                        >
                          <i class="icon-plus"></i>
                          <span>Submit Your Free Offer</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <a href="#" title="" class="close-menu">
                    <i class="la la-close"></i>
                  </a>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <div class="popup" :class="{ active: isSignInModalOpen }" id="sign-popup">
        <h3>
          {{ isForgotPassword ? 'Forgot Password' : 'Sign In to your Account' }}
        </h3>
        <div class="popup-form">
          <form
            novalidate
            @submit.prevent="validate"
            id="formLogin"
            v-if="!isForgotPassword"
            class="form-login"
          >
            <div class="form-field">
              <input
                v-model="email"
                type="text"
                name="email"
                placeholder="Email"
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
            <div class="form-field">
              <input
                v-model="password"
                type="password"
                name="password"
                placeholder="Password"
                :class="{
                  'form-control': true,
                  'is-invalid': passwordErrors.length > 0,
                }"
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
            <div class="form-cp">
              <div class="form-field">
                <div class="input-field">
                  <input type="checkbox" name="ccc" id="cc1" />
                  <label for="cc1">
                    <span></span>
                    <small>Remember me</small>
                  </label>
                </div>
              </div>
              <a
                href="javascript:void(0);"
                role="button"
                title="Forgot Password"
                @click="handleForgotPassword"
              >
                Forgot Password?
              </a>
            </div>
            <!--form-cp end-->
            <button type="submit" class="btn2 mt-4" :loading="isProcessing">
              Sign In
            </button>
            <button type="button" class="btn mt-2" @click="closeSignInModal">
              Close
            </button>
          </form>
          <div class="forgot-passsword" v-else>
            <header-forgot-password-form-component
              @back="handleBackToLogin"
              @complete="handleCompleteForgotPassword"
            />
          </div>
          <!-- <a href="#" title="" class="fb-btn">
            <i class="fa fa-facebook"></i>Sign In With Facebook
          </a> -->
        </div>
      </div>
      <!--popup end-->

      <div
        class="popup"
        :class="{
          active: isSignUpModalOpen,
          'popup--large': !!invitation && !isRegisterSuccess
        }"
        id="register-popup"
      >
        <h3>Register</h3>
        <div class="popup-form">
          <header-register-invitation-form-component
            @onSuccess="handleVerifyInvitationCodeSuccess"
            v-if="!invitation"
          />
          <header-register-form-component
            v-else
            :invitation="invitation"
            @registerSuccess="handleRegisterSuccess"
          />
        </div>
      </div>
      <!--popup end-->
    </div>
  </header>
</template>

<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";

/* Components */
import HeaderRegisterFormComponent from "./common/HeaderRegisterFormComponent.vue";
import HeaderRegisterInvitationFormComponent from "./common/HeaderRegisterInvitationFormComponent.vue";
import HeaderForgotPasswordFormComponent from "./common/HeaderForgotPasswordFormComponent.vue";

export default {
  name: "FormLogin",
  props: {
    isFixed: Boolean,
  },
  mixins: [validationMixin],
  validations: {
    email: {
      required,
      email,
    },
    password: {
      required,
    },
  },
  components: {
    HeaderRegisterFormComponent,
    HeaderRegisterInvitationFormComponent,
    HeaderForgotPasswordFormComponent,
  },

  data: () => ({
    email: null,
    password: null,
    confirmPassword: null,
    isProcessing: false,
    invitation: null,
    logoImage: "/images/logo.svg",
    isRegisterSuccess: false,
    isForgotPassword: false,
  }),

  computed: {
    userFullName () {
      const user = JSON.parse(localStorage.getItem('user'))
      return user ? `${user.prename} ${user.name}` : null;
    },
    userAvatar () {
      const user = JSON.parse(localStorage.getItem('user'))
      return user ? user.avatar : null;
    },
    isSignInModalOpen () {
      return this.$store.state.isSignInModalOpen;
    },
    isSignUpModalOpen () {
      // console.log({ isOpen: this.$store.state.isSignUpModalOpen });
      return this.$store.state.isSignUpModalOpen;
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
  },

  mounted () {
    // const htmlEl = document.querySelector('html');
    // htmlEl.addEventListener('click', (e) => {
    //   const loadingEl = document.querySelector('#loading');
    //   const isLoadingActive = loadingEl.classList.contains('active');

    //   if (!isLoadingActive) {
    //     const activeModalEl = document.querySelector('.popup.active');
    //     if (activeModalEl) {
    //       // Clear form
    //       this.clearForm();

    //       // Close modal
    //       if (activeModalEl.id === 'sign-popup') {
    //         this.closeSignInModal();
    //       } else if (activeModalEl.id === 'register-popup') {
    //         this.closeSignUpModal();
    //       }
    //     }
    //   }
    // })
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
      this.email = null;
      this.password = null;
      this.confirmPassword = null;
    },

    submit () {
      // Show loading
      this.$store.commit("setLoading", true);

      // Handle submit here
      axios
        .post(`${window.location.origin}/api/login`, {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          const { data } = response.data;

          // Save user
          this.$store.commit("setUser", data);
          localStorage.setItem("user", JSON.stringify(data));

          // Open success notification
          this.$store.commit("openNotification", {
            message: "Login successfully!",
            type: "success",
          });

          // Redirect to the offer list page
          setTimeout(() => {
            // Clear form
            this.clearForm();

            // Close notification
            this.$store.commit('closeNotification');

            // Hide loading
            this.$store.commit('setLoading', false);

            // Move to Offers screen
            if (data.role === 'user') {
              this.$router.push('offers');
            } else {
              this.$router.push('my-offers');
            }

            // Close sign-in popup
            this.closeSignInModal();
          }, 2000);
        })
        .catch((error) => {
          console.log({ error });
          this.$store.commit("setLoading", false);
          this.$store.commit("openNotification", {
            message: "Login failed!",
            type: "error",
          });
        });
    },

    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.submit();
      }
    },

    handleVerifyInvitationCodeSuccess(invitation) {
      this.invitation = invitation;
    },

    handleRegisterSuccess() {
      this.isRegisterSuccess = true;
    },

    handleForgotPassword() {
      this.isForgotPassword = true;
    },

    handleBackToLogin() {
      this.isForgotPassword = false;
    },

    handleClickSignInButton () {
      this.closeSignUpModal();
      this.openSignInModal();
    },

    handleClickSignUpButton () {
      this.closeSignInModal();
      this.openSignUpModal();
    },

    handleCompleteForgotPassword () {
      this.clearForm();
      this.closeSignInModal();
      setTimeout(() => {
        this.isForgotPassword = false;
      }, 1000);
    },

    openSignInModal () {
      this.$store.commit('openSignInModal');
    },

    closeSignInModal () {
      this.$store.commit('closeSignInModal');
    },

    openSignUpModal () {
      this.$store.commit('openSignUpModal');
    },

    closeSignUpModal () {
      this.$store.commit('closeSignUpModal');
    },

    logOut() {
      // Show loading
      this.$store.commit('setLoading', true);

      // Clear user data
      this.$store.commit("setUser", null);
      localStorage.removeItem("user");

      setTimeout(() => {
        // Hide loading
        this.$store.commit('setLoading', false);

        // Move to Home screen
        this.moveToHomePage();
      }, 2000);
    },

    moveToAccountPage() {
      this.$router.push('my-account');
    },

    moveToHomePage() {
      window.location = location.origin;
    },
  },
};
</script>
