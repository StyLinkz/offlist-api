<template>
  <!-- <div id="map-container" class="fullwidth-home-map">
    <div id="map" data-map-zoom="9"></div>
  </div> -->
  <gmap-map
    :center="center"
    :zoom="6"
    style="width: 100%; height: 100vh;"
  >
    <gmap-marker
      v-for="m in getMarkers()"
      :key="`marker_${m.id}`"
      :position="m.position"
      :clickable="true"
      :draggable="true"
      @click="center=m.position"
    ></gmap-marker>
  </gmap-map>
</template>

<script>
export default {
  props: {
    offers: Array,
  },

  data: () => ({
    center: {
      lat: 51.18729,
      lng: 10.25582,
    },
    markers: [],
  }),

  mounted () {},

  methods: {
    getMarkers () {
      const mapMarkers = this.offers.reduce((markers, offer) => {
        const { location } = offer;
        if (location.coordinates && location.coordinates.lat && location.coordinates.lng) {
          return [
            ...markers,
            {
              id: offer.id,
              position: {
                lat: location.coordinates.lat,
                lng: location.coordinates.lng,
              },
            },
          ]
        }
        return markers;
      }, []);

      // console.log({ mapMarkers });

      return mapMarkers;
    },
  },
};
</script>
