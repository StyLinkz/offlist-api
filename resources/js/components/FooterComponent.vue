<template>
  <footer class="footer">
    <div class="footer__inner">
      <div id="loading" class="loading" :class="{ active: isLoading }">
        <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
      </div>
      <!-- END .loading -->
      <div
        id="notification"
        class="notification"
        :class="[
          `notification--${notification.type}`,
          notification.isActive ? 'active' : ''
        ]"
      >
        <span>{{ notification.message }}</span>
      </div>
      <!-- END .notification -->
      <section class="cta section-padding">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="cta-text">
                <h2>All Good Deals Are Done Behind Closed Doors</h2>
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
                <h3>Quick Links</h3>
                <ul>
                  <li>
                    <a href="#" title="Completed Deals">Completed Deals</a>
                  </li>
                  <li>
                    <a href="#" title="Offers around you">Offers around you</a>
                  </li>
                  <li>
                    <a href="#" title="Blog">Blog</a>
                  </li>
                  <li>
                    <a href="#" title="Imprint">Imprint</a>
                  </li>
                </ul>
              </div>
              <!--bottom-list end-->
            </div>
            <div class="col-xl-5 col-sm-12 col-md-5 pl-0">
              <div class="bottom-desc">
                <h3>About Offlist</h3>
                <p>
                  Offlist offers offmarket deals in closed groups or on the
                  global offerwall for app users who only come to the app with
                  an invitation!
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
                      <p>
                        &copy; Offlist. All Rights Reserved. {{ currentYear }} | {{ gitVersion }}
                      </p>
                    </div>
                  </div>
                  <!-- <div class="col-xl-3 col-md-6">
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
                  </div> -->
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
    logoImage: '/images/logo.svg',
    currentYear: new Date().getFullYear(),
    gitVersion: null
  }),

  computed: {
    isLoading() {
      return this.$store.state.isLoading;
    },
    notification() {
      return this.$store.state.notification;
    }
  },

  mounted () {
    axios.get('/api/git/version').then((response) => this.gitVersion = response.data);
  },

  methods: {}
};
</script>
