<template>
  <section class="form_sec">
    <h3 class="vis-hid">Invisible</h3>
    <div class="container">
      <form action="#" class="row banner-search">
        <div class="form_field addres">
          <input
            type="text"
            class="form-control"
            placeholder="Enter Address, City or State"
          />
        </div>
        <div class="form_field tpmax">
          <div class="form-group">
            <div class="drop-menu">
              <div class="select">
                <span>Any type</span>
                <i class="fa fa-angle-down"></i>
              </div>
              <input type="hidden" name="gender" />
              <ul class="dropeddown">
                <li>For Sale</li>
                <li>For Rent</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="form_field tpmax">
          <div class="form-group">
            <div class="drop-menu">
              <div class="select">
                <span>Min Price</span>
                <i class="fa fa-angle-down"></i>
              </div>
              <input type="hidden" name="gender" />
              <ul class="dropeddown">
                <li>300$</li>
                <li>400$</li>
                <li>500$</li>
                <li>200$</li>
                <li>600$</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="form_field tpmax">
          <div class="form-group">
            <div class="drop-menu">
              <div class="select">
                <span>Max Price</span>
                <i class="fa fa-angle-down"></i>
              </div>
              <input type="hidden" name="gender" />
              <ul class="dropeddown">
                <li>2000</li>
                <li>3000</li>
                <li>4000</li>
                <li>5000</li>
                <li>6000</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="form_field srch-btn">
          <a href="#" class="btn btn-outline-primary">
            <i class="la la-search"></i>
          </a>
        </div>
      </form>
    </div>
  </section>
  <!--form_sec end-->
</template>

<script>
import axios from "axios";

export default {
  data: () => ({}),

  methods: {},
};
</script>
