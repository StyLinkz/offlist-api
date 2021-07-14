<template>
  <div class="map-dv">
    <h3>Location</h3>
    <gmap-map
      :center="center"
      :zoom="14"
      style="width: 100%; height: 400px;"
    >
      <gmap-marker
        :position="position"
        :draggable="true"
      ></gmap-marker>
    </gmap-map>
  </div>
  <!--map-dv end-->
</template>

<script>
export default {
  props: ['offer'],

  data: () => ({
    position: null,
    center: {
      lat: 51.18729,
      lng: 10.25582,
    },
  }),

  created() {
    const position = this.offer.location && this.offer.location.address
      ? {
        lat: this.offer.location.coordinates.lat,
        lng: this.offer.location.coordinates.lng,
      }
      : null;
    if (position) {
      this.position = position;
      this.center = position;
    }
  },

  methods: {},
};
</script>
