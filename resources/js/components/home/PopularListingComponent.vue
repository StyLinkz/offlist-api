<template>
  <section class="popular-listing hp2 section-padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6">
          <div class="section-heading">
            <span>Inspiration</span>
            <h3>Find real estate in your area</h3>
          </div>
        </div>
      </div>
      <slick
        ref="popularListingSlick"
        id="popularListingSlider"
        :options="slickOptions"
      >
        <div class="popular-listing-item">
          <div class="card">
            <a href="24_Property_Single.html" title="">
              <div class="img-block">
                <div class="overlay"></div>
                <img :src="image.post[0]" alt="" class="img-fluid" />
                <div class="rate-info">
                  <h5>$550.000</h5>
                  <span>For Rent</span>
                </div>
              </div>
            </a>
            <div class="card-body">
              <a href="24_Property_Single.html" title="">
                <h3>Traditional Apartments</h3>
                <p><i class="la la-map-marker"></i>212 5th Ave, New York</p>
              </a>
              <ul>
                <li>3 Bathrooms</li>
                <li>2 Beds</li>
                <li>Area 555 Sq Ft</li>
              </ul>
            </div>
            <div class="card-footer">
              <a href="#" class="pull-left">
                <i class="la la-heart-o"></i>
              </a>
              <a href="#" class="pull-right">
                <i class="la la-calendar-check-o"></i> 25 Days Ago</a
              >
            </div>
            <a href="24_Property_Single.html" title="" class="ext-link"></a>
          </div>
        </div>
        <div class="popular-listing-item">
          <div class="card">
            <a href="24_Property_Single.html" title="">
              <div class="img-block">
                <div class="overlay"></div>
                <img :src="image.post[1]" alt="" class="img-fluid" />
                <div class="rate-info">
                  <h5>$550.000</h5>
                  <span>For Rent</span>
                </div>
              </div>
            </a>
            <div class="card-body">
              <a href="24_Property_Single.html" title="">
                <h3>Traditional Apartments</h3>
                <p><i class="la la-map-marker"></i>212 5th Ave, New York</p>
              </a>
              <ul>
                <li>3 Bathrooms</li>
                <li>2 Beds</li>
                <li>Area 555 Sq Ft</li>
              </ul>
            </div>
            <div class="card-footer">
              <a href="#" class="pull-left">
                <i class="la la-heart-o"></i>
              </a>
              <a href="#" class="pull-right">
                <i class="la la-calendar-check-o"></i> 25 Days Ago</a
              >
            </div>
            <a href="24_Property_Single.html" title="" class="ext-link"></a>
          </div>
        </div>
        <div class="popular-listing-item">
          <div class="card">
            <a href="24_Property_Single.html" title="">
              <div class="img-block">
                <div class="overlay"></div>
                <img :src="image.post[2]" alt="" class="img-fluid" />
                <div class="rate-info">
                  <h5>$550.000</h5>
                  <span>For Rent</span>
                </div>
              </div>
            </a>
            <div class="card-body">
              <a href="24_Property_Single.html" title="">
                <h3>Traditional Apartments</h3>
                <p><i class="la la-map-marker"></i>212 5th Ave, New York</p>
              </a>
              <ul>
                <li>3 Bathrooms</li>
                <li>2 Beds</li>
                <li>Area 555 Sq Ft</li>
              </ul>
            </div>
            <div class="card-footer">
              <a href="#" class="pull-left">
                <i class="la la-heart-o"></i>
              </a>
              <a href="#" class="pull-right">
                <i class="la la-calendar-check-o"></i> 25 Days Ago</a
              >
            </div>
            <a href="24_Property_Single.html" title="" class="ext-link"></a>
          </div>
        </div>
        <div class="popular-listing-item">
          <div class="card">
            <a href="24_Property_Single.html" title="">
              <div class="img-block">
                <div class="overlay"></div>
                <img :src="image.post[2]" alt="" class="img-fluid" />
                <div class="rate-info">
                  <h5>$550.000</h5>
                  <span>For Rent</span>
                </div>
              </div>
            </a>
            <div class="card-body">
              <a href="24_Property_Single.html" title="">
                <h3>Traditional Apartments</h3>
                <p><i class="la la-map-marker"></i>212 5th Ave, New York</p>
              </a>
              <ul>
                <li>3 Bathrooms</li>
                <li>2 Beds</li>
                <li>Area 555 Sq Ft</li>
              </ul>
            </div>
            <div class="card-footer">
              <a href="#" class="pull-left">
                <i class="la la-heart-o"></i>
              </a>
              <a href="#" class="pull-right">
                <i class="la la-calendar-check-o"></i> 25 Days Ago</a
              >
            </div>
            <a href="24_Property_Single.html" title="" class="ext-link"></a>
          </div>
        </div>
      </slick>
    </div>
  </section>
</template>
<script>
import Slick from "vue-slick";

export default {
  components: {
    Slick,
  },

  data: () => ({
    image: {
      post: [
        "/images/post-01.jpg",
        "/images/post-02.jpg",
        "/images/post-03.jpg",
      ],
    },
    slickOptions: {
      autoplay: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    },
  }),

  created() {},

  methods: {},
};
</script>
