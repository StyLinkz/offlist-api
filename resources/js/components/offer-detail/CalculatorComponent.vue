<template>
  <div class="widget widget-calculator">
    <h3 class="widget-title">Mortgage Calculator</h3>
    <form>
      <ul>
        <li>
          <i>$</i>
          <input type="number" name="amount" placeholder="Total Amount" />
        </li>
        <li>
          <i>$</i>
          <input type="number" name="amount" placeholder="Down Payment" />
        </li>
        <li>
          <i>$</i>
          <input type="number" name="amount" placeholder="Interest Rate" />
        </li>
        <li>
          <i>$</i>
          <input type="number" name="amount" placeholder="Monthly Repayments" />
        </li>
        <li>
          <button type="submit" class="btn2">Calculate</button>
        </li>
      </ul>
    </form>
  </div>
  <!--widget-calculator end-->
</template>

<script>
import axios from "axios";

export default {
  data: () => ({}),

  created() {},

  methods: {},
};
</script>
