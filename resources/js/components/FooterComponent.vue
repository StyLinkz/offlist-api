<template>
  <footer class="footer">
    <div class="footer__inner">
      <div
        id="loading"
        class="loading"
        :class="{ active: isLoading }"
      >
        <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
      </div>
      <!-- END .loading -->
      <div
        id="notification"
        class="notification"
        :class="[ `notification--${notification.type}`, notification.isActive ? 'active' : '' ]"
      >
        <span>{{ notification.message }}</span>
      </div>
      <!-- END .notification -->
      <section class="cta section-padding">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="cta-text">
                <h2>Discover a home you'll love to stay</h2>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- END .cta -->
      <section class="bottom section-padding">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-sm-6 col-md-4">
              <div class="bottom-logo">
                <img :src="logoImage" alt="Offlist" class="img-fluid" />
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-3">
              <div class="bottom-list">
                <h3>Helpful Links</h3>
                <ul>
                  <li>
                    <a href="18_Half_Map.html" title="">Half Map</a>
                  </li>
                  <li>
                    <a href="#" title="">Register</a>
                  </li>
                  <li>
                    <a href="#" title="">Pricing</a>
                  </li>
                  <li>
                    <a href="#" title="">Add Listing</a>
                  </li>
                </ul>
              </div>
              <!--bottom-list end-->
            </div>
            <div class="col-xl-5 col-sm-12 col-md-5 pl-0">
              <div class="bottom-desc">
                <h3>Aditional Information</h3>
                <p>
                  Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non
                  mauris vitae erat consequat auctor eu in elit. Class aptent
                  taciti sociosqu ad litora torquent per conubia nostra, per
                  inceptos.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="footer-content">
                <div class="row justify-content-between">
                  <div class="col-xl-6 col-md-6">
                    <div class="copyright">
                      <p>&copy; Selio theme made in EU. All Rights Reserved.</p>
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                    <div class="footer-social">
                      <a href="#">
                        <i class="fa fa-facebook"></i>
                      </a>
                      <a href="#">
                        <i class="fa fa-twitter"></i>
                      </a>
                      <a href="#">
                        <i class="fa fa-instagram"></i>
                      </a>
                      <a href="#">
                        <i class="fa fa-linkedin"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--footer end-->
</template>

<script>
export default {
  data: () => ({
    logoImage: "/images/logo.svg",
  }),

  computed: {
    isLoading () {
      return this.$store.state.isLoading;
    },
    notification () {
      return this.$store.state.notification;
    },
  },

  methods: {},
};
</script>
