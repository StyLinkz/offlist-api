<template>
  <div class="card">
    <router-link :to="`/offers/${request.offer.id}`">
      <div class="img-block">
        <div class="overlay"></div>
        <img :src="request.offer.thumbnail" :alt="request.offer.title" class="img-fluid" />
        <div class="rate-info">
          <h5>{{ formattedPrice }}</h5>
          <span v-if="request.offer.category === 'real_estate'">
            {{ request.offer.primaryData.status.value }}
          </span>
        </div>
      </div>
    </router-link>
    <div class="card-body">
      <router-link
        class="card-offer__title"
        :to="`/offers/${request.offer.id}`"
        :title="request.offer.title"
      >
        <h3>{{ request.offer.title }}</h3>
        <p class="card-offer__location">
          <i class="la la-map-marker"></i>{{ offerAddress }}
        </p>
      </router-link>
      <ul class="card-offer__meta border-top pt-3 mt-3 border-bottom-0">
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Prename:</span>
          <span class="card-offer__attribute__value">
            {{ request.contact.prename }}
          </span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Name:</span>
          <span class="card-offer__attribute__value">
            {{ request.contact.name }}
          </span>
        </li>
        <li class="d-flex justify-content-between align-items-center">
          <span class="card-offer__attribute__name">Email:</span>
          <span class="card-offer__attribute__value">
            {{ request.contact.email }}
          </span>
        </li>
      </ul>
    </div>
    <div class="card-footer"></div>
  </div>
</template>

<script>
export default {
  data: () => ({}),
  props: ["offer", "request"],

  computed: {
    offerAddress: function () {
      return this.request.offer.location && this.request.offer.location.address
        ? `${this.request.offer.location.address}, ${this.request.offer.location.city}, ${this.request.offer.location.country}`
        : "Not specified";
    },
    formattedPrice: function () {
      const formattedPrice = new Intl.NumberFormat("de-DE", {
        style: "currency",
        currency: "EUR",
        maximumFractionDigits: 0,
        minimumFractionDigits: 0,
      }).format(this.request.offer.price);
      return formattedPrice;
    },
  },
};
</script>
