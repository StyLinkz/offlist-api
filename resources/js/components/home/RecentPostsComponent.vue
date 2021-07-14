<template>
  <section class="blog-grid hp6 section-padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6">
          <div class="section-heading">
            <span>Our Blog</span>
            <h3>Recent Posts</h3>
          </div>
        </div>
      </div>
      <div class="blog-grid-posts mg">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="blog-single-post">
              <div class="blog-img">
                <a href="14_Blog_Open.html" title="">
                  <img :src="image.post[0]" class="img--cover" alt="post 01" />
                </a>
                <div class="view-post">
                  <a href="14_Blog_Open.html" title="" class="view-posts"
                    >View Post</a
                  >
                </div>
              </div>
              <!--blog-img end-->
              <div class="post_info">
                <ul class="post-nfo">
                  <li><i class="la la-calendar"></i>April 25, 2018</li>
                </ul>
                <h3>
                  <a href="14_Blog_Open.html" title=""
                    >Real Estate near ocean</a
                  >
                </h3>
                <p>
                  Duis sed odio sit amet nibh vulputate cursus a sit amet
                  mauris. Morbi accumsan ipsum velit vamec.
                </p>
                <a href="14_Blog_Open.html" title="">
                  Read More <i class="la la-long-arrow-right"></i>
                </a>
              </div>
              <a href="14_Blog_Open.html" title="" class="ext-link"></a>
            </div>
            <!--blog-single-post end-->
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="blog-single-post">
              <div class="blog-img">
                <a href="14_Blog_Open.html" title="">
                  <img :src="image.post[1]" class="img--cover" alt="" />
                </a>
                <div class="view-post">
                  <a href="14_Blog_Open.html" title="" class="view-posts"
                    >View Post</a
                  >
                </div>
              </div>
              <!--blog-img end-->
              <div class="post_info">
                <ul class="post-nfo">
                  <li><i class="la la-calendar"></i>April 25, 2018</li>
                </ul>
                <h3>
                  <a href="14_Blog_Open.html" title=""
                    >Real Estate near ocean</a
                  >
                </h3>
                <p>
                  Duis sed odio sit amet nibh vulputate cursus a sit amet
                  mauris. Morbi accumsan ipsum velit vamec.
                </p>
                <a href="14_Blog_Open.html" title="">
                  Read More <i class="la la-long-arrow-right"></i>
                </a>
              </div>
              <a href="14_Blog_Open.html" title="" class="ext-link"></a>
            </div>
            <!--blog-single-post end-->
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="blog-single-post">
              <div class="blog-img">
                <a href="14_Blog_Open.html" title="">
                  <img :src="image.post[2]" class="img--cover" alt="" />
                </a>
                <div class="view-post">
                  <a href="14_Blog_Open.html" title="" class="view-posts"
                    >View Post</a
                  >
                </div>
              </div>
              <!--blog-img end-->
              <div class="post_info">
                <ul class="post-nfo">
                  <li><i class="la la-calendar"></i>April 25, 2018</li>
                </ul>
                <h3>
                  <a href="14_Blog_Open.html" title=""
                    >Real Estate near ocean</a
                  >
                </h3>
                <p>
                  Duis sed odio sit amet nibh vulputate cursus a sit amet
                  mauris. Morbi accumsan ipsum velit vamec.
                </p>
                <a href="14_Blog_Open.html" title="">
                  Read More <i class="la la-long-arrow-right"></i>
                </a>
              </div>
              <a href="14_Blog_Open.html" title="" class="ext-link"></a>
            </div>
            <!--blog-single-post end-->
          </div>
        </div>
      </div>
      <!--blog-grid-posts end-->
    </div>
  </section>
</template>

<script>
export default {
  data: () => ({
    image: {
      post: [
        "/images/post-01.jpg",
        "/images/post-02.jpg",
        "/images/post-03.jpg",
      ],
    },
  }),

  created() {},

  methods: {},
};
</script>
