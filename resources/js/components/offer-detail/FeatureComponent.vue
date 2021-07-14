<template>
  <div class="features-dv">
    <h3>Features</h3>
    <form class="form_field">
      <ul>
        <li class="input-field">
          <input type="checkbox" name="cc" id="c1" />
          <label for="c1">
            <span></span>
            <small>Parking</small>
          </label>
        </li>
        <li class="input-field">
          <input type="checkbox" name="cc" id="c2" checked />
          <label for="c2">
            <span></span>
            <small>Gym</small>
          </label>
        </li>
        <li class="input-field">
          <input type="checkbox" name="cc" id="c3" />
          <label for="c3">
            <span></span>
            <small>Heating</small>
          </label>
        </li>
        <li class="input-field">
          <input type="checkbox" name="cc" id="c4" checked />
          <label for="c4">
            <span></span>
            <small>Air Conditioner</small>
          </label>
        </li>
        <li class="input-field">
          <input type="checkbox" name="cc" id="c5" checked />
          <label for="c5">
            <span></span>
            <small>Wireless Internet</small>
          </label>
        </li>
        <li class="input-field">
          <input type="checkbox" name="cc" id="c6" />
          <label for="c6">
            <span></span>
            <small>Swimming Pool</small>
          </label>
        </li>
      </ul>
    </form>
  </div>
  <!--features-dv end-->
</template>

<script>
import axios from "axios";

export default {
  data: () => ({}),

  created() {},

  methods: {},
};
</script>
