<template>
  <div class="list-head">
    <div class="sortby">
      <span>Sort by:</span>
      <div class="drop-menu">
        <div class="select">
          <span>Relevant</span>
          <i class="la la-caret-down"></i>
        </div>
        <input type="hidden" name="gender" />
        <ul class="dropeddown">
          <li>For Sale</li>
          <li>For Rent</li>
        </ul>
      </div>
    </div>
    <!--sortby end-->
    <!-- <div class="view-change">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link"
            id="grid-tab1"
            data-toggle="tab"
            href="#grid-view-tab1"
            role="tab"
            aria-controls="grid-view-tab1"
            aria-selected="true"
            ><i class="la la-th-large"></i
          ></a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link active"
            id="grid-tab2"
            data-toggle="tab"
            href="#grid-view-tab2"
            role="tab"
            aria-controls="grid-view-tab2"
            aria-selected="true"
            ><i class="la la-th-list"></i
          ></a>
        </li>
      </ul>
    </div> -->
    <!--view-change end-->
  </div>
  <!--list-head end-->
</template>

<script>
export default {
  data: () => ({}),

  created() {},

  methods: {},
};
</script>
