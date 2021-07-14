<template>
  <div class="card">
    <div class="card-body">
      <div :title="offer.title">
        <h3>{{ offer.title }}</h3>
        <p><i class="la la-map-marker"></i>{{ offer.location.address || 'Not specified' }}</p>
      </div>
      <ul>
        <li
          v-for="(item, index) in overviewData"
          :key="`offerOverview_${index}`"
        >{{ item }}</li>
      </ul>
    </div>
    <!-- END .card-body -->
    <div class="rate-info">
      <h5>{{ formattedPrice(offer.price, offer.data.primary.currency) }}</h5>
      <span>{{ offer.data.primary.status || 'New' }}</span>
    </div>
    <!-- END .rate-info -->
  </div>
  <!-- END .card -->
</template>

<script>
export default {
  props: ['offer'],

  data: () => ({
    overviewData: [],
  }),

  created() {
    switch (this.offer.type) {
      case 'real_estate':
        this.overviewData = [
          `${this.offer.data.secondary.bedroom || 0} Bedrooms`,
          `${this.offer.data.secondary.bath_room || 0} Bathrooms`,
          `Area ${this.offer.data.primary.size || 0} Sq Ft`,
        ];
        break;
      case 'car':
        this.overviewData = [
          this.offer.data.primary.brand,
          this.offer.data.primary.model,
          this.offer.data.primary.size,
        ];
        break;
      case 'art':
        this.overviewData = [
          this.offer.data.primary.artist_name,
          this.offer.data.primary.technique,
          this.offer.data.primary.year_of_construction,
        ];
        break;
      default:
        break;
    }
  },

  methods: {
    getCurrencySign(currency) {
      switch (currency) {
        case "EUR":
          return "€";
        case "GBP":
          return "£";
        case "USD":
          return "$";
        case "RMB":
          return "元";
        case "JPY":
          return "¥";
        default:
          return "€";
      }
    },
    formattedPrice(price, currency) {
      const formattedPrice = new Intl.NumberFormat(
        'de-DE',
        {
          style: 'currency',
          currency,
          maximumFractionDigits: 0,
          minimumFractionDigits: 0,
        }
      ).format(price);
      return formattedPrice;
    },
  },
};
</script>
