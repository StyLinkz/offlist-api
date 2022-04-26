<template>
  <div class="card">
    <a href="#" :title="offer.title">
      <div class="img-block">
        <div class="overlay"></div>
        <img
          :src="offer.thumbnail"
          :alt="offer.title"
          class="img-fluid"
        />
        <div class="rate-info">
          <h5>${{ offer.price }}</h5>
          <span v-if="offer.category === 'real_estate'">{{ offer.primaryData.status.value }}</span>
        </div>
      </div>
    </a>
    <div class="card_bod_full">
      <div class="card-body">
        <a href="#" class="card-offer__title" :title="offer.title">
          <h3>{{ offer.title }}</h3>
          <p class="card-offer__location"><i class="la la-map-marker"></i>{{ `${offer.location.address}, ${offer.location.city}, ${offer.location.country}` }}</p>
        </a>
        <ul class="card-offer__meta" v-if="offer.category === 'real_estate'">
          <li>Area: {{ offer.primaryData.size.value }}</li>
          <li>Year of construction: {{ offer.primaryData.size.value }}</li>
        </ul>
      </div>
      <div class="card-footer">
        <div class="crd-links">
          <a href="#" class="pull-left">
            <i class="la la-heart-o"></i>
          </a>
          <a href="#" class="plf">
            <i class="la la-calendar-check-o"></i> {{ offer.createdAt }}
          </a>
        </div>
        <!--crd-links end-->
        <a href="#" :title="offer.title" class="btn-default">
          View Details
        </a>
      </div>
    </div>
    <!--card_bod_full end-->
    <!-- <a href="#" :title="offer.title" class="ext-link"></a> -->
  </div>
  <!--card end-->
</template>

<script>
export default {
  data: () => ({}),
  props: ['offer', 'type'],

  created () {
    // console.log({ offer: this.offer });
  },

  methods: {},
};
</script>
