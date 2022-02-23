<template>
  <section class="popular-cities hp3 section-padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6">
          <div class="section-heading">
            <span>Popular Cities</span>
            <h3>Location with the most offers</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 city--large">
          <a href="#">
            <div class="card">
              <div class="overlay"></div>
              <div class="overlay-stick"></div>
              <img
                :src="image.location.kohn"
                alt="Kohn"
                class="img-fluid img--cover"
              />
              <div class="card-body">
                <h4>Kohn</h4>
                <i class="fa fa-angle-right"></i>
              </div>
            </div>
          </a>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <div class="col-lg-12 city--small">
              <a href="#">
                <div class="card mgb-30">
                  <div class="overlay"></div>
                  <div class="overlay-stick"></div>
                  <img
                    :src="image.location.dusseldorf"
                    alt="Dusseldorf"
                    class="img-fluid img--cover"
                  />
                  <div class="card-body">
                    <h4>Dusseldorf</h4>
                    <i class="fa fa-angle-right"></i>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-12 city--small">
              <a href="#">
                <div class="card">
                  <div class="overlay"></div>
                  <div class="overlay-stick"></div>
                  <img
                    :src="image.location.munchen"
                    alt="Munchen"
                    class="img-fluid img--cover"
                  />
                  <div class="card-body">
                    <h4>Munchen</h4>
                    <i class="fa fa-angle-right"></i>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data: () => ({
    image: {
      location: {
        kohn: "/images/location-cologne.jpg",
        dusseldorf: "/images/location-dusseldorf.jpg",
        munchen: "/images/location-munchen.jpg",
      },
    },
  }),

  created() {},

  methods: {},
};
</script>
