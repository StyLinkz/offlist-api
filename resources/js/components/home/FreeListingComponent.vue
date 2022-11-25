<template>
  <section class="home-free-listings pager-sec bfr" v-if="!isLoggedIn() || !isRegularUser()">
    <div class="container">
      <h3 class="home-free-listings__title">Your free listing to an exclusive network!</h3>
      <p class="home-free-listings__description">
        Even if the app is only available for selected users, you can place your ad free of charge without making it available to the public and without groups of people such as neighbors, colleagues or friends seeing it.
        This is the advantage of our platform.
        Only a selected and financially strong group of people will see your offer and your data is absolutely safe!
      </p>
      <!-- <a href="#" class="home-free-listings__button btn-default">Submit your free offer</a> -->
      <a
        role="button"
        href="javascript:void(0);"
        class="home-free-listings__button btn-default"
        data-toggle="modal"
        data-target="#modalSubmitFreeListing"
      >
        <span>Submit Your Free Offer</span>
      </a>
    </div>
  </section>
</template>

<script>
export default {
  data: () => ({}),

  created() {},

  methods: {
    isRegularUser () {
      const user = JSON.parse(localStorage.getItem('user'))
      return user && user.role === 'user';
    },

    isLoggedIn () {
      const user = localStorage.getItem('user')
        ? JSON.parse(localStorage.getItem('user'))
        : null;
      return user && user.api_token;
    },

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
