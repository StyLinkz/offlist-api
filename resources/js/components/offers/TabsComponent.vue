<template>
  <div class="tab-content" id="myTabContent">
    <div
      class="tab-pane fade show active"
      id="grid-view-tab1"
      role="tabpanel"
      aria-labelledby="grid-view-tab1"
    >
      <div class="list_products" v-if="offers.length > 0">
        <div class="row">
          <div
            class="col-lg-6 col-md-6"
            v-for="offer in offers"
            :key="`offer_row_${offer.id}`"
          >
            <list-item-component :offer="offer" />
          </div>
        </div>
      </div>
      <!--list_products end-->
    </div>
    <div
      class="tab-pane fade"
      id="grid-view-tab2"
      role="tabpanel"
      aria-labelledby="grid-view-tab2"
    >
      <div class="list-products" v-if="offers.length > 0">
        <list-item-row-component
          v-for="offer in offers"
          :key="`offer_grid_${offer.id}`"
          :offer="offer"
        />
      </div>
      <!--list_products end-->
    </div>
  </div>
</template>

<script>
/* Components */
import ListItemComponent from "./ListItemComponent.vue";
import ListItemRowComponent from "./ListItemRowComponent.vue";

export default {
  data: () => ({}),

  props: {
    offers: Array,
  },

  components: {
    ListItemComponent,
    ListItemRowComponent,
  },

  created() {
    // console.log({ offers: this.offers });
  },

  methods: {},
};
</script>
