<template>
  <div class="card">
    <router-link :to="`/offers/${application.offer.id}`">
      <div class="img-block">
        <div class="overlay"></div>
        <img :src="application.offer.thumbnail" :alt="application.offer.title" class="img-fluid" />
        <div class="rate-info">
          <h5>{{ formattedPrice }}</h5>
          <span v-if="application.offer.category === 'real_estate'">
            {{ application.offer.primaryData.status.value }}
          </span>
        </div>
      </div>
    </router-link>
    <div class="card-body">
      <router-link
        class="card-offer__title"
        :to="`/offers/${application.offer.id}`"
        :title="application.offer.title"
      >
        <h3>{{ application.offer.title }}</h3>
        <p class="card-offer__location">
          <i class="la la-map-marker"></i>{{ offerAddress }}
        </p>
      </router-link>
      <ul class="card-offer__meta border-top pt-3 mt-3 border-bottom-0">
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Prename:</span>
          <span class="card-offer__attribute__value">
            {{ application.contact.prename }}
          </span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Name:</span>
          <span class="card-offer__attribute__value">
            {{ application.contact.name }}
          </span>
        </li>
        <li class="d-flex justify-content-between align-items-start">
          <span class="card-offer__attribute__name">Email:</span>
          <span class="card-offer__attribute__value">
            {{ application.contact.email }}
          </span>
        </li>
        <li class="d-flex justify-content-between align-items-start">
          <span class="card-offer__attribute__name">Phone:</span>
          <span class="card-offer__attribute__value">
            {{ application.contact.phone }}
          </span>
        </li>
        <li class="d-flex justify-content-between align-items-start">
          <span class="card-offer__attribute__name">Message:</span>
          <span class="card-offer__attribute__value text-right">
            {{ application.contact.message }}
          </span>
        </li>
      </ul>
    </div>
    <div class="card-footer p-0"></div>
  </div>
</template>

<script>
export default {
  data: () => ({}),
  props: ["offer", "application"],

  computed: {
    offerAddress: function () {
      return this.application.offer.location && this.application.offer.location.address
        ? `${this.application.offer.location.address}, ${this.application.offer.location.city}, ${this.application.offer.location.country}`
        : "Not specified";
    },
    formattedPrice: function () {
      const formattedPrice = new Intl.NumberFormat("de-DE", {
        style: "currency",
        currency: "EUR",
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
      }).format(this.application.offer.price);
      return formattedPrice;
    },
  },
};
</script>
