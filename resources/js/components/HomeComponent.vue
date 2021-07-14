<template>
  <div class="home-container">
    <banner-component />
    <popular-listing-component />
    <popular-cities-component />
    <recent-posts-component />
  </div>
</template>

<script>
import PopularListingComponent from './home/PopularListingComponent.vue';
import BannerComponent from './home/BannerComponent.vue';
import PopularCitiesComponent from './home/PopularCitiesComponent.vue';
import RecentPostsComponent from './home/RecentPostsComponent.vue';

export default {
  data: () => ({
    loading: false,
  }),

  components: {
    PopularListingComponent,
    BannerComponent,
    PopularCitiesComponent,
    RecentPostsComponent,
  },

  mounted () {
    // $("#popularListingSlider").slick({
    //   autoplay: true,
    //   slidesToShow: 3,
    //   slidesToScroll: 1,
    //   dots: true,
    //   arrows: false,
    //   responsive: [
    //     {
    //       breakpoint: 991,
    //       settings: {
    //         slidesToShow: 1
    //       }
    //     }
    //   ]
    // });
  },

  methods: {},
};
</script>
