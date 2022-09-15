<template>
  <div class="offer-create-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>{{ form.id ? 'Edit Offer' : 'Submit Listing' }}</h3>
        </div>
        <!--pager-sec-details end-->
      </div>
    </section>
    <section class="blog-standard section-padding">
      <div class="container">
        <div class="blog-single-details">
          <form
            novalidate
            @submit.prevent="validate"
            id="formOfferCreate"
            class="form-editproperty form-horizontal selio-form"
            method="post"
          >
            <div class="row">
              <div class="col-lg-8">
                <div class="blog-posts">
                  <div class="blog-single-post status-publish hentry">
                    <div class="post_info">
                      <div class="post-content clearfix">
                        <div class="selio_sw_win_wrapper">
                          <div class="ci sw_widget sw_wrap">
                            <div class="bootstrap-wrapper quick-submission">
                              <div
                                id="quick_submission_form"
                                class="widget widget-styles clearfix mb-0"
                              >
                                <div class="content-box">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                      <div class="form-group">
                                        <vue-dropzone
                                          ref="offerImages"
                                          id="offerImages"
                                          class="offer-dropzone mt-1"
                                          :options="{
                                            ...dropzoneOptions,
                                            acceptedFiles: 'image/*',
                                          }"
                                        ></vue-dropzone>
                                      </div>
                                      <div
                                        class="form-group IS-INPUTBOX"
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <label
                                          for="offerType"
                                          class="control-label"
                                        >
                                          Type
                                        </label>
                                        <div class="form-field">
                                          <select
                                            v-if="form.type === 'real_estate'"
                                            v-model="form.offer_category_id"
                                            :error-messages="categoryErrors"
                                            class="form-control"
                                            :class="{
                                              'is-invalid':
                                                categoryErrors.length > 0,
                                            }"
                                            name="type"
                                            id="offerType"
                                            label="Type"
                                            required
                                          >
                                            <option
                                              v-for="option in categoryOptions"
                                              :key="`categoryOption_${option.value}`"
                                              :value="option.value"
                                            >
                                              {{ option.text }}
                                            </option>
                                          </select>
                                          <div
                                            class="invalid-feedback text-left"
                                            v-show="categoryErrors.length > 0"
                                          >
                                            {{ categoryErrors[0] }}
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group IS-INPUTBOX">
                                        <label
                                          for="offerTitle"
                                          class="control-label"
                                        >
                                          Headline
                                        </label>
                                        <div class="form-field">
                                          <input
                                            v-model="form.title"
                                            :error-messages="titleErrors"
                                            class="form-control"
                                            :class="{
                                              'is-invalid':
                                                titleErrors.length > 0,
                                            }"
                                            type="text"
                                            name="title"
                                            id="offerTitle"
                                            required
                                          />
                                          <div
                                            class="invalid-feedback text-left"
                                            v-show="titleErrors.length > 0"
                                          >
                                            {{ titleErrors[0] }}
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group IS-INPUTBOX">
                                        <label
                                          for="offerLocation"
                                          class="control-label"
                                        >
                                          Location
                                        </label>
                                        <div class="form-field">
                                          <vue-google-autocomplete
                                            id="offerLocation"
                                            name="location"
                                            class="form-control"
                                            :class="{
                                              'is-invalid':
                                                locationErrors.length > 0,
                                            }"
                                            placeholder="Start typing"
                                            v-on:placechanged="
                                              handleChangeLocation
                                            "
                                            :error-messages="locationErrors"
                                            :country="['de']"
                                          />
                                          <div
                                            class="invalid-feedback text-left"
                                            v-show="locationErrors.length > 0"
                                          >
                                            {{ locationErrors[0] }}
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group IS-INPUTBOX">
                                        <label
                                          for="offerDescription"
                                          class="control-label"
                                        >
                                          Description
                                        </label>
                                        <div class="form-field">
                                          <textarea
                                            v-model="form.location.description"
                                            name="description"
                                            id="offerDescription"
                                            rows="5"
                                          ></textarea>
                                        </div>
                                      </div>
                                      <div class="form-group IS-INPUTBOX">
                                        <label
                                          for="offerCurrency"
                                          class="control-label"
                                        >
                                          Currency
                                        </label>
                                        <div class="form-field">
                                          <select
                                            v-model="form.data.primary.currency"
                                            :items="currencyOptions"
                                            name="currency"
                                            id="offerCurrency"
                                          >
                                            <option
                                              v-for="option in currencyOptions"
                                              :value="option"
                                              :key="`currency_${option}`"
                                            >
                                              {{ option }}
                                            </option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group IS-INPUTBOX">
                                        <label
                                          for="offerPrice"
                                          class="control-label"
                                        >
                                          Price
                                        </label>
                                        <div class="form-field">
                                          <input
                                            v-model="form.price"
                                            :error-messages="priceErrors"
                                            class="form-control"
                                            :class="{
                                              'is-invalid':
                                                priceErrors.length > 0,
                                            }"
                                            type="text"
                                            name="price"
                                            id="offerPrice"
                                          />
                                          <!-- <input
                                            :value="form.price | currency('', 0, { thousandsSeparator: '.' })"
                                            :error-messages="priceErrors"
                                            class="form-control"
                                            :class="{
                                              'is-invalid': priceErrors.length > 0,
                                            }"
                                            @input="value => this.form.price = value"
                                            type="text"
                                            name="price"
                                            id="offerPrice"
                                          /> -->
                                          <div
                                            class="invalid-feedback text-left"
                                            v-show="priceErrors.length > 0"
                                          >
                                            {{ priceErrors[0] }}
                                          </div>
                                        </div>
                                      </div>
                                      <div
                                        class="group-real-estate"
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCommission"
                                            class="control-label"
                                          >
                                            Buyer's commission
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="form.commission"
                                              :error-messages="commissionErrors"
                                              type="text"
                                              name="commission"
                                              id="offerCommission"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  commissionErrors.length > 0,
                                              }"
                                            />
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="
                                                commissionErrors.length > 0
                                              "
                                            >
                                              {{ commissionErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerSize"
                                            class="control-label"
                                          >
                                            Size
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="form.data.primary.size"
                                              :error-messages="sizeErrors"
                                              type="text"
                                              name="primary.size"
                                              id="offerSize"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  sizeErrors.length > 0,
                                              }"
                                            />
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="sizeErrors.length > 0"
                                            >
                                              {{ sizeErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerFreeFrom"
                                            class="control-label"
                                          >
                                            Free from
                                          </label>
                                          <div class="form-field">
                                            <date-picker
                                              v-model="form.data.primary.free_from"
                                              :error-messages="freeFromErrors"
                                              name="free_from"
                                              id="offerFreeFrom"
                                              class="form-control form-control-date"
                                              :class="{
                                                'is-invalid':
                                                freeFromErrors.length > 0,
                                              }"
                                              valueType="format"
                                              format="DD/MM/YYYY"
                                            ></date-picker>
                                            <!-- <input
                                              v-model="form.data.primary.free_from"
                                              :error-messages="freeFromErrors"
                                              type="text"
                                              name="free_from"
                                              id="offerFreeFrom"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  freeFromErrors.length > 0,
                                              }"
                                            /> -->
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="freeFromErrors.length > 0"
                                            >
                                              {{ freeFromErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerYearOfConstruction"
                                            class="control-label"
                                          >
                                            Year of construction
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.primary
                                                  .year_of_construction
                                              "
                                              :error-messages="
                                                yearOfConstructionErrors
                                              "
                                              required
                                              name="year"
                                              id="offerYearOfConstruction"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  yearOfConstructionErrors.length >
                                                  0,
                                              }"
                                            >
                                              <option
                                                v-for="option in yearOptions"
                                                :key="`yearOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="
                                                yearOfConstructionErrors.length >
                                                0
                                              "
                                            >
                                              {{ yearOfConstructionErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END .form-group-real-estate-year -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerRealEstateStatus"
                                            class="control-label"
                                          >
                                            Status
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="form.data.primary.status"
                                              :error-messages="statusErrors"
                                              name="status"
                                              id="offerRealEstateStatus"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  statusErrors.length > 0,
                                              }"
                                            >
                                              <option
                                                v-for="option in statusOptions"
                                                :key="`statusOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="statusErrors.length > 0"
                                            >
                                              {{ statusErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- END .group-real-estate -->
                                      <div
                                        class="group-car"
                                        v-if="form.type === 'car'"
                                      >
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarBrand"
                                            class="control-label"
                                          >
                                            Brand
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="form.data.primary.brand"
                                              :error-messages="carBrandErrors"
                                              required
                                              name="primary.brand"
                                              id="offerCarBrand"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  carBrandErrors.length > 0,
                                              }"
                                            >
                                              <option
                                                v-for="option in carBrandOptions"
                                                :key="`carBrandOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="carBrandErrors.length > 0"
                                            >
                                              {{ carBrandErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END form-group-car-brand -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarModel"
                                            class="control-label"
                                          >
                                            Model
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="form.data.primary.model"
                                              :error-messages="carModelErrors"
                                              type="text"
                                              name="primary.model"
                                              id="offerCarModel"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  carModelErrors.length > 0,
                                              }"
                                            />
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="carModelErrors.length > 0"
                                            >
                                              {{ carModelErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END form-group-car-model -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerYearOfConstruction"
                                            class="control-label"
                                          >
                                            Year of construction
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.primary
                                                  .year_of_construction
                                              "
                                              :error-messages="
                                                yearOfConstructionErrors
                                              "
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  yearOfConstructionErrors.length >
                                                  0,
                                              }"
                                              required
                                              name="year"
                                              id="offerYearOfConstruction"
                                            >
                                              <option
                                                v-for="option in yearOptions"
                                                :key="`yearOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="
                                                yearOfConstructionErrors.length >
                                                0
                                              "
                                            >
                                              {{ yearOfConstructionErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarStatus"
                                            class="control-label"
                                          >
                                            Status
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="form.data.primary.status"
                                              :error-messages="statusErrors"
                                              name="status"
                                              id="offerCarStatus"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  statusErrors.length > 0,
                                              }"
                                              required
                                            >
                                              <option
                                                v-for="option in carStatusOptions"
                                                :key="`statusOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="statusErrors.length > 0"
                                            >
                                              {{ statusErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-year -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarVariant"
                                            class="control-label"
                                          >
                                            Variant
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.variant
                                              "
                                              type="text"
                                              name="primary.variant"
                                              id="offerCarVariant"
                                            />
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-variant -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarMileage"
                                            class="control-label"
                                          >
                                            Mileage (km)
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.mileage
                                              "
                                              type="text"
                                              name="primary.mileage"
                                              id="offerCarMileage"
                                            />
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-variant -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarGearBox"
                                            class="control-label"
                                          >
                                            Gearbox
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.primary.gearbox
                                              "
                                              name="primary.gearbox"
                                              id="offerCarGearbox"
                                            >
                                              <option
                                                v-for="option in carGearboxOptions"
                                                :key="`gearboxOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-gearbox -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarFuelType"
                                            class="control-label"
                                          >
                                            Fuel type
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.primary.fuel_type
                                              "
                                              name="primary.fuel_type"
                                              id="offerCarFuelType"
                                            >
                                              <option
                                                v-for="option in carFuelTypeOptions"
                                                :key="`fuelTypeOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-fuel-type -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarColor"
                                            class="control-label"
                                          >
                                            Color
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="form.data.primary.color"
                                              type="text"
                                              name="primary.color"
                                              id="offerCarColor"
                                            />
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-color -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCarInteriorColor"
                                            class="control-label"
                                          >
                                            Interior color
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.interior_color
                                              "
                                              type="text"
                                              name="primary.interior_color"
                                              id="offerCarInteriorColor"
                                            />
                                          </div>
                                        </div>
                                        <!-- END .form-group-car-interior-color -->
                                      </div>
                                      <!-- END .group-car -->
                                      <div
                                        class="group-art"
                                        v-if="form.type === 'art'"
                                      >
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerArtArtistName"
                                            class="control-label"
                                          >
                                            Artist name
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.artist_name
                                              "
                                              :error-messages="artArtistErrors"
                                              required
                                              type="text"
                                              name="primary.artist_name"
                                              id="offerArtArtistName"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  artArtistErrors.length > 0,
                                              }"
                                            />
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="
                                                artArtistErrors.length > 0
                                              "
                                            >
                                              {{ artArtistErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END .form-group-art-artist-name -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerArtTechnique"
                                            class="control-label"
                                          >
                                            Technique
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.technique
                                              "
                                              :error-messages="
                                                artTechniqueErrors
                                              "
                                              required
                                              type="text"
                                              name="primary.technique"
                                              id="offerArtTechnique"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  artTechniqueErrors.length > 0,
                                              }"
                                            />
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="
                                                artTechniqueErrors.length > 0
                                              "
                                            >
                                              {{ artTechniqueErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END .form-group-art-technique -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerYearOfConstruction"
                                            class="control-label"
                                          >
                                            Year of construction
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.primary
                                                  .year_of_construction
                                              "
                                              :error-messages="
                                                yearOfConstructionErrors
                                              "
                                              required
                                              name="year"
                                              id="offerYearOfConstruction"
                                              class="form-control"
                                              :class="{
                                                'is-invalid':
                                                  yearOfConstructionErrors.length >
                                                  0,
                                              }"
                                            >
                                              <option
                                                v-for="option in yearOptions"
                                                :key="`yearOption_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                            <div
                                              class="invalid-feedback text-left"
                                              v-show="
                                                yearOfConstructionErrors.length >
                                                0
                                              "
                                            >
                                              {{ yearOfConstructionErrors[0] }}
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END .form-group-art-year -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerArtDimensions"
                                            class="control-label"
                                          >
                                            Dimensions
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.dimensions
                                              "
                                              type="text"
                                              name="primary.dimensions"
                                              id="offerArtDimensions"
                                            />
                                          </div>
                                        </div>
                                        <!-- END .form-group-art-dimensions -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerArtFabrication"
                                            class="control-label"
                                          >
                                            Fabrication
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.primary.fabrication
                                              "
                                              type="text"
                                              name="primary.fabrication"
                                              id="offerArtFabrication"
                                            />
                                          </div>
                                        </div>
                                        <!-- END .form-group-art-fabrication -->
                                      </div>
                                      <!-- END .group-art -->
                                      <div
                                        class="form-group offer-tags"
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <label
                                          for="offerTags"
                                          class="control-label"
                                        >
                                          Tags
                                        </label>
                                        <div class="row">
                                          <div
                                            v-for="tag in tagOptions"
                                            :key="`tag_${tag.value}`"
                                            class="col-md-4"
                                          >
                                            <div class="input-field">
                                              <input
                                                v-model="form.tags"
                                                :value="tag.value"
                                                :id="`offerTags_${tag.value}`"
                                                type="checkbox"
                                                name="offerTags[]"
                                              />
                                              <label
                                                :for="`offerTags_${tag.value}`"
                                              >
                                                <span></span>
                                                <small>{{ tag.label }}</small>
                                              </label>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- END .form-group-tags -->
                                      <div
                                        class="
                                          form-section
                                          offer-property-information
                                        "
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <h3 class="form-section-title">
                                          Property Information
                                        </h3>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerRoom"
                                            class="control-label"
                                          >
                                            Rooms
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary.rooms
                                              "
                                              type="text"
                                              name="secondary.rooms"
                                              id="offerRoom"
                                            />
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerBedroom"
                                            class="control-label"
                                          >
                                            Bedroom
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary.bedroom
                                              "
                                              type="text"
                                              name="secondary.bedroom"
                                              id="offerBedroom"
                                            />
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerLivingRoom"
                                            class="control-label"
                                          >
                                            Living room
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary.living_room
                                              "
                                              type="text"
                                              name="secondary.living_room"
                                              id="offerLivingRoom"
                                            />
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerBathroom"
                                            class="control-label"
                                          >
                                            Bathroom
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary.bath_room
                                              "
                                              type="text"
                                              name="secondary.bathroom"
                                              id="offerBathroom"
                                            />
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerCellars"
                                            class="control-label"
                                          >
                                            Cellars
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary.cellars
                                              "
                                              type="text"
                                              name="secondary.cellars"
                                              id="offerCellars"
                                            />
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerFloorInTotal"
                                            class="control-label"
                                          >
                                            Floor in total
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary
                                                  .floor_in_total
                                              "
                                              type="text"
                                              name="secondary.floor_in_total"
                                              id="offerFloorInTotal"
                                            />
                                          </div>
                                        </div>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerParkingSpace"
                                            class="control-label"
                                          >
                                            Parking space
                                          </label>
                                          <div class="form-field">
                                            <input
                                              v-model="
                                                form.data.secondary
                                                  .parking_space
                                              "
                                              type="text"
                                              name="secondary.parking_space"
                                              id="offerParkingSpace"
                                            />
                                          </div>
                                        </div>
                                      </div>
                                      <!-- END .offer-property-information -->
                                      <div
                                        class="
                                          form-section
                                          offer-building-fabric
                                        "
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <h3 class="form-section-title">
                                          Building Fabric & Energy Certificate
                                        </h3>
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerObjectState"
                                            class="control-label"
                                          >
                                            Object state
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.building_fabric
                                                  .object_state
                                              "
                                              name="secondary.object_state"
                                              id="offerObjectState"
                                            >
                                              <option
                                                v-for="option in objectStateOptions"
                                                :key="`offerObjectState_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                          </div>
                                        </div>
                                        <!-- END offer-real-estate-building-fabric-object-state -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerEquipment"
                                            class="control-label"
                                          >
                                            Equipment
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.building_fabric
                                                  .equipment
                                              "
                                              name="secondary.equipment"
                                              id="offerEquipment"
                                            >
                                              <option
                                                v-for="option in equipmentOptions"
                                                :key="`offerEquipment_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                          </div>
                                        </div>
                                        <!-- END offer-real-estate-building-fabric-equipment -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerEnergySource"
                                            class="control-label"
                                          >
                                            Energy source
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.building_fabric
                                                  .energy_source
                                              "
                                              name="secondary.energy_source"
                                              id="offerEnergySource"
                                            >
                                              <option
                                                v-for="option in energySourceOptions"
                                                :key="`offerEnergySource_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                          </div>
                                        </div>
                                        <!-- END offer-real-estate-building-fabric-energy-source -->
                                        <div class="form-group IS-INPUTBOX">
                                          <label
                                            for="offerHeatingType"
                                            class="control-label"
                                          >
                                            Heating type
                                          </label>
                                          <div class="form-field">
                                            <select
                                              v-model="
                                                form.data.building_fabric
                                                  .heating_type
                                              "
                                              name="secondary.heating_type"
                                              id="offerHeatingType"
                                            >
                                              <option
                                                v-for="option in heatingTypeOptions"
                                                :key="`offerHeatingType_${option}`"
                                                :value="option"
                                              >
                                                {{ option }}
                                              </option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- END .offer-building-fabric -->
                                      <div
                                        class="form-group IS-INPUTBOX"
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <label
                                          for="offerFurnishing"
                                          class="control-label"
                                        >
                                          Furnishing
                                        </label>
                                        <div class="form-field">
                                          <textarea
                                            v-model="form.data.furnishing"
                                            name="furnishing"
                                            id="offerFurnishing"
                                            rows="5"
                                          ></textarea>
                                        </div>
                                      </div>
                                      <!-- END .form-group-furnishing -->
                                      <div
                                        class="offer-floor-plan form-group"
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <label for="offerFloorPlan"
                                          >Floor Plan</label
                                        >
                                        <vue-dropzone
                                          ref="offerFloorPlan"
                                          id="offerFloorPlan"
                                          class="offer-dropzone offer_floorPlan"
                                          :options="{
                                            ...dropzoneOptions,
                                            acceptedFiles: 'image/*',
                                          }"
                                        />
                                      </div>
                                      <!-- END .form-group-floor-plan -->
                                      <div
                                        class="offer-documents form-group"
                                        v-if="form.type === 'real_estate'"
                                      >
                                        <label for="offerFloorPlan"
                                          >Documents</label
                                        >
                                        <vue-dropzone
                                          ref="offerDocuments"
                                          id="offerDocuments"
                                          class="offer-dropzone offer_floorPlan"
                                          :options="{
                                            ...dropzoneOptions,
                                            acceptedFiles: 'image/*',
                                          }"
                                        />
                                      </div>
                                      <!-- END .form-group-documents -->
                                      <div
                                        class="
                                          d-flex
                                          justify-content-end
                                          border-top
                                          pt-4
                                          mt-5
                                          w-100
                                        "
                                      >
                                        <button
                                          type="submit"
                                          class="btn btn-primary"
                                        >
                                          Save
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- END form -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="sidebar">
                  <!-- <categories-component />
                <popular-offers-component /> -->
                  <div class="offer-status form-group">
                    <label for="">Status</label>
                    <div class="custom-control custom-switch">
                      <input
                        v-model="form.status"
                        type="checkbox"
                        class="custom-control-input"
                        id="offerStatus"
                      />
                      <label class="custom-control-label" for="offerStatus">
                        {{ form.status ? "Active" : "Inactive" }}
                      </label>
                    </div>
                  </div>
                  <!-- END offer-status -->
                  <div class="offer-market-type form-group">
                    <label for="">Market type</label>
                    <div class="offer-market-type-options">
                      <div
                        class="
                          custom-control custom-radio custom-control-inline
                        "
                      >
                        <input
                          v-model="form.marketType"
                          type="radio"
                          id="offerMarketTypeOn"
                          name="market_type"
                          value="onmarket"
                          class="custom-control-input"
                        />
                        <label
                          class="custom-control-label"
                          for="offerMarketTypeOn"
                          >On market</label
                        >
                      </div>
                      <div
                        class="
                          custom-control custom-radio custom-control-inline
                        "
                      >
                        <input
                          v-model="form.marketType"
                          type="radio"
                          id="offerMarketTypeOff"
                          name="market_type"
                          value="offmarket"
                          class="custom-control-input"
                        />
                        <label
                          class="custom-control-label"
                          for="offerMarketTypeOff"
                          >Off market</label
                        >
                      </div>
                    </div>
                  </div>
                  <!-- END offer-market-type -->
                  <div class="offer-privacy form-group">
                    <label for="">Privacy</label>
                    <div class="offer-privacy-options">
                      <div
                        class="
                          custom-control custom-radio custom-control-inline
                        "
                      >
                        <input
                          v-model="form.privacy"
                          type="radio"
                          id="offerPrivacyPublic"
                          name="privacy"
                          value="public"
                          class="custom-control-input"
                        />
                        <label
                          class="custom-control-label"
                          for="offerPrivacyPublic"
                          >Public Offerwall</label
                        >
                      </div>
                      <div
                        class="
                          custom-control custom-radio custom-control-inline
                        "
                      >
                        <input
                          v-model="form.privacy"
                          type="radio"
                          id="offerPrivacyPrivate"
                          name="privacy"
                          value="private"
                          class="custom-control-input"
                        />
                        <label
                          class="custom-control-label"
                          for="offerPrivacyPrivate"
                          >Closed Group</label
                        >
                      </div>
                    </div>
                  </div>
                  <!-- END offer-privacy -->
                  <div
                    class="offer-group form-group"
                    v-show="form.privacy === 'private'"
                  >
                    <div
                      class="d-flex justify-content-between align-items-center"
                    >
                      <label class="colour-dark">Groups</label>
                      <button
                        type="button"
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#modalOfferGroups"
                      >
                        Add
                      </button>
                    </div>
                    <div class="border-top pt-3 mt-2">
                      <h3 class="ml-1" v-if="!form.privacyGroups.length">
                        Please add at least one group.
                      </h3>
                      <ul class="selected-groups">
                        <li
                          v-for="groupIndex in form.privacyGroups"
                          :key="`group_selected_${groupIndex}`"
                          class="
                            selected-group-item
                            d-flex
                            justify-content-between
                            align-items-center
                          "
                        >
                          <span class="group-item-name">{{
                            groupOptions[groupIndex].name
                          }}</span>
                          <a
                            href="javascript:void(0);"
                            role="button"
                            class="group-item-delete"
                            @click="handleDeleteGroup(groupIndex)"
                          >
                            <i class="fa fa-trash"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div
                      class="modal modal-offer-groups fade"
                      id="modalOfferGroups"
                      tabindex="-1"
                      role="dialog"
                      aria-labelledby="modalOfferGroupsLabel"
                      aria-hidden="true"
                      data-backdrop="static"
                    >
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalOfferGroupsLabel">
                              Add Groups
                            </h5>
                          </div>
                          <div class="modal-body">
                            <ul class="offer-group-list">
                              <li
                                v-for="(item, index) in groupOptions"
                                :key="`offerGroup_${item.id}`"
                                class="
                                  offer-group-item
                                  d-flex
                                  justify-content-between
                                  align-items-center
                                  px-2
                                  py-3
                                "
                                :class="{
                                  selected: form.privacyGroups.includes(index),
                                  'border-bottom':
                                    index < groupOptions.length - 1,
                                }"
                                @click="handleToggleGroup($event, index)"
                              >
                                <div class="offer-group-item__info">
                                  <h4 class="offer-group-item__name">
                                    {{ item.name }}
                                  </h4>
                                  <span class="d-block">{{
                                    item.description
                                  }}</span>
                                </div>
                                <a
                                  href="javascript:void(0);"
                                  role="button"
                                  class="offer-group-item__icon"
                                >
                                  <i
                                    class="la"
                                    :class="{
                                      'la-check':
                                        form.privacyGroups.includes(index),
                                    }"
                                  ></i>
                                </a>
                              </li>
                            </ul>
                          </div>
                          <div class="modal-footer">
                            <button
                              type="button"
                              class="btn btn-secondary"
                              data-dismiss="modal"
                            >
                              Close
                            </button>
                            <button
                              type="button"
                              class="btn btn-primary"
                              data-dismiss="modal"
                            >
                              OK
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END modal-offer-groups -->
                  </div>
                  <!-- END offer-group -->
                  <div class="offer-seller">
                    <div class="form-group">
                      <label for="">Seller</label>
                      <div class="offer-seller-options">
                        <div
                          class="
                            custom-control custom-radio custom-control-inline
                          "
                        >
                          <input
                            v-model="form.seller.contact_mode"
                            type="radio"
                            id="offerSellerProfile"
                            name="seller.contact_mode"
                            value="profile"
                            class="custom-control-input"
                          />
                          <label
                            class="custom-control-label"
                            for="offerSellerProfile"
                            >Use from my profile</label
                          >
                        </div>
                        <div
                          class="
                            custom-control custom-radio custom-control-inline
                          "
                        >
                          <input
                            v-model="form.seller.contact_mode"
                            type="radio"
                            id="offerSellerNew"
                            name="seller.contact_mode"
                            value="new"
                            class="custom-control-input"
                          />
                          <label
                            class="custom-control-label"
                            for="offerSellerNew"
                            >Enter new contact</label
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- END offer-seller -->
                  <div
                    class="offer-seller-new"
                    v-show="form.seller.contact_mode === 'new'"
                  >
                    <div
                      class="
                        offer-seller-new-avatar
                        d-flex
                        justify-content-center
                        align-items-center
                      "
                    >
                      <img
                        :src="form.sellerAvatarPreview"
                        :alt="`${form.seller.prename} ${form.seller.name}`"
                        class="rounded-circle"
                      />
                      <div class="upload-btn-wrapper ml-3">
                        <input
                          name="sellerAvatar"
                          type="file"
                          id="sellerAvatar"
                          @change="handleChangeSellerAvatar"
                        />
                        <label for="sellerAvatar">
                          <i class="la la-edit"></i>
                        </label>
                      </div>
                    </div>
                    <!-- END offer-seller-new-avatar -->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewName" class="control-label">
                        Name
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.name"
                          :required="form.seller.contact_mode === 'new'"
                          :error-messages="sellerNameErrors"
                          type="text"
                          name="seller.name"
                          id="offerSellerNewName"
                          class="form-control"
                          :class="{
                            'is-invalid': sellerNameErrors.length > 0,
                          }"
                        />
                        <div
                          class="invalid-feedback text-left"
                          v-show="sellerNameErrors.length > 0"
                        >
                          {{ sellerNameErrors[0] }}
                        </div>
                      </div>
                    </div>
                    <!-- END offer-seller-new-name -->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewPrename" class="control-label">
                        Prename
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.prename"
                          :required="form.seller.contact_mode === 'new'"
                          :error-messages="sellerPrenameErrors"
                          type="text"
                          name="seller.prename"
                          id="offerSellerNewPrename"
                          class="form-control"
                          :class="{
                            'is-invalid': sellerPrenameErrors.length > 0,
                          }"
                        />
                        <div
                          class="invalid-feedback text-left"
                          v-show="sellerPrenameErrors.length > 0"
                        >
                          {{ sellerPrenameErrors[0] }}
                        </div>
                      </div>
                    </div>
                    <!-- END offer-seller-new-prename -->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewEmail" class="control-label">
                        Email
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.email"
                          :required="form.seller.contact_mode === 'new'"
                          :error-messages="sellerEmailErrors"
                          type="text"
                          name="seller.email"
                          id="offerSellerNewEmail"
                          class="form-control"
                          :class="{
                            'is-invalid': sellerEmailErrors.length > 0,
                          }"
                        />
                        <div
                          class="invalid-feedback text-left"
                          v-show="sellerEmailErrors.length > 0"
                        >
                          {{ sellerEmailErrors[0] }}
                        </div>
                      </div>
                    </div>
                    <!-- END offer-seller-new-email -->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewPhone" class="control-label">
                        Phone number
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.phone"
                          :required="form.seller.contact_mode === 'new'"
                          :error-messages="sellerPhoneErrors"
                          type="text"
                          name="seller.phone"
                          id="offerSellerNewPhone"
                          class="form-control"
                          :class="{
                            'is-invalid': sellerPhoneErrors.length > 0,
                          }"
                        />
                        <div
                          class="invalid-feedback text-left"
                          v-show="sellerPhoneErrors.length > 0"
                        >
                          {{ sellerPhoneErrors[0] }}
                        </div>
                      </div>
                    </div>
                    <!-- END offer-seller-new-phone-->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewCompany" class="control-label">
                        Company
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.company"
                          type="text"
                          name="seller.company"
                          id="offerSellerNewCompany"
                        />
                      </div>
                    </div>
                    <!-- END offer-seller-new-company-->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewWebsite" class="control-label">
                        Website
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.website"
                          type="text"
                          name="seller.website"
                          id="offerSellerNewWebsite"
                        />
                      </div>
                    </div>
                    <!-- END offer-seller-new-website-->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewAddress" class="control-label">
                        Address
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.address"
                          type="text"
                          name="seller.address"
                          id="offerSellerNewAddress"
                        />
                      </div>
                    </div>
                    <!-- END offer-seller-new-address -->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewCity" class="control-label">
                        City
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.city"
                          type="text"
                          name="seller.city"
                          id="offerSellerNewCity"
                        />
                      </div>
                    </div>
                    <!-- END offer-seller-new-city -->
                    <div class="form-group IS-INPUTBOX">
                      <label for="offerSellerNewZipcode" class="control-label">
                        Zip code
                      </label>
                      <div class="form-field">
                        <input
                          v-model="form.seller.zipcode"
                          type="text"
                          name="seller.zipcode"
                          id="offerSellerNewZipcode"
                        />
                      </div>
                    </div>
                    <!-- END offer-seller-new-zipcode-->
                  </div>
                  <!-- END offer-seller-new -->
                </div>
              </div>
            </div>
          </form>
        </div>
        <!--blog-single-details end-->
      </div>
    </section>
    <div
      class="modal modal-available-type fade"
      id="modalAvailableType"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalAvailableTypeLabel"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              class="modal-title d-flex align-items-center"
              id="modalAvailableTypeLabel"
            >
              <i class="la la-exclamation-circle"></i>
              <span class="ml-2">Importance Notice</span>
            </h5>
          </div>
          <div class="modal-body">
            <p class="mt-6 font-size-regular">
              I hereby confirm that this offer is not being traded in parallel
              on the public market. It is 100% an off-market offer that is not
              visible on the known platforms.<br />
              <br />
              If it is, our team will place it in the category "On-Market" and
              you will receive a warning (Red Flag). If you receive more than
              one warning, you will be redirected from that platform. Please
              answer:
            </p>
            <div class="offer-available-type-options mt-4">
              <div
                class="custom-control custom-radio mb-2"
                v-for="availableType in availableTypes"
                :key="availableType.value"
              >
                <input
                  v-model="form.marketType"
                  :value="availableType.value"
                  :id="`offerAvailableType_${availableType.value}`"
                  type="radio"
                  name="available_type"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="`offerAvailableType_${availableType.value}`"
                  >{{ availableType.label }}</label
                >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              @click="handleCloseAvailableTypeDialog"
            >
              Edit Offer
            </button>
            <button type="button" class="btn btn-primary" @click="save">
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- END modal-available-type -->
    <div
      class="modal modal-publish-type fade"
      id="modalPublishType"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalPublishTypeLabel"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p class="mt-6">
              After a review, which usually takes 24 hours, we will release your
              offer. Just to be save:
            </p>
            <div class="offer-publish-type-options mt-3">
              <div
                class="custom-control custom-radio"
                v-for="publishType in publishTypes"
                :key="publishType.value"
              >
                <input
                  v-model="form.publishType"
                  :value="publishType.value"
                  type="radio"
                  :id="`offerPublishType_${publishType.value}`"
                  name="publish_type"
                  class="custom-control-input"
                />
                <label
                  class="custom-control-label"
                  :for="`offerPublishType_${publishType.value}`"
                  >{{ publishType.label }}</label
                >
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="savePublishType"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- END modal-publish-type -->
  </div>
</template>

<script>
import axios from "axios";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import DatePicker from 'vue2-datepicker';
import "vue2-datepicker/index.css";
import { validationMixin } from "vuelidate";
import { required, email, numeric } from "vuelidate/lib/validators";
import "jquery-ui";
import "jquery-ui/ui/widgets/sortable";
import "jquery-ui/ui/disable-selection";

const isValidPrice = (price) => {
  const formatted_price = `${price}`.replace(".", "");
  if (!/^[0-9]+$/.test(formatted_price)) {
    return false;
  }
  return true;
};

/* Layout */
import HeaderComponent from "./HeaderComponent.vue";
import FooterComponent from "./FooterComponent.vue";

/* Components */
import CategoriesComponent from "./common/CategoriesComponent.vue";
import PopularOffersComponent from "./common/PopularOffersComponent.vue";

export default {
  name: "FormCreateAuthedOffer",
  components: {
    HeaderComponent,
    FooterComponent,
    CategoriesComponent,
    PopularOffersComponent,
    vueDropzone: vue2Dropzone,
    VueGoogleAutocomplete,
    DatePicker,
  },
  mixins: [validationMixin],

  data() {
    return {
      form: {
        id: null,
        newId: null,
        type: 'real_estate',
        title: "",
        offer_type_id: 1,
        offer_category_id: null,
        status: true,
        privacy: "public",
        privacyGroups: [],
        tags: [],
        location: {
          address: "",
          street: "",
          city: "",
          country: "",
          zip_code: "",
          coordinates: {
            lat: 0,
            lng: 0,
          },
          description: "",
        },
        locationText: "",
        seller: {
          contact_mode: "profile",
          avatar: "",
          name: "",
          prename: "",
          email: "",
          phone: "",
          company: "",
          website: "",
          address: "",
          city: "",
          zipcode: "",
        },
        sellerAvatarPreview: "https://via.placeholder.com/200x200",
        data: {
          primary: {
            currency: "EUR",
          },
          secondary: {},
          building_fabric: {},
          furnishing: '',
          floor_plan: {},
        },
        marketType: "onmarket",
        availableType: "private",
        publishType: "auto",
      },

      categoryOptions: [
        {
          text: "Apartment",
          value: 1,
        },
        {
          text: "House",
          value: 2,
        },
        {
          text: "Commercial property",
          value: 3,
        },
        {
          text: "Hotel",
          value: 4,
        },
        {
          text: "Resort",
          value: 5,
        },
        {
          text: "Property",
          value: 6,
        },
        {
          text: "Miscellaneous",
          value: 7,
        },
      ],

      currencyOptions: ["EUR", "GBP", "USD", "RMB", "JPY"],

      objectStateOptions: [
        "First occupancy",
        "Renovated",
        "In need of renovation",
      ],

      equipmentOptions: ["Standard", "Raised", "Luxury"],

      energySourceOptions: [
        "Natural gas",
        "Oil",
        "Renewable Energies",
        "District heating",
        "Coal",
        "Electricity",
      ],

      heatingTypeOptions: [
        "Heat pump",
        "Fuel cell heating",
        "Wood heating",
        "Oil heating",
        "Gas heating",
        "Electric heating",
      ],

      carBrandOptions: [
        "AC",
        "AMC",
        "ASA",
        "ASM",
        "Abarth",
        "Acura",
        "Ada",
        "Ahrens-Fox",
        "Alfa Romeo",
        "Alpina",
        "Amer",
        "Amphicar",
        "Ariel",
        "Armoury",
        "Aston Martin",
        "Asve",
        "Auburn",
        "Audi",
        "Austin",
        "Austin-Healy",
        "Autobianchi",
        "B Class Lakester",
        "BAC",
        "BMW",
        "Backdraft",
        "Backdraft Racing",
        "Bentley",
        "Bettenhausen",
        "Big Dog",
        "Boss Hoss",
        "Brabus",
        "Bricklin",
        "Brockway",
        "Bugatti",
        "Buick",
        "Chevy",
        "Cadillac",
        "Can-Am",
        "Chevrolet",
        "Chrysler",
        "Citronën",
        "Club Car",
        "Cobra",
        "Concept",
        "Continental",
        "Cooper",
        "Cord",
        "Corvette",
        "Cushman",
        "Custom",
        "Daimler",
        "Datsun",
        "De Tomaso",
        "DeLorean",
        "DeSoto",
        "Delage",
        "Dent",
        "Destiny",
        "Dodge",
        "Donkervoort",
        "Ducati",
        "E.C. OnlyOne",
        "Earl",
        "Edsel",
        "Enzmann",
        "Erskine",
        "Evanta Motors",
        "Excalibur",
        "Factory Five",
        "Ferrari",
        "Fisker",
        "Ford",
        "Formula Freeway",
        "Freightliner",
        "GMC",
        "Genesis",
        "Graham",
        "Gumpert",
        "Hale",
        "Harley-Davidson",
        "Heartland",
        "Henry J",
        "Hilltop",
        "Honda",
        "Horch",
        "Hudson",
        "Hummer",
        "Indian",
        "Infiniti",
        "Intermeccanica",
        "International",
        "Jaguar",
        "Jayco",
        "Jeep",
        "Jensen",
        "John Deere",
        "Knight",
        "KTM",
        "Kaiser",
        "Karma",
        "Kawasaki",
        "Kirkham",
        "Koenigsegg",
        "La France",
        "Lagonda",
        "Lamborghini",
        "Lancia",
        "Land Rover",
        "Las Vegas Trike",
        "Le Grand",
        "Lexus",
        "Lincoln",
        "Lotus",
        "MCI",
        "MG",
        "MTT",
        "Marchi Mobile",
        "Maserati",
        "Maxi",
        "Maybach",
        "Mazda",
        "McCormick & Deering",
        "McLaren",
        "Mehari Loisirs Technologie",
        "Meng",
        "Mercedes-Benz",
        "Mercury",
        "Merlin",
        "Meyers",
        "Mil",
        "Mini",
        "Mitsubsishi",
        "Monarch",
        "Monteverdi",
        "Morgan",
        "Morris",
        "Moto Guzzi",
        "Nash",
        "Nissan",
        "Norton",
        "OK",
        "Oreion",
        "Oakland",
        "Oldsmobile",
        "Opel",
        "Other",
        "PR",
        "Packrd",
        "Pagani",
        "Panther",
        "Pierce-Arrow",
        "Pininfarina",
        "Plymouth",
        "Polaris",
        "Pontiac",
        "Porsche",
        "Prevost",
        "RUF",
        "Radio Flyer",
        "Redneck",
        "Renault",
        "Renegade",
        "Reo",
        "Replica",
        "Riley",
        "Rimac",
        "Rolls-Royce",
        "Rover",
        "Rupp",
        "Skoda",
        "Saab",
        "Saleen",
        "Saturn",
        "Scion",
        "Shelby",
        "Smart",
        "Special Construction",
        "Spyker",
        "Stewart",
        "Studebaker",
        "Stutz",
        "Su",
        "Sunbeam",
        "Superformance",
        "Suzuki",
        "TNT",
        "Tesla",
        "Tiffany",
        "Tor",
        "Toyota",
        "Tramontana",
        "Trasco",
        "Triumph",
        "Ural",
        "VCYC",
        "VLF",
        "VW",
        "Volvo",
        "Willys",
        "Workhorse",
        "Yamaha",
        "Z Lightning McQueen",
        "Z Lil Mater",
        "Z Movie Car",
      ],

      carMileageOptions: [
        "5.000",
        "10.000",
        "15.000",
        "20.000",
        "25.000",
        "30.000",
        "35.000",
        "40.000",
        "45.000",
        "50.000",
        "55.000",
        "60.000",
        "65.000",
        "70.000",
        "75.000",
        "80.000",
        "85.000",
        "90.000",
        "95.0000",
        "100.000",
        "105.000",
        "110.000",
        "115.000",
        "120.000",
        "125.000",
        "130.000",
        "135.000",
        "145.000",
        "150.000",
        "155.000",
        "160.000",
        "165.000",
        "170.000",
        "175.000",
        "180.000",
        "185.000",
        "190.000",
        "195.000",
        "200.000 and more",
      ],

      carFuelTypeOptions: ["Petrol", "Diesel", "Electic"],

      carGearboxOptions: ["Automatic", "Manual"],

      groupOptions: [],
      tagOptions: [],
      selectedPanels: [0, 1],
      freeFromModal: false,
      loading: false,
      sending: false,
      savingPublishType: false,
      logoImage: "/images/logo.svg",
      showGroupDialog: false,

      isCreateSuccess: false,
      showNotification: false,
      notificationMessage: "",
      notificationColor: "info",

      dropzoneOptions: {
        url: "/",
        maxFilesize: 10,
        addRemoveLinks: true,
        autoProcessQueue: false,
        dictRemoveFile: "Remove",
        dictDefaultMessage: "Drop your pictures here",
        thumbnailWidth: 140,
        thumbnailHeight: 140,
        // headers: { Authorization: `Bearer ${user.api_token}` }
      },

      selectedType: "real_estate",
      showTypeDialog: false,
      showAvailableTypeDialog: false,
      showPublishTypeDialog: false,
      types: [
        {
          value: "real_estate",
          label: "Real Estate",
        },
        {
          value: "car",
          label: "Luxury Cars",
        },
        {
          value: "art",
          label: "Art",
        },
      ],
      availableTypes: [
        {
          value: "private",
          label: "The offer is only available here",
        },
        {
          value: "nonpublic",
          label:
            "I have also given the offer to other brokers, but they do not offer it publicly",
        },
        {
          value: "public",
          label: "The offer is also available on other public platforms",
        },
      ],
      publishTypes: [
        {
          value: "auto",
          label: "I would like it to be published directly after the release",
        },
        {
          value: "manual",
          label: "I would like to decide for myself when I publish it",
        },
      ],

      showOverlay: true,
    };
  },

  computed: {
    rules() {
      let validationRules = {
        title: {
          required,
        },
        locationText: {
          required,
        },
        price: {
          required,
          isValidPrice,
        },
      };

      if (this.form.type === "real_estate") {
        validationRules = {
          ...validationRules,
          offer_category_id: {
            required,
          },
          commission: {
            required,
          },
          data: {
            primary: {
              size: {
                required,
                numeric,
              },
              year_of_construction: {
                required,
              },
              free_from: {
                required,
              },
              status: {
                required,
              },
            },
          },
        };
      } else if (this.form.type === "car") {
        validationRules = {
          ...validationRules,
          commission: {
            required,
          },
          data: {
            primary: {
              brand: {
                required,
              },
              model: {
                required,
              },
              year_of_construction: {
                required,
              },
              status: {
                required,
              },
            },
          },
        };
      } else if (this.form.type === "art") {
        validationRules = {
          ...validationRules,
          commission: {
            required,
          },
          data: {
            primary: {
              artist_name: {
                required,
              },
              technique: {
                required,
              },
              year_of_construction: {
                required,
              },
            },
          },
        };
      }

      if (this.form.seller.contact_mode === "new") {
        validationRules["seller"] = {
          name: {
            required,
          },
          prename: {
            required,
          },
          email: {
            required,
            email,
          },
          phone: {
            required,
          },
        };
      }

      return validationRules;
    },

    yearOptions() {
      const years = [];
      const currentYear = new Date().getFullYear();
      for (let i = currentYear; i > 1900; i -= 1) {
        years.push(i);
      }
      return years;
    },

    statusOptions() {
      return ["For rent", "For sale"];
    },

    carStatusOptions() {
      return ["New", "Used"];
    },

    titleErrors() {
      const errors = [];
      if (!this.$v.form.title.$dirty) return errors;
      !this.$v.form.title.required &&
        errors.push("Please enter your offer's title.");

      return errors;
    },

    categoryErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type === "car") return [];

      const errors = [];
      if (!this.$v.form.offer_category_id.$dirty) return errors;
      !this.$v.form.offer_category_id.required &&
        errors.push("Please select your offer's type.");

      return errors;
    },

    locationErrors() {
      const errors = [];
      if (!this.$v.form.locationText.$dirty) return errors;
      !this.$v.form.locationText.required &&
        errors.push("Please enter the location.");

      /* Open the location panel */
      if (errors.length && !this.selectedPanels.includes(0)) {
        this.selectedPanels.push(0);
      }

      return errors;
    },

    priceErrors() {
      const errors = [];
      if (!this.$v.form.price.$dirty) return errors;
      !this.$v.form.price.required && errors.push("This field is required.");
      !this.$v.form.price.isValidPrice &&
        errors.push("Please enter a valid price.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    commissionErrors() {
      /* Only validate if the field is available */
      if (!this.form.type) return [];

      const errors = [];
      if (!this.$v.form.commission.$dirty) return errors;
      !this.$v.form.commission.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    sizeErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "real_estate") return [];

      const errors = [];
      if (!this.$v.form.data.primary.size.$dirty) return errors;
      !this.$v.form.data.primary.size.required &&
        errors.push("This field is required.");
      !this.$v.form.data.primary.size.numeric &&
        errors.push("Please enter a valid size.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    freeFromErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "real_estate") return [];

      const errors = [];
      if (!this.$v.form.data.primary.free_from.$dirty) return errors;
      !this.$v.form.data.primary.free_from.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    yearOfConstructionErrors() {
      const errors = [];
      if (!this.$v.form.data.primary.year_of_construction.$dirty) return errors;
      !this.$v.form.data.primary.year_of_construction.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    statusErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "art") return [];

      const errors = [];
      if (!this.$v.form.data.primary.status.$dirty) return errors;
      !this.$v.form.data.primary.status.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    sellerNameErrors() {
      /* Only validate if New Contact mode is selected */
      if (this.form.seller.contact_mode === "profile") return [];

      const errors = [];
      if (!this.$v.form.seller.name.$dirty) return errors;
      !this.$v.form.seller.name.required &&
        errors.push("This field is required.");

      return errors;
    },

    sellerPrenameErrors() {
      /* Only validate if New Contact mode is selected */
      if (this.form.seller.contact_mode === "profile") return [];

      const errors = [];
      if (!this.$v.form.seller.prename.$dirty) return errors;
      !this.$v.form.seller.prename.required &&
        errors.push("This field is required.");

      return errors;
    },

    sellerEmailErrors() {
      /* Only validate if New Contact mode is selected */
      if (this.form.seller.contact_mode === "profile") return [];

      const errors = [];
      if (!this.$v.form.seller.email.$dirty) return errors;
      !this.$v.form.seller.email.required &&
        errors.push("This field is required.");
      !this.$v.form.seller.email.email &&
        errors.push("Please enter a valid email.");

      return errors;
    },

    sellerPhoneErrors() {
      /* Only validate if New Contact mode is selected */
      if (this.form.seller.contact_mode === "profile") return [];

      const errors = [];
      if (!this.$v.form.seller.phone.$dirty) return errors;
      !this.$v.form.seller.phone.required &&
        errors.push("This field is required.");

      return errors;
    },

    carBrandErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "car") return [];

      const errors = [];
      if (!this.$v.form.data.primary.brand.$dirty) return errors;
      !this.$v.form.data.primary.brand.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    carModelErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "car") return [];

      const errors = [];
      if (!this.$v.form.data.primary.model.$dirty) return errors;
      !this.$v.form.data.primary.model.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    artArtistErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "art") return [];

      const errors = [];
      if (!this.$v.form.data.primary.artist_name.$dirty) return errors;
      !this.$v.form.data.primary.artist_name.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },

    artTechniqueErrors() {
      /* Only validate if the field is available */
      if (!this.form.type || this.form.type !== "art") return [];

      const errors = [];
      if (!this.$v.form.data.primary.technique.$dirty) return errors;
      !this.$v.form.data.primary.technique.required &&
        errors.push("This field is required.");

      /* Open the general information panel */
      if (errors.length && !this.selectedPanels.includes(1)) {
        this.selectedPanels.push(1);
      }

      return errors;
    },
  },

  validations() {
    return {
      form: this.rules,
    };
  },

  created() {
    const jsonUser = localStorage.getItem("user");
    if (!jsonUser) {
      window.location.replace("/");
    } else {
      /* Get the offer type */
      const { search } = window.location;
      if (search.length) {
        let params = search.substring(1).split("&");
        for (let param of params) {
          const [paramName, paramVal] = param.split("=");
          if (paramName === "type") {
            this.form.type = paramVal;
          }
        }
      }

      /* Show loading */
      this.$store.commit('setLoading', true);

      /* In case edit offer, just fetch the offer data */
      const { pathname } = window.location;
      const matches = /^\/offers\/(\d+)\/edit$/.exec(pathname);
      if (matches) {
        const offerId = matches[1];
        Promise.all([
          this.fetchTags(),
          this.fetchGroups(),
          this.getOffer(offerId),
        ]).then((values) => {
          const [tagResponse, groupResponse, offerResponse] = values;
          if (tagResponse.status === 200) {
            const { data } = tagResponse;
            this.tagOptions = data.map((item) => ({
              value: item.id,
              label: item.display_name,
            }));
          }
          if (groupResponse.status === 200) {
            this.groupOptions = groupResponse.data;
          }
          if (offerResponse.status === 200) {
            const { data } = offerResponse;

            this.form.id = data.id;
            this.form.title = data.title;
            this.form.offer_type_id = data.offer_type_id;
            this.form.offer_category_id = data.offer_category_id;
            this.form.type = this.getOfferType(data.offer_type_id);
            this.form.status = data.status === "activated";
            this.form.tags = data.tags.map((tag) => tag.id);
            this.form.price = data.price;
            this.form.commission = data.commission;
            this.form.seller = data.seller;

            /* Privacy */
            this.form.privacy = data.privacy;
            if (data.privacy === "private") {
              this.form.privacyGroups = data.groups.map((group) => {
                const index = this.groupOptions.findIndex(
                  (item) => item.id === group.id
                );
                return index;
              });
            }

            /* Populate location */
            this.form.location = data.location;
            this.form.locationText = data.location.address;

            /* Seller avatar */
            if (
              data.seller.contact_mode === "new" &&
              data.seller.avatar &&
              data.seller.avatar.length
            ) {
              this.form.sellerAvatarPreview = data.seller.avatar;
            }

            /* Images */
            const imageKeys = Object.keys(data.images);
            if (imageKeys.length) {
              const offerImages = this.$refs.offerImages;
              imageKeys.forEach((key) => {
                const image = data.images[key];
                const mockFile = {
                  name: image.name,
                  size: 999,
                  type: "image/jpeg",
                  url: image.url,
                };
                offerImages.dropzone.files.push(mockFile);
                offerImages.dropzone.emit("addedfile", mockFile);
                offerImages.dropzone.emit("thumbnail", mockFile, image.url);
                offerImages.dropzone.emit("complete", mockFile);
              });
            }

            const primary = data.data.primary.data;
            if (data.type.name === "real_estate") {
              const secondary = data.data.secondary.data;
              const floorPlan = data.data.floor_plan.data.images.value;
              const buildingFabric = data.data.building_fabric.data;
              const furnishing = data.data.furnishing.data;
              const documents = data.documents;

              /* Floor Plan */
              const floorPlanKeys = floorPlan ? Object.keys(floorPlan) : [];
              if (floorPlanKeys.length) {
                const offerFloorPlan = this.$refs.offerFloorPlan;
                floorPlanKeys.forEach((key) => {
                  const image = floorPlan[key];
                  const mockFile = {
                    name: image.name,
                    size: 999,
                    type: "image/jpeg",
                    url: image.url,
                  };
                  offerFloorPlan.dropzone.files.push(mockFile);
                  offerFloorPlan.dropzone.emit("addedfile", mockFile);
                  offerFloorPlan.dropzone.emit(
                    "thumbnail",
                    mockFile,
                    image.url
                  );
                  offerFloorPlan.dropzone.emit("complete", mockFile);
                });
              }

              /* Documents */
              const documentKeys = documents ? Object.keys(documents) : [];
              if (documentKeys.length) {
                const offerDocuments = this.$refs.offerDocuments;
                documentKeys.forEach((key) => {
                  const image = documents[key];
                  const mockFile = {
                    name: image.name,
                    size: 999,
                    type: "image/jpeg",
                    url: image.url,
                  };
                  offerDocuments.dropzone.files.push(mockFile);
                  offerDocuments.dropzone.emit("addedfile", mockFile);
                  offerDocuments.dropzone.emit(
                    "thumbnail",
                    mockFile,
                    image.url
                  );
                  offerDocuments.dropzone.emit("complete", mockFile);
                });
              }

              /* Primary */
              this.form.data.primary = {
                currency: primary.currency.value,
                size: primary.size.value,
                free_from: primary.free_from.value,
                year_of_construction: primary.year_of_construction.value,
                status: primary.status.value,
              };

              /* Secondary */
              this.form.data.secondary = {
                rooms: secondary.rooms.value,
                bedroom: secondary.bedroom.value,
                bath_room: secondary.bath_room.value,
                living_room: secondary.living_room.value,
                parking_space: secondary.parking_space.value,
                cellars: secondary.cellars.value,
                floor_in_total: secondary.floor_in_total.value,
              };

              /* Building Fabric */
              this.form.data.building_fabric = {
                object_state: buildingFabric.object_state.value,
                equipment: buildingFabric.equipment.value,
                energy_source: buildingFabric.energy_source.value,
                heating_type: buildingFabric.heating_type.value,
              };

              /* Furnishing */
              this.form.data.furnishing = furnishing.description.value;
            } else if (data.type.name === "car") {
              /* Primary */
              this.form.data.primary = {
                currency: primary.currency.value,
                brand: primary.brand.value,
                model: primary.model.value,
                year_of_construction: primary.year_of_construction.value,
                status: primary.status.value,
                variant: primary.variant.value,
                mileage: primary.mileage.value,
                gearbox: primary.gearbox.value,
                fuel_type: primary.fuel_type.value,
                color: primary.color.value,
                interior_color: primary.interior_color.value,
              };
            } else if (data.type.name === "art") {
              this.form.data.primary = {
                currency: primary.currency.value,
                artist_name: primary.artist_name.value,
                technique: primary.technique.value,
                year_of_construction: primary.year_of_construction.value,
                dimensions: primary.dimensions.value,
                fabrication: primary.fabrication.value,
              };
            }
          }
          this.showOverlay = false;

          this.$store.commit('setLoading', false);
        });
      } else {
        Promise.all([this.fetchTags(), this.fetchGroups()]).then((values) => {
          const [tagResponse, groupResponse] = values;
          if (tagResponse.status === 200) {
            const { data } = tagResponse;
            this.tagOptions = data.map((item) => ({
              value: item.id,
              label: item.display_name,
            }));
          }
          if (groupResponse.status === 200) {
            this.groupOptions = groupResponse.data;
          }
          this.showOverlay = false;
          this.$store.commit('setLoading', false);
        });
      }
    }
  },

  watch: {
    // call again the method if the route changes
    $route (nextRoute){
      this.$store.commit('setLoading', true);
      const { query } = nextRoute;
      if (query && query.type) {
        this.form.type = query.type;
      }
      setTimeout(() => {
        this.$store.commit('setLoading', false);
      }, 1000);
    }
  },

  methods: {
    async getOffer(offerId) {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get(`${window.location.origin}/api/offers/${offerId}`, {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },

    async fetchTags() {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get(`${window.location.origin}/api/tags`, {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },

    async fetchGroups() {
      const user = JSON.parse(localStorage.getItem("user"));
      return axios.get(`${window.location.origin}/api/groups`, {
        headers: { Authorization: `Bearer ${user.api_token}` },
      });
    },

    handleLogout() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .post(`${window.location.origin}/api/logout`, {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            /* Remove user from local storage */
            if (localStorage.getItem("user")) {
              localStorage.removeItem("user");
            }

            /* Redirect users to the login page */
            window.location.replace("/");
          }
        })
        .catch((error) => {
          console.log({ error });
        });
    },

    handleOpenTypeDialog() {
      this.showTypeDialog = true;
    },

    handleCloseTypeDialog() {
      this.showTypeDialog = false;
    },

    handleOpenAvailableTypeDialog() {
      this.showAvailableTypeDialog = true;
      $("#modalAvailableType").modal("show");
    },

    handleCloseAvailableTypeDialog() {
      this.showAvailableTypeDialog = false;
      $("#modalAvailableType").modal("hide");
    },

    handleOpenPublishTypeDialog() {
      this.showPublishTypeDialog = true;
      $("#modalPublishType").modal("show");
    },

    handleClosePublishTypeDialog() {
      this.showPublishTypeDialog = false;
      $("#modalPublishType").modal("hide");
    },

    handleHideOverlay() {
      this.showOverlay = false;
    },

    handleChangeLocation(addressData, placeResultData, id) {
      this.form.location = {
        address: placeResultData.formatted_address,
        street: addressData.name,
        city: addressData.locality,
        country: addressData.country,
        zip_code: addressData.postal_code,
        coordinates: {
          lat: addressData.latitude,
          lng: addressData.longitude,
        },
        description: this.form.location.description,
      };
    },

    handleChangeSellerAvatar(event) {
      const reader = new FileReader();
      const file = event.target.files[0];

      reader.onload = () => {
        this.form.sellerAvatarPreview = reader.result;
      };
      reader.readAsDataURL(file);

      this.form.sellerAvatar = file;
    },

    handleOpenGroupDialog() {
      this.showGroupDialog = true;
    },

    handleCloseGroupDialog() {
      this.showGroupDialog = false;
    },

    handleDeleteGroup(index) {
      this.form.privacyGroups = this.form.privacyGroups.filter(
        (groupIndex) => groupIndex != index
      );
    },

    getCurrencySign(currency) {
      switch (currency) {
        case "EUR":
          return "€";
        case "GBP":
          return "£";
        case "USD":
          return "$";
        case "RMB":
          return "元";
        case "JPY":
          return "¥";
        default:
          return "€";
      }
    },

    validate() {
      this.$v.form.$touch();
      if (this.$v.form.$invalid) {
        this.showNotification = true;
        this.notificationMessage = "Some data are not valid!";
        this.notificationColor = "error";
        return;
      }

      /* In case of new offer, just show the available type dialog */
      if (!this.form.id) {
        this.handleOpenAvailableTypeDialog();
      } else {
        this.submit();
      }
    },

    save() {
      if (this.form.availableType === "public") {
        this.form.marketType = "onmarket";
      }
      this.submit();
    },

    async savePublishType() {
      const user = JSON.parse(localStorage.getItem("user"));
      const data = {
        publish_type: this.form.publishType,
      };
      const url = `${window.location.origin}/api/offers/${this.form.newId}/publish-type`;

      /* Show loading state */
      this.savingPublishType = true;
      this.$store.commit('setLoading', true);

      axios({
        method: "put",
        url,
        data,
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((response) => {
          const { data } = response.data;

          /* Update state */
          this.savingPublishType = false;
          this.handleClosePublishTypeDialog();

          // Open success notification
          this.$store.commit("openNotification", {
            message: "Your offer has been saved!",
            type: "success",
          });

          /* Redirect to the my offers page */
          setTimeout(() => {
            this.$store.commit("closeNotification");
            window.location.replace("/offers");
          }, 2000);
        })
        .catch((error) => {
          console.log({ error });
          this.savingPublishType = false;
          this.handleClosePublishTypeDialog();

          // Open error notification
          this.$store.commit("openNotification", {
            message: "Save failed! Please try again later.",
            type: "error",
          });

          setTimeout(() => {
            this.$store.commit("closeNotification");
          }, 2000);
        });
    },

    async submit() {
      this.sending = true;

      // Show loading
      this.$store.commit('setLoading', true);

      const user = JSON.parse(localStorage.getItem("user"));
      const submittedData = await this.getSubmittedData();
      const submittedUrl = this.form.id
        ? `${window.location.origin}/api/offers/${this.form.id}`
        : `${window.location.origin}/api/offers`;
      const submittedMethod = this.form.id ? "put" : "post";

      axios({
        method: submittedMethod,
        url: submittedUrl,
        data: submittedData,
        headers: {
          Authorization: `Bearer ${user.api_token}`,
        },
      })
        .then((response) => {
          const { data } = response;

          /* Update states */
          this.sending = false;
          this.$store.commit('setLoading', false);

          this.isCreateSuccess = true;

          if (!this.form.id) {
            this.form.newId = data.id;
            this.handleCloseAvailableTypeDialog();
            this.handleOpenPublishTypeDialog();
          } else {
            // Open success notification
            this.$store.commit("openNotification", {
              message: "Your offer has been saved!",
              type: "success",
            });

            /* Redirect to the my offers page */
            setTimeout(() => {
              this.$store.commit("closeNotification");
              this.$router.push({ name: 'myOffers'});
            }, 2000);
          }
        })
        .catch((error) => {
          console.log({ error });
          this.sending = false;
          this.$store.commit('setLoading', false);
          this.isCreateSuccess = false;

          // Open error notification
          this.$store.commit("openNotification", {
            message: "Save failed! Please try again later.",
            type: "error",
          });

          setTimeout(() => {
            this.$store.commit("closeNotification");
          }, 2000);
        });
    },

    async handleUpload() {
      const user = JSON.parse(localStorage.getItem("user"));
      let offerImages = [];
      let offerFloorPlan = [];
      let offerDocuments = [];
      let sellerAvatar = "";
      let uploadedImages = [];
      let uploadedFloorPlan = [];
      let uploadedDocuments = [];

      const offerImageFiles = this.$refs.offerImages.dropzone.files;
      if (offerImageFiles.length) {
        const uploadFiles = offerImageFiles.filter(
          (item) => item.status === "queued"
        );
        if (uploadFiles.length) {
          const formData = new FormData();
          uploadFiles.forEach(function (file) {
            formData.append("file[]", file);
          });
          uploadedImages = await axios
            .post(`${window.location.origin}/api/offer-images`, formData, {
              headers: {
                Authorization: `Bearer ${user.api_token}`,
              },
            })
            .then(({ data }) => data["files"]);
        }

        let j = 0;
        offerImageFiles.forEach((file, i) => {
          if (offerImageFiles[i].status !== "queued") {
            offerImages.push({
              name: offerImageFiles[i].name,
              url: offerImageFiles[i].url,
            });
          } else {
            offerImages.push(uploadedImages[j]);
            j += 1;
          }
        });
      }

      if (this.$refs.offerFloorPlan) {
        const offerFloorPlanFiles = this.$refs.offerFloorPlan.dropzone.files;
        if (offerFloorPlanFiles.length) {
          const uploadFiles = offerFloorPlanFiles.filter(
            (item) => item.status === "queued"
          );
          if (uploadFiles.length) {
            const formData = new FormData();
            uploadFiles.forEach(function (file) {
              formData.append("file[]", file);
            });
            uploadedFloorPlan = await axios
              .post(`${window.location.origin}/api/offer-files`, formData, {
                headers: {
                  Authorization: `Bearer ${user.api_token}`,
                },
              })
              .then(({ data }) => data["files"]);
          }

          let j = 0;
          offerFloorPlanFiles.forEach((file, i) => {
            if (offerFloorPlanFiles[i].status !== "queued") {
              offerFloorPlan.push({
                name: offerFloorPlanFiles[i].name,
                url: offerFloorPlanFiles[i].url,
              });
            } else {
              offerFloorPlan.push(uploadedFloorPlan[j]);
              j += 1;
            }
          });
        }
      }

      if (this.$refs.offerDocuments) {
        const offerDocumentFiles = this.$refs.offerDocuments.dropzone.files;
        if (offerDocumentFiles.length) {
          const uploadFiles = offerDocumentFiles.filter(
            (item) => item.status === "queued"
          );
          if (uploadFiles.length) {
            const formData = new FormData();
            uploadFiles.forEach(function (file) {
              formData.append("file[]", file);
            });
            uploadedDocuments = await axios
              .post(`${window.location.origin}/api/offer-files`, formData, {
                headers: {
                  Authorization: `Bearer ${user.api_token}`,
                },
              })
              .then(({ data }) => data["files"]);
          }

          let j = 0;
          offerDocumentFiles.forEach((file, i) => {
            if (offerDocumentFiles[i].status !== "queued") {
              offerDocuments.push({
                name: offerDocumentFiles[i].name,
                url: offerDocumentFiles[i].url,
              });
            } else {
              offerDocuments.push(uploadedDocuments[j]);
              j += 1;
            }
          });
        }
      }

      if (this.form.sellerAvatar) {
        const formData = new FormData();
        formData.append("file[]", this.form.sellerAvatar);
        sellerAvatar = await axios
          .post(`${window.location.origin}/api/offer-images`, formData, {
            headers: {
              Authorization: `Bearer ${user.api_token}`,
            },
          })
          .then(({ data }) => data["files"][0]["url"]);
      }

      return {
        offerImages,
        offerFloorPlan,
        offerDocuments,
        sellerAvatar,
      };
    },

    async getSubmittedData() {
      let images = {};
      let floorPlan = {};
      let documents = {};
      const { offerImages, offerFloorPlan, offerDocuments, sellerAvatar } =
        await this.handleUpload();
      const user = JSON.parse(localStorage.getItem("user"));

      if (offerImages.length) {
        offerImages.forEach(function (item, i) {
          images[`file_${i}`] = item;
        });
      }
      if (offerFloorPlan.length) {
        offerFloorPlan.forEach(function (item, i) {
          floorPlan[`file_${i}`] = item;
        });
      }
      if (offerDocuments.length) {
        offerDocuments.forEach(function (item, i) {
          documents[`file_${i}`] = item;
        });
      }

      let data;
      if (this.form.type === "real_estate") {
        data = {
          primary: {
            data: {
              currency: {
                name: "Currency",
                value: this.form.data.primary.currency,
              },
              size: {
                name: "Size",
                value: this.form.data.primary.size,
              },
              year_of_construction: {
                name: "Year of Construction",
                value: this.form.data.primary.year_of_construction,
              },
              free_from: {
                name: "Free from",
                value: this.form.data.primary.free_from,
              },
              status: {
                name: "Status",
                value: this.form.data.primary.status,
              },
            },
          },
          secondary: {
            data: {
              rooms: {
                name: "Rooms",
                value: this.form.data.secondary.rooms || "",
              },
              bedroom: {
                name: "Bedroom",
                value: this.form.data.secondary.bedroom || "",
              },
              living_room: {
                name: "Living room",
                value: this.form.data.secondary.living_room || "",
              },
              bath_room: {
                name: "Bathroom",
                value: this.form.data.secondary.bath_room || "",
              },
              cellars: {
                name: "Cellars",
                value: this.form.data.secondary.cellars || "",
              },
              floor_in_total: {
                name: "Floor in total",
                value: this.form.data.secondary.floor_in_total || "",
              },
              parking_space: {
                name: "Parking space",
                value: this.form.data.secondary.parking_space || "",
              },
            },
          },
          building_fabric: {
            name: "Building fabric & energy certificate",
            data: {
              object_state: {
                name: "Object state",
                value: this.form.data.building_fabric.object_state || "",
              },
              equipment: {
                name: "Equipment",
                value: this.form.data.building_fabric.equipment || "",
              },
              energy_source: {
                name: "Energy source",
                value: this.form.data.building_fabric.energy_source || "",
              },
              heating_type: {
                name: "Heating type",
                value: this.form.data.building_fabric.heating_type || "",
              },
            },
          },
          furnishing: {
            name: "Furnishing",
            data: {
              description: {
                value: this.form.data.furnishing || "",
              },
            },
          },
          floor_plan: {
            name: "Floor plan",
            data: {
              images: {
                value: floorPlan["file_0"] ? floorPlan : null,
              },
            },
          },
        };
      } else if (this.form.type === "car") {
        data = {
          primary: {
            data: {
              currency: {
                name: "Currency",
                value: this.form.data.primary.currency,
              },
              brand: {
                name: "Brand",
                value: this.form.data.primary.brand,
              },
              model: {
                name: "Model",
                value: this.form.data.primary.model,
              },
              year_of_construction: {
                name: "Year",
                value: this.form.data.primary.year_of_construction,
              },
              status: {
                name: "Status",
                value: this.form.data.primary.status,
              },
              variant: {
                name: "Variant",
                value: this.form.data.primary.variant,
              },
              mileage: {
                name: "Mileage",
                value: this.form.data.primary.mileage,
              },
              gearbox: {
                name: "Gearbox",
                value: this.form.data.primary.gearbox,
              },
              fuel_type: {
                name: "Fuel type",
                value: this.form.data.primary.fuel_type,
              },
              color: {
                name: "Color",
                value: this.form.data.primary.color,
              },
              interior_color: {
                name: "Interior color",
                value: this.form.data.primary.interior_color,
              },
            },
          },
        };
      } else if (this.form.type === "art") {
        data = {
          primary: {
            data: {
              currency: {
                name: "Currency",
                value: this.form.data.primary.currency,
              },
              artist_name: {
                name: "Artist name",
                value: this.form.data.primary.artist_name,
              },
              technique: {
                name: "Technique",
                value: this.form.data.primary.technique,
              },
              year_of_construction: {
                name: "Year",
                value: this.form.data.primary.year_of_construction,
              },
              dimensions: {
                name: "Dimensions",
                value: this.form.data.primary.dimensions,
              },
              fabrication: {
                name: "Fabrication",
                value: this.form.data.primary.fabrication,
              },
            },
          },
        };
      }

      let seller;
      if (this.form.seller.contact_mode === "profile") {
        seller = {
          ...seller,
          contact_mode: "profile",
          avatar: user.avatar,
          name: user.name,
          prename: user.prename,
          email: user.email,
          phone: user.phone || "",
          company: user.company || "",
          website: user.website || "",
          address: user.address || "",
          city: user.city || "",
          zipcode: user.zip_code || "",
        };
      } else {
        seller = {
          ...this.form.seller,
          contact_mode: "new",
          avatar: !!sellerAvatar ? sellerAvatar : this.form.seller.avatar || "",
        };
      }

      return {
        data,
        title: this.form.title,
        user_id: user.id,
        offer_type_id: this.getOfferTypeId(), // Default to real estate
        offer_category_id: this.getOfferCategoryId(),
        price: this.form.price,
        commission: !!this.form.commission ? this.form.commission : 0,
        location: this.form.location,
        tags: this.form.tags,
        privacy: this.form.privacy,
        groups:
          this.form.privacy === "private"
            ? this.form.privacyGroups.map((i) => this.groupOptions[i].id)
            : [],
        status: this.form.status ? "activated" : "deactivated",
        images: images["file_0"] ? images : null,
        documents: documents["file_0"] ? documents : null,
        seller,
        market_type: this.form.marketType,
        available_type: this.form.availableType,
        publish_type: this.form.publishType,
      };
    },

    getOfferTypeId() {
      const types = [
        "none",
        "real_estate",
        "car",
        "art",
        "horse",
        "yacht",
        "jet",
      ];
      const index = types.indexOf(this.form.type);
      return index !== -1 ? index : 1;
    },

    getOfferType(typeId) {
      const types = [
        "none",
        "real_estate",
        "car",
        "art",
        "horse",
        "yacht",
        "jet",
      ];
      return types[typeId] ? types[typeId] : "real_estate";
    },

    getOfferCategoryId() {
      if (["car", "art"].indexOf(this.form.type) != -1) {
        return 1;
      }
      return this.form.offer_category_id;
    },

    handleToggleGroup(event, groupIndex) {
      const groupIndexIndex = this.form.privacyGroups.findIndex(
        (index) => index === groupIndex
      );
      if (groupIndexIndex !== -1) {
        this.form.privacyGroups.splice(groupIndexIndex, 1);
      } else {
        this.form.privacyGroups.push(groupIndex);
      }
    },
  },

  beforeCreate() {
    const jsonUser = localStorage.getItem("user");
    if (!jsonUser) {
      window.location.replace("/");
    }
  },

  mounted() {
    const offerImages = this.$refs.offerImages;

    // TODO: Remove this test data for location!
    // this.form.location = {
    //   address:"Berliner Str., Berlin, Deutschland",
    //   street:"Berliner Stra\u00dfe",
    //   city:"Berlin",
    //   country:"Deutschland",
    //   coordinates:{
    //     lat: 52.56301169999999700621629017405211925506591796875,
    //     lng: 13.412656399999999479177859029732644557952880859375
    //   },
    //   description:"Malen ist f\u00fcr Gonthier eine intellektuelle Disziplin, die Wahrnehmung entsteht im Gehirn. Wie ein Uhrmachermeister sieht er die Herausforderung in der Komplikation. \"Das Thema der Malerei des Jean-Pierre Gonthier ist die Malerei selbst. Und insbesondere die Konfrontation von Figuration und Abstraktion, die sich mischen, miteinander \u00fcbereinstimmen, manchmal auch Verwirrung stiften.\", wie es Jean-Michel Sarlet treffend beschrieb. Ein Gonthier entsteht in einem intensiven Schaffensprozess, der von anspruchsvollen Kriterien bestimmt wird. Das Ergebnis ist nicht zuf\u00e4llig, es ist die virtuose Komposition eines modernen Meisters seiner Disziplin, der seinen eigenen Weg in der Gegenwartsmalerei beschreitet. \"Ich glaube, dass Jean Pierre Gonthier einmal zu den Gro\u00dfen seiner Zeit z\u00e4hlen wird. Seine Werke werden \u00fcberdauern. Sie sind zeitlose Meisterwerke, die das Potential haben, Menschen heute wie in ferner Zukunft zu faszinieren.\" Oscar Constantin Goossenaerts"
    // }
    // this.form.locationText = "Berliner Str., Berlin, Deutschland";

    $("#offerImages").sortable({
      items: ".dz-preview",
      cursor: "grab",
      opacity: 0.5,
      containment: "#offerImages",
      distance: 20,
      tolerance: "pointer",
      stop: function () {
        // const queue = offerImages.dropzone.getAcceptedFiles();
        const queue = offerImages.dropzone.files;
        let newQueue = [];
        $("#offerImages .dz-preview .dz-filename [data-dz-name]").each(
          function (count, el) {
            const name = el.innerHTML;
            queue.forEach(function (file) {
              if (file.name === name) {
                newQueue.push(file);
              }
            });
          }
        );
        offerImages.dropzone.files = newQueue;
      },
    });
  },
};
</script>
