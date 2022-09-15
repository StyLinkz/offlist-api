<template>
  <section
    class="main-banner-sec hp6"
    :style="{ backgroundImage: 'url(' + image.banner + ')' }"
  >
    <div class="overlay-bg"></div>
    <div class="container">
      <div class="bannner_text">
        <h3>The closed off market marketplace</h3>
        <p>
          Access is only possible by personal invitation from an existing user.
          This protects our offers and keeps the circle elitist, which is in
          line with our credo. You still want to try to get an access?
        </p>
        <a href="#" title="Apply" class="btn-default st1">Click here for the application</a>
        <!-- <a href="javascript:void(0);" class="btn-default st1" @click="generateOfferCodes">Generate Offer Codes</a> -->
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
      banner: '/images/banner-2.jpg'
    }
  }),

  created() {},

  methods: {
    // generateOfferCodes() {
    //   axios({
    //     method: 'get',
    //     url: `${window.location.origin}/api/generate-codes`,
    //   })
    //     .then(response => {
    //       console.log({ response });
    //     })
    //     .catch(error => {
    //       console.log({ error });
    //     });
    // }
  }
};
</script>
