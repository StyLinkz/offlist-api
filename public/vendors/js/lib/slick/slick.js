jQuery(window).on("load", function($) {
    "use strict";

    jQuery('.comment-carousel').slick({
        slidesToShow: 2,
        slck:true,
        slidesToScroll: 1,
        autoplay: false,
        dots: false,
        arrows:false,
        autoplaySpeed: 2000,
        responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });


    jQuery('.partner-carousel').slick({
        slidesToShow: 5,
        slck:true,
        slidesToScroll: 1,
        autoplay: false,
        dots: false,
        arrows:false,
        autoplaySpeed: 2000,
        responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 1,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });


    jQuery('.banner-carousel').slick({
        slidesToShow: 1,
        slck:true,
        slidesToScroll: 1,
        autoplay: false,
        dots: false,
        autoplaySpeed: 2000
    });


    jQuery('.property-main-img').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  infinite:false,
	  fade: true,
	  asNavFor: '.thumb-carous'
	});

	jQuery('.thumb-carous').slick({
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
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
	});

});
