<template>
  <div class="filter-offers">
    <div class="offer-filter-open d-flex justify-content-end align-items-center">
      <a
        href="javascript:void(0);"
        role="button"
        class="d-inline-flex align-items-center"
        id="filterOffersOpen"
      >
        <i class="la la-filter"></i>
        <span>Filter</span>
      </a>
    </div>
    <div class="widget-property-search">
      <form
        id="formFilterOffers"
        action="#"
        class="row banner-search form-filter-offers"
      >
        <div class="offer-market-types w-100">
          <h3 class="section-search__title mb-3">Types</h3>
          <div class="row">
            <div
              class="col-md-4"
              v-for="type in types"
              :key="`offer_type_${type.value}`"
            >
              <div class="input-field">
                <input
                  v-model="selectedTypes"
                  type="checkbox"
                  name="market_type"
                  :value="type.value"
                  :id="`searchType_${type.value}`"
                />
                <label :for="`searchType_${type.value}`">
                  <span></span>
                  <small>{{ type.label }}</small>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="offer-market-categories w-100">
          <h3 class="section-search__title mb-3">Categories</h3>
          <div class="row">
            <div
              class="col-md-4 mb-3"
              v-for="category in categories"
              :key="`offer_category_${category.value}`"
            >
              <div class="input-field">
                <input
                  v-model="selectedCategories"
                  type="checkbox"
                  name="category"
                  :value="category.value"
                  :id="`searchCategory_${category.value}`"
                />
                <label :for="`searchCategory_${category.value}`">
                  <span></span>
                  <small>{{ category.label }}</small>
                </label>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="form_field full">
        <input
          type="text"
          class="form-control"
          placeholder="Enter Address, City or State"
        />
      </div> -->
        <!-- <div class="form_field pl-0">
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
      <div class="form_field">
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
      <div class="form_field">
        <div class="form-group">
          <div class="drop-menu">
            <div class="select">
              <span>Badrooms</span>
              <i class="fa fa-angle-down"></i>
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
      </div> -->
        <div class="feat-srch offer-search__action mb-0 pt-0">
          <!-- <div class="more-feat">
          <h3>
            <i class="la la-cog"></i>&nbsp;<span>Show More Features</span>
          </h3>
        </div> -->
          <!--more-feat end-->
          <div class="d-flex justify-content-between align-items-center py-3">
            <a
              href="javascript:void(0);"
              role="button"
              id="filterOffersClose"
              class="offer-filter-close"
            >
              Hide
            </a>
            <div class="form_field mb-0">
              <a
                href="javascript:void(0);"
                class="btn btn-outline-primary mt-0"
                @click="handleSearch"
              >
                <span>Filter</span>
              </a>
            </div>
          </div>
        </div>
        <!--more-feat end-->
        <!-- <div class="features_list">
        <ul>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b1" />
            <label for="b1">
              <span></span>
              <small>Parking</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b2" />
            <label for="b2">
              <span></span>
              <small>Gym</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b4" />
            <label for="b4">
              <span></span>
              <small>Elevator</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b5" />
            <label for="b5">
              <span></span>
              <small>Storage</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b6" />
            <label for="b6">
              <span></span>
              <small>Air Conditioner</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b7" />
            <label for="b7">
              <span></span>
              <small>Wireless</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b8" />
            <label for="b8">
              <span></span>
              <small>Heating</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b9" />
            <label for="b9">
              <span></span>
              <small>Swimming Pool</small>
            </label>
          </li>
          <li class="input-field">
            <input type="checkbox" name="bb" id="b10" />
            <label for="b10">
              <span></span>
              <small>Home Theater</small>
            </label>
          </li>
        </ul>
      </div> -->
        <!--features end-->
      </form>
    </div>
    <!--widget widget-property-searche end-->
  </div>
</template>

<script>
export default {
  data: () => ({
    types: [
      {
        value: "onmarket",
        label: "On Market",
      },
      {
        value: "offmarket",
        label: "Off Market",
      },
    ],
    categories: [
      {
        value: 1,
        label: "Real Estate",
      },
      {
        value: 2,
        label: "Luxury Cars",
      },
      {
        value: 3,
        label: "Art",
      },
      // {
      //     value: 4,
      //     label: 'Horses',
      // },
      // {
      //     value: 5,
      //     label: 'Yachts',
      // },
      // {
      //     value: 6,
      //     label: 'Private Jets',
      // },
    ],
    selectedTypes: [],
    selectedCategories: [],
  }),

  mounted() {
    $(".more-feat > h3").on("click", function () {
      const $this = $(this);
      const $featuresListEl = $(".features_list");

      // Update button text
      let text = !$featuresListEl.is(":visible")
        ? "Hide Features"
        : "Show More Features";
      $this.find("span").text(text);

      // Toggle the feature list
      $featuresListEl.slideToggle();
    });

    // Toggle the filter box
    $('#filterOffersOpen').on('click', function (e) {
      $(this)
        .closest('.offers-wrapper')
        .find('.widget-property-search')
        .addClass('active');
    });
    $('#filterOffersClose').on('click', function (e) {
      $(this).closest('.widget-property-search').removeClass('active');
    });
  },

  created() {},

  methods: {
    handleSearch() {
      this.$emit("search", {
        marketTypes: this.selectedTypes.length
          ? this.selectedTypes.join(",")
          : null,
        types: this.selectedCategories.length
          ? this.selectedCategories.join(",")
          : null,
      });
    },
  },
};
</script>
