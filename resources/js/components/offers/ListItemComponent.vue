<template>
  <div class="card">
    <router-link :to="`/offers/${offer.id}?type=${type}`">
      <div class="img-block">
        <div class="overlay"></div>
        <img :src="offer.thumbnail" :alt="offer.title" class="img-fluid" />
        <div class="rate-info">
          <h5>{{ formattedPrice }}</h5>
          <span v-if="offer.category === 'real_estate'">{{
            offer.primaryData.status.value
          }}</span>
        </div>
      </div>
    </router-link>
    <div class="card-body">
      <router-link
        class="card-offer__title"
        :to="`/offers/${offer.id}?type=${type}`"
        :title="offer.title"
      >
        <h3>{{ offer.title }}</h3>
        <p class="card-offer__location">
          <i class="la la-map-marker"></i>{{ offerAddress }}
        </p>
      </router-link>
      <ul class="card-offer__meta" v-if="offer.category === 'real_estate'">
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Bedrooms:</span
          ><span class="card-offer__attribute__value">{{
            offer.secondaryData.bedroom.value
          }}</span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Bathrooms:</span
          ><span class="card-offer__attribute__value">{{
            offer.secondaryData.bath_room.value
          }}</span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Area:</span
          ><span class="card-offer__attribute__value"
            >{{ offer.primaryData.size.value }}m2</span
          >
        </li>
      </ul>
      <ul class="card-offer__meta" v-if="offer.category === 'car'">
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Brand:</span
          ><span class="card-offer__attribute__value">{{
            offer.primaryData.brand.value
          }}</span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Model:</span
          ><span class="card-offer__attribute__value">{{
            offer.primaryData.model.value
          }}</span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Year of construction:</span
          ><span class="card-offer__attribute__value">{{
            offer.primaryData.year_of_construction.value
          }}</span>
        </li>
      </ul>
      <ul class="card-offer__meta" v-if="offer.category === 'art'">
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Name of artist:</span
          ><span class="card-offer__attribute__value">{{
            offer.primaryData.artist_name.value
          }}</span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Technique:</span
          ><span class="card-offer__attribute__value">{{
            offer.primaryData.technique.value
          }}</span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Year:</span
          ><span class="card-offer__attribute__value">{{
            offer.primaryData.year_of_construction.value
          }}</span>
        </li>
      </ul>
    </div>
    <div class="card-footer">
      <a
        role="button"
        href="javascript:void(0);"
        class="pull-left card-offer__action"
        @click="handleAddToWishlist($event, offer)"
      >
        <i class="la la-star" v-if="isAddedToWishlist"></i>
        <i class="la la-star-o" v-else></i>
      </a>
      <a
        role="button"
        href="javascript:void(0);"
        class="pull-left card-offer__action ml-2"
        v-if="isOwner"
        @click="handleEdit($event, offer)"
      >
        <i class="la la-pencil"></i>
      </a>
      <a
        role="button"
        href="javascript:void(0);"
        data-toggle="modal"
        data-target="#modalDeleteOfferWarning"
        class="pull-left card-offer__action ml-2"
        v-if="isOwner"
        @click="handlePressDeleteButton($event, offer)"
      >
        <i class="la la-trash"></i>
      </a>
      <a href="#" class="pull-right">
        <i class="la la-calendar-check-o"></i> {{ daysAgo }}
      </a>
    </div>
    <!-- <a href="#" title="" class="ext-link"></a> -->
  </div>
</template>

<script>
import axios from "axios";
import dayjs from "dayjs";

const relativeTime = require("dayjs/plugin/relativeTime");

export default {
  data: () => ({
    isAddedToWishlist: false,
  }),

  props: ["offer", "isOwner", "type", "onPressDeleteButton"],

  computed: {
    offerAddress: function () {
      return this.offer.location && this.offer.location.address
        ? `${this.offer.location.address}, ${this.offer.location.city}, ${this.offer.location.country}`
        : "Not specified";
    },
    formattedPrice: function () {
      const formattedPrice = new Intl.NumberFormat("de-DE", {
        style: "currency",
        currency: "EUR",
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
      }).format(this.offer.price);
      return formattedPrice;
    },
    daysAgo: function () {
      dayjs.extend(relativeTime);
      const days = dayjs(this.offer.createdAt).fromNow();
      return days;
    },
  },

  created() {
    this.isAddedToWishlist = this.offer.isAddedToWishlist;
  },

  methods: {
    handleEdit(e, item) {
      const user = JSON.parse(localStorage.getItem("user"));
      if (!user) {
        return;
      }
      if (user.role === 'free_user') {
        this.$router.push({ name: 'freeOfferEdit', params: { offerId: item.id }});
      } else {
        this.$router.push({ name: 'offerEdit', params: { offerId: item.id }});
      }
    },

    handlePressDeleteButton(e, item) {
      if (typeof this.onPressDeleteButton === 'function') {
        this.onPressDeleteButton(item.id);
      }
    },

    handleAddToWishlist(e, item) {
      const user = JSON.parse(localStorage.getItem("user"));

      this.$store.commit('setLoading', true);

      axios({
        method: 'POST',
        url: `${window.location.origin}/api/offers/${item.id}/wishlist/add`,
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((response) => {
          this.$store.commit('setLoading', false);
          if (response.status === 201) {
            this.isAddedToWishlist = !this.isAddedToWishlist;
            // setTimeout(() => {
            //   window.location = location.href;
            // }, 2000);
          }
        })
        .catch((error) => {
          console.log({ error });

          this.$store.commit("openNotification", {
            message: "Add failed! Please try again later",
            type: "error",
          });

          setTimeout(() => {
            this.$store.commit('closeNotification');
            this.$store.commit('setLoading', false);
          }, 2000);
        });
    },
  },
};
</script>
