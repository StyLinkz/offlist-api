<template>
  <div class="offer-details">
    <div class="details-info bg--grey">
      <h3>Detail</h3>
      <ul>
        <li
          v-for="item in details"
          :key="`offerDetail_${item.key}`"
        >
          <h4 class="text-capitalize">{{ item.name }}:</h4>
          <span>{{ item.value || '' }}</span>
        </li>
      </ul>
    </div>
    <!--details-info end-->
    <div class="offer-building-fabric details-block bg--white" v-if="!!offer.data.building_fabric">
      <h3>Building Fabric</h3>
      <ul>
        <li>
          <h4 class="text-capitalize">Energy Source:</h4>
          <span>{{ offer.data.building_fabric.energy_source }}</span>
        </li>
        <li>
          <h4 class="text-capitalize">Equipment:</h4>
          <span>{{ offer.data.building_fabric.equipment }}</span>
        </li>
        <li>
          <h4 class="text-capitalize">Heating Type:</h4>
          <span>{{ offer.data.building_fabric.heating_type }}</span>
        </li>
        <li>
          <h4 class="text-capitalize">Object State:</h4>
          <span>{{ offer.data.building_fabric.object_state }}</span>
        </li>
      </ul>
    </div>
    <!--offer-building-fabric end-->
    <div class="offer-furnishing details-block descp-text bg--grey" v-if="!!offer.data.furnishing">
      <h3>Furnishing</h3>
      <p>
        {{ offer.data.furnishing }}
      </p>
    </div>
    <!--offer-building-fabric end-->
  </div>
</template>

<script>
export default {
  props: ['offer'],

  data: () => ({
    details: null,
  }),

  created() {
    const exceptedItems = ['currency', 'size'];
    let details = {
      ...this.offer.data.primary,
    };
    if (this.offer.data.secondary) {
      details = {
        ...details,
        ...this.offer.data.secondary,
      };
    }
    this.details = Object.keys(details)
      .filter((key) => exceptedItems.indexOf(key) === -1 && !!details[key])
      .map((key) => ({
        key,
        name: key.split('_').join(' '),
        value: details[key],
      }));
  },

  methods: {},
};
</script>
