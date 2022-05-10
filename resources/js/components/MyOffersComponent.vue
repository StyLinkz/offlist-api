<template>
  <div class="my-offers-page">
    <section class="pager-sec bfr">
      <div class="container">
        <div class="pager-sec-details">
          <h3>My Offers</h3>
        </div>
      </div>
    </section>
    <section class="section-my-offers">
      <div class="container">
        <div class="offers-wrapper">
          <div class="listing-directs">
            <div class="list_products" v-if="offers.length > 0">
              <div class="row">
                <div
                  class="col-lg-4 col-md-6"
                  v-for="offer in offers"
                  :key="`offer_row_${offer.id}`"
                >
                  <list-item-component
                    :offer="offer"
                    :isOwner="true"
                    :onPressDeleteButton="handlePressDeleteButton"
                    type="personal"
                  />
                </div>
              </div>
            </div>
            <!--list_products end-->
          </div>
        </div>
      </div>
    </section>
    <offer-delete-modal-component :offerId="deletedOfferId" :onDeleteSuccess="handleDeleteSuccess" />
  </div>
</template>
<script>
import axios from "axios";
import Papa from "papaparse";

/* Components */
import ListItemComponent from "./offers/ListItemComponent.vue";
import OfferDeleteModalComponent from "./OfferDeleteModalComponent.vue";

