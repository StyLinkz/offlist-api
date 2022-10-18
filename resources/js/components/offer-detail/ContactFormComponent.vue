<template>
  <div class="widget widget-form">
    <h3 class="widget-title">{{ isLoggedIn() && isRegularUser() ? 'Contact Listing Agent' : 'Supplier Information' }}</h3>
    <div class="contct-info mb-0">
      <div class="contact-image">
        <img :src="offer.seller.avatar" :alt="sellerName" width="240" height="240" class="img--cover" />
      </div>
      <div class="contct-nf">
        <h3 class="mb-2">{{ sellerName }}</h3>
        <h4 class="d-flex align-items-center mb-2" v-if="offer.seller && offer.seller.company">
          <i class="la la-building"></i>
          {{ offer.seller.company }}
        </h4>
        <h4 class="d-flex align-items-center mb-2" v-if="offer.seller && offer.seller.address">
          <i class="la la-map-marker"></i>
          {{ `${offer.seller.address}, ${offer.seller.city}, ${offer.seller.zipcode}` }}
        </h4>
        <h4 class="d-flex align-items-center mb-2" v-if="offer.seller.website">
          <a :href="sellerWebsite" target="_blank" class="d-flex align-items-center">
            <i class="la la-home"></i>
            {{ offer.seller.website }}
          </a>
        </h4>
        <h4 class="d-flex align-items-center mb-2">
          <a :href="`mailto:${offer.seller.email}`" class="d-flex align-items-center">
            <i class="la la-envelope"></i>
            {{ offer.seller.email }}
          </a>
        </h4>
        <h4 class="d-flex align-items-center">
          <a :href="`tel:${offer.seller.phone}`" class="d-flex align-items-center">
            <i class="la la-phone"></i>
            {{ offer.seller.phone }}
          </a>
        </h4>
        <!-- <a :href="`tel:${offer.seller.phone}`">
          <i class="la la-phone"></i>{{ offer.seller.phone }}
        </a> -->
      </div>
    </div>
    <!--contct-info end-->
    <div class="post-comment-sec" v-if="isLoggedIn() && isRegularUser()">
      <form novalidate @submit.prevent="validate" id="formOfferRequest">
        <div class="form-field">
          <input
            v-model="prename"
            type="text"
            name="prename"
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
        <!--form-field end-->
        <div class="form-field">
          <input
            v-model="name"
            type="text"
            name="name"
            placeholder="Your name"
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
        <!--form-field end-->
        <div class="form-field">
          <input
            v-model="email"
            type="email"
            name="email"
            placeholder="Your email address"
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
        <!--form-field end-->
        <button type="submit" class="btn2" :loading="isProcessing">
          Contact
        </button>
      </form>
    </div>
    <!--post-comment-sec end-->
  </div>
  <!--widget-form end-->
</template>

<script>
import axios from "axios";
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";

export default {
  name: "FormOfferRequest",
  props: ['offer'],
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
    isProcessing: false,
  }),

  computed: {
    sellerName () {
      return `${this.offer.seller.prename} ${this.offer.seller.name}`;
    },
    sellerWebsite () {
      const website = this.offer.seller.website && this.offer.seller.website.indexOf('http') === 0
       ? this.offer.seller.website
       : `http://${this.offer.seller.website}`;
      return website;
    },
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

  created() {},

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
      this.prename = '';
      this.name = '';
      this.email = '';
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
      const url = `${window.location.origin}/api/applications`;
      const data = {
        "offer_id": this.offer.id,
        "user_id": this.offer.user_id,
        "sender_id": user.id.toString(),
        "sender_name": this.name,
        "sender_prename": this.prename,
        "sender_email": this.email,
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
          if (response.status === 200) {
            // Open success notification
            this.$store.commit('openNotification', {
              message: 'Your request has been sent successfully!',
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
            message: 'Failed! Please try to contact later',
            type: 'error',
          });
        });
    },
  },
};
</script>
