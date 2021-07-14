<template>
  <div class="descp-text">
    <h3>Description</h3>
    <p>
      {{ offer.location.description }}
    </p>
  </div>
  <!--descp-text end-->
</template>

<script>
export default {
  props: ['offer'],

  data: () => ({}),

  created() {},

  methods: {},
};
</script>
