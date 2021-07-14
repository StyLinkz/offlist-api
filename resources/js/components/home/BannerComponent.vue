<template>
  <section
    class="main-banner-sec hp6"
    :style="{ backgroundImage: 'url(' + image.banner + ')' }"
  >
    <div class="overlay-bg"></div>
    <div class="container">
      <div class="bannner_text">
        <h3>Discover the Best Properties</h3>
        <p>
          Aenean sollicitudin, lorem quis bibendum aucto elit consequat ipsumas
          nec sagittis sem nibh id elit. Duis sed odio sit amet nibhulpu tate
          cursus a sit amet mauris. Morbi accumsan ipsum torquent.
        </p>
        <a href="#" title="" class="btn-default st1">Get Started Now</a>
      </div>
      <!--banner_img end-->
    </div>
  </section>
  <!--main-banner-sec end-->
</template>

<script>
export default {
  data: () => ({
    image: {
      banner: "/images/banner-2.jpg",
    },
  }),

  created() {},

  methods: {},
};
</script>
