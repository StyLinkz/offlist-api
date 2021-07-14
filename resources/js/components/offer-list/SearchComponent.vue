<template>
  <div class="widget widget-property-search">
    <h3 class="widget-title">Property Search</h3>
    <form action="#" class="row banner-search">
      <div class="form_field">
        <input
          type="text"
          class="form-control"
          placeholder="Enter Address, City or State"
        />
      </div>
      <div class="form_field">
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
      <div class="form_field">
        <div class="form-group">
          <div class="drop-menu">
            <div class="select">
              <span>Min Price</span>
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
      <div class="form_field">
        <div class="form-group">
          <div class="drop-menu">
            <div class="select">
              <span>Max Price</span>
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
      <div class="form_field">
        <div class="form-group">
          <div class="drop-menu">
            <div class="select">
              <span>Badrooms</span>
            </div>
            <input type="hidden" name="gender" />
            <ul class="dropeddown">
              <li>1</li>
              <li>2</li>
              <li>3</li>
              <li>4</li>
              <li>5</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="form_field">
        <h4>More Features</h4>
        <ul>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c1" />
            <label for="c1">
              <span></span>
              <small>Parking</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c2" />
            <label for="c2">
              <span></span>
              <small>Air Conditioner</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c3" />
            <label for="c3">
              <span></span>
              <small>Washing Machine</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c4" />
            <label for="c4">
              <span></span>
              <small>Heating</small>
            </label>
          </li>
        </ul>
        <ul>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c5" />
            <label for="c5">
              <span></span>
              <small>Gym</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c6" />
            <label for="c6">
              <span></span>
              <small>Wireless Internet</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c7" />
            <label for="c7">
              <span></span>
              <small>Elevator</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="cc" id="c8" />
            <label for="c8">
              <span></span>
              <small>Swimming Pool</small>
            </label>
          </li>
        </ul>
      </div>
      <div class="form_field">
        <a href="#" class="btn btn-outline-primary">
          <span>Search</span>
        </a>
      </div>
    </form>
  </div>
  <!--widget-property-search end-->
</template>

<script>
export default {
  data: () => ({}),

  created() {},

  methods: {},
};
</script>
