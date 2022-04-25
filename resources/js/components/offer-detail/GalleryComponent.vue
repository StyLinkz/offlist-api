<template>
  <div class="property-imgs-wrapper">
    <div class="property-imgs">
      <slick
        ref="galleryMainSlick"
        class="property-main-img"
        :options="mainImgSlickOptions"
      >
        <a
          v-for="(image, index) in images"
          :key="`offerGalleryMain_${index}`"
          href="javascript:void(0);"
          role="button"
          class="property-img"
          @click="openLightbox"
        >
          <img :src="image" :alt="imageAlt" />
        </a>
        <!--property-img end-->
      </slick>
      <!--property-main-img end-->
      <div class="property-thumb-imgs">
        <slick
          ref="galleryThumbSlick"
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
    <vue-easy-lightbox
      scrollDisabled
      escDisabled
      moveDisabled
      :visible="showLightbox"
      :imgs="images"
      :index="lightboxGalleryIndex"
      @hide="closeLightbox"
    ></vue-easy-lightbox>
  </div>
</template>

<script>
import Slick from "vue-slick";
import VueEasyLightbox from "vue-easy-lightbox";

export default {
  props: ['images', 'imageAlt'],

  components: {
    Slick,
    VueEasyLightbox,
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
    showLightbox: false,
    lightboxGalleryIndex: 0,
  }),

  mounted () {
  },

  created () {
  },

  methods: {
    openLightbox() {
      this.showLightbox = true;
      this.lightboxGalleryIndex = this.$refs.galleryMainSlick.currentSlide() || 0;
    },

    closeLightbox() {
      this.showLightbox = false;
    }
  },
};
</script>