export default {
  components: {
    ListItemComponent,
    OfferDeleteModalComponent,
  },

  data: () => ({
    key: new Date().valueOf(),
    logoImage: "/images/logo.svg",
    loading: false,
    importing: false,
    deleting: false,
    updatingStatus: false,
    isDeleteSuccess: false,
    isImportSuccess: false,
    showNotification: false,
    notificationMessage: "",
    notificationColor: "success",
    showImportDialog: false,
    selectedType: "real_estate",
    showTypeDialog: false,
    dialog: false,
    headers: [
      {
        text: "Title",
        align: "start",
        sortable: false,
        value: "title",
        width: "30%",
      },
      { text: "Category", value: "category" },
      { text: "Price", value: "price" },
      { text: "Commission", value: "commission" },
      { text: "Privacy", value: "privacy" },
      { text: "Status", value: "status" },
      { text: "Created At", value: "createdAt" },
      {
        text: "Actions",
        value: "actions",
        sortable: false,
        width: "8%",
      },
    ],
    offers: [],
    importFile: null,
    importFileError: null,
    tagOptions: [],
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
    realEstateCategoryOptions: [
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
    importOfferLocations: [],
    importOffers: [],
    deletedOfferId: null,
  }),

  created() {
    const jsonUser = localStorage.getItem("user");
    if (!jsonUser) {
      window.location.replace("/");
    } else {
      this.$store.commit('setLoading', true);

      /* Fetch data */
      this.fetchOffers();
      this.fetchTags();
    }
  },

  methods: {
    fetchTags() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .get("https://offlist.de/api/tags", {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.tagOptions = data.map((item) => ({
              value: item.id,
              label: item.display_name,
            }));
          }
        })
        .catch((error) => {
          console.log({ error });
        });
    },

    fetchOffers() {
      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .get("https://offlist.de/api/auth-offers", {
          headers: { Authorization: `Bearer ${user.api_token}` },
        })
        .then((response) => {
          if (response.status === 200) {
            const { data } = response;
            this.offers = data.map((item) => {
              const currency = item.data.primary.data.currency
                ? item.data.primary.data.currency.value
                : "EUR";
              const commission = item.commission.replace(",", ".");
              const images = Object.values(item.images);
              return {
                id: item.id,
                title: item.title,
                thumbnail: images.length
                  ? images[0].url
                  : "https://via.placeholder.com/370x295",
                category: this.getOfferType(item.offer_type_id),
                price: item.price,
                currency: this.getCurrencySign(currency),
                commission: `${commission}%`,
                privacy:
                  item.privacy === "public"
                    ? "Public Offerboard"
                    : "Private Group",
                status: item.status === "activated",
                location: item.location,
                primaryData: item.data.primary.data,
                secondaryData: item.data.secondary ? item.data.secondary.data : null,
                createdAt: item.created_at,
                wisthlistUsers: item.wishlist_users,
                isAddedToWishlist: item.wishlist_users ? !!item.wishlist_users.find((u) => u.id === user.id) : false,
              };
            });
          }
          this.loading = false;
          this.$store.commit('setLoading', false);

          // Save offers to local storage for later use (on the offer detail page)
          localStorage.setItem('offers', JSON.stringify(this.offers));
        })
        .catch((error) => {
          console.log({ error });
          this.loading = false;
          this.$store.commit('setLoading', false);
        });
    },

    handleChangeStatus(item) {
      this.updatingStatus = true;

      const user = JSON.parse(localStorage.getItem("user"));
      axios
        .put(
          `https://offlist.de/api/offers/${item.id}/status`,
          {
            status: item.status ? "activated" : "deactivated",
          },
          {
            headers: { Authorization: `Bearer ${user.api_token}` },
          }
        )
        .then((response) => {
          this.updatingStatus = false;
        })
        .catch((error) => {
          console.log({ error });
          this.updatingStatus = false;
        });
    },

    handlePressDeleteButton(offerId) {
      this.deletedOfferId = offerId;
    },

    handleDeleteSuccess() {
      this.offers = this.offers.filter((offer) => offer.id != this.deletedOfferId);
    },

    handleImportOffers() {
      if (!this.importFile) {
        this.importFileError = "Please select your csv file.";
        return;
      }

      this.importFileError = null;
      this.importing = true;

      Papa.parse(this.importFile, {
        complete: (results) => {
          if (results && results.data && results.data.length > 1) {
            const user = JSON.parse(localStorage.getItem("user"));
            const fields = results.data[0];
            const rows = results.data.slice(1);
            rows.forEach((row, i) => {
              const formattedRow = row.reduce((res, rowItem, j) => {
                return {
                  ...res,
                  [fields[j]]: rowItem,
                };
              }, {});

              /* Update the import offer list */
              this.importOffers.push(this.getSubmittedData(formattedRow));

              /* Get the location details */
              const sydney = new google.maps.LatLng(-33.867, 151.195);
              const map = new google.maps.Map(document.getElementById("map"), {
                center: sydney,
                zoom: 15,
              });
              const request = {
                query: formattedRow["Location"],
                fields: ["name", "formatted_address", "geometry", "place_id"],
              };
              const service = new google.maps.places.PlacesService(map);
              service.findPlaceFromQuery(request, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                  const result = results[0];
                  const getPlaceDetailRequest = {
                    placeId: result.place_id,
                    fields: ["name", "geometry", "address_component"],
                  };
                  service.getDetails(
                    getPlaceDetailRequest,
                    (place, detailStatus) => {
                      if (
                        detailStatus ===
                        google.maps.places.PlacesServiceStatus.OK
                      ) {
                        const { address_components } = place;
                        let street = null;
                        let city = null;
                        let country = null;
                        let zipCode = null;
                        address_components.forEach((component) => {
                          if (component.types.includes("routes")) {
                            street = component.long_name;
                          } else if (component.types.includes("locality")) {
                            city = component.long_name;
                          } else if (component.types.includes("country")) {
                            country = component.long_name;
                          } else if (component.types.includes("postal_code")) {
                            zipCode = component.long_name;
                          }
                        });
                        this.importOfferLocations.push({
                          address: result.formatted_address,
                          city,
                          country,
                          zip_code: zipCode,
                          coordinates: {
                            lat: result.geometry.location.lat(),
                            lng: result.geometry.location.lng(),
                          },
                        });
                      }
                    }
                  );
                }
              });
            });

            /* This interval works like a watcher */
            const googleInterval = setInterval(() => {
              if (this.importOfferLocations.length === rows.length) {
                const offers = this.importOffers.map((item, i) => {
                  return {
                    ...item,
                    location: {
                      ...this.importOfferLocations[i],
                      description: item.location.description,
                    },
                  };
                });

                /* Import the offers */
                axios({
                  method: "post",
                  url: "https://offlist.de/api/offers/import",
                  data: {
                    offers,
                  },
                  headers: {
                    Authorization: `Bearer ${user.api_token}`,
                  },
                })
                  .then((response) => {
                    const { data } = response.data;

                    /* Update states */
                    this.sending = false;
                    this.isImportSuccess = true;
                    this.showNotification = true;
                    this.notificationMessage = "Import success!";
                    this.notificationColor = "success";

                    /* Redirect to the offer list page */
                    setTimeout(function () {
                      window.location.replace("/offers");
                    }, 2000);
                  })
                  .catch((error) => {
                    console.log({ error });
                    this.sending = false;
                    this.isImportSuccess = false;
                    this.showNotification = true;
                    this.notificationMessage =
                      "Import failed! Please try again later.";
                    this.notificationColor = "error";
                  });

                /* Clear the interval to remove the watcher */
                clearInterval(googleInterval);
              }
            }, 1000);
          }
        },
      });
    },

    getSubmittedData(row) {
      const user = JSON.parse(localStorage.getItem("user"));
      const offerType = row["Category"].toLowerCase().split(" ").join("_");
      const typeId = this.getOfferTypeId(offerType);
      let data;
      let categoryId;

      if (offerType === "real estate") {
        data = {
          primary: {
            data: {
              currency: {
                name: "Currency",
                value: row["Currency"] ? row["Currency"].toUpperCase() : "EUR",
              },
              size: {
                name: "Size",
                value: row["Size"],
              },
              year_of_construction: {
                name: "Year of Construction",
                value: parseInt(row["Year of construction"]),
              },
              free_from: {
                name: "Free from",
                value: row["Free from"],
              },
              status: {
                name: "Status",
                value: row["Sale status"],
              },
            },
          },
          secondary: {
            data: {
              rooms: {
                name: "Rooms",
                value: row["Rooms"] || "",
              },
              bedroom: {
                name: "Bedroom",
                value: row["Bedroom"] || "",
              },
              living_room: {
                name: "Living room",
                value: row["Living room"] || "",
              },
              bath_room: {
                name: "Bathroom",
                value: row["Bathroom"] || "",
              },
              cellars: {
                name: "Cellars",
                value: row["Cellars"] || "",
              },
              floor_in_total: {
                name: "Floor in total",
                value: row["Floor in total"] || "",
              },
              parking_space: {
                name: "Parking space",
                value: row["Parking space"] || "",
              },
            },
          },
          building_fabric: {
            name: "Building fabric & energy certificate",
            data: {
              object_state: {
                name: "Object state",
                value: row["Object state"] || "",
              },
              equipment: {
                name: "Equipment",
                value: row["Equipment"] || "",
              },
              energy_source: {
                name: "Energy source",
                value: row["Energy source"] || "",
              },
              heating_type: {
                name: "Heating type",
                value: row["Heating type"] || "",
              },
            },
          },
          furnishing: {
            name: "Furnishing",
            data: {
              description: {
                value: row["Furnishing"] || "",
              },
            },
          },
          floor_plan: {
            name: "Floor plan",
            data: {
              images: {
                value: null,
              },
            },
          },
        };

        /* Get the category */
        const category = this.realEstateCategoryOptions.find(
          (option) => option.text === row["Type"]
        );
        categoryId = category ? category.value : 1;
      } else if (offerType === "car") {
        data = {
          primary: {
            data: {
              currency: {
                name: "Currency",
                value: row["Currency"] ? row["Currency"].toUpperCase() : "EUR",
              },
              brand: {
                name: "Brand",
                value: row["Brand"],
              },
              model: {
                name: "Model",
                value: row["Model"],
              },
              year_of_construction: {
                name: "Year",
                value: parseInt(row["Year"]),
              },
              status: {
                name: "Status",
                value: row["Sale status"],
              },
              variant: {
                name: "Variant",
                value: row["Variant"],
              },
              mileage: {
                name: "Mileage",
                value: row["Mileage"],
              },
              gearbox: {
                name: "Gearbox",
                value: row["Gearbox"],
              },
              fuel_type: {
                name: "Fuel type",
                value: row["Fuel type"],
              },
              color: {
                name: "Color",
                value: row["Color"],
              },
              interior_color: {
                name: "Interior color",
                value: row["Interior color"],
              },
            },
          },
        };

        /* Category is default */
        categoryId = 1;
      } else if (offerType === "art") {
        data = {
          primary: {
            data: {
              currency: {
                name: "Currency",
                value: row["Currency"] ? row["Currency"].toUpperCase() : "EUR",
              },
              artist_name: {
                name: "Artist name",
                value: row["Artist"],
              },
              technique: {
                name: "Technique",
                value: row["Technique"],
              },
              year_of_construction: {
                name: "Year",
                value: parseInt(row["Year"]),
              },
              dimensions: {
                name: "Dimensions",
                value: row["Dimensions"],
              },
              fabrication: {
                name: "Fabrication",
                value: row["Fabrication"],
              },
            },
          },
        };

        /* Category is default */
        categoryId = 1;
      }

      /* Get the tag ids */
      const tagIds = [];
      if (offerType === "real_estate") {
        const tags = row["Tags"].split(",");
        tags.forEach((tag) => {
          const tagOption = this.tagOptions.find(
            (item) => item.label.toLowerCase() === tag.toLowerCase()
          );
          if (tagOption) {
            tagIds.push(tagOption.value);
          }
        });
      }

      return {
        data,
        title: row["Title"],
        user_id: user.id,
        offer_type_id: typeId, // Default to real estate
        offer_category_id: categoryId,
        price: row["Price"],
        price_tax: 0,
        commission: offerType === "car" ? 0 : row["Commission"],
        location: {
          address: row["Location"] || "",
          street: "",
          city: "",
          country: "",
          zip_code: "",
          coordinates: {
            lat: 0,
            lng: 0,
          },
          description: row["Location description"] || "",
        },
        tags: tagIds,
        privacy: row["Privacy"].toLowerCase(),
        groups: row["Privacy"].toLowerCase() === "private" ? [] : [],
        seller: {
          contact_mode: "profile",
          avatar: user.avatar,
          name: user.name,
          prename: user.prename,
          email: user.email,
          phone: user.phone,
          company: user.company,
          website: user.website,
          address: user.address,
          city: user.city,
          zipcode: user.zip_code,
        },
        status: row["Status"].toLowerCase(),
        images: {
          // Create a default image for later update
          file_0: {
            name: "import_offer_image",
            url: "https://via.placeholder.com/640x480",
          },
        },
        documents: null,
      };
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

    getOfferTypeId(type) {
      const types = [
        "none",
        "real_estate",
        "car",
        "art",
        "horse",
        "yacht",
        "jet",
      ];
      const index = types.indexOf(type);
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
      return types[typeId];
    },

    getOfferCategory(offer) {
      const type = this.getOfferType(offer.offer_type_id);
      switch (type) {
        case "real_estate":
          return offer.category.display_name;
        case "car":
          return "Luxury Cars";
        case "art":
          return "Art";
        default:
          return "";
      }
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
      return types[typeId];
    },
  },
};
</script>
