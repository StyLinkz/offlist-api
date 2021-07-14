<template>
  <div class="floorplan pb-0">
    <h3>floorplan</h3>
    <div class="property-imgs">
      <slick
        ref="floorPlanMainSlick"
        class="property-main-img"
        :options="mainImgSlickOptions"
      >
        <div
          class="property-img"
          v-for="(image, index) in images"
          :key="`offerGalleryMain_${index}`"
        >
          <img :src="image" :alt="imageAlt" />
        </div>
        <!--property-img end-->
      </slick>
      <!--property-main-img end-->
      <div class="property-thumb-imgs pb-0 border-0">
        <slick
          ref="floorPlanThumbSlick"
          class="thumb-carous"
          :options="thumbImgSlickOptions"
        >
          <div
            v-for="(image, index) in images"
            :key="`offerGalleryThumb_${index}`"
          >
            <div class="property-img">
              <img :src="image" :alt="imageAlt" height="124" style="object-fit: cover;" />
            </div>
            <!--property-img end-->
          </div>
        </slick>
      </div>
      <!--property-thumb-imgs end-->
    </div>
    <!--property-imgs end-->
  </div>
</template>

<script>
import Slick from "vue-slick";

export default {
  props: ['images', 'imageAlt'],

  components: {
    Slick
  },

  data: () => ({
    mainImgSlickOptions: {
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      infinite:false,
      fade: true,
      asNavFor: '.thumb-carous'
    },
    thumbImgSlickOptions: {
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.property-main-img',
      dots: false,
      infinite:false,
      focusOnSelect: true,
      arrows:false,
        responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        }
      ],
    },
  }),

  mounted () {
  },

  created () {
  },

  methods: {},
};
</script>
