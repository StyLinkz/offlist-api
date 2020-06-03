<template>
    <div id="wrapper">
        <v-toolbar dark dense>
            <v-container>
                <v-row
                    justify="space-between"
                    align="center"
                >
                    <v-col>
                        <v-toolbar-title>
                            <a href="/">
                                <img :src="logoImage" class="logo" alt="offlist" />
                            </a>
                        </v-toolbar-title>
                    </v-col>
                    <v-col>
                        <v-row justify="end" align="center">
                            <v-btn icon href="/offers">
                                <v-icon>view_list</v-icon>
                            </v-btn>
                            <v-btn icon href="/offers/create">
                                <v-icon>add_circle</v-icon>
                            </v-btn>
                            <v-menu
                                left
                                bottom
                            >
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on">
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-list-item
                                        @click="handleLogout"
                                    >
                                        <v-list-item-title>Logout</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-toolbar>
        <v-container class="mt-5 mb-10">
            <form
                novalidate
                @submit.prevent="validate"
                class="form-create-offer"
            >
                <v-row justify="space-between" align="center" class="mb-3">
                    <h1 class="headline text-uppercase ml-3">Create Offer</h1>
                    <v-btn
                        dark
                        color="primary"
                        type="submit"
                        class="mr-3"
                        :loading="sending"
                    >
                        SAVE
                    </v-btn>
                </v-row>
                <v-divider></v-divider>
                <v-row class="mt-4 mb-8">
                    <v-col cols="12" md="6">
                        <vue-dropzone
                            ref="offerImages"
                            id="offerImages"
                            class="offer-dropzone mt-1"
                            :options="{
                                ...dropzoneOptions,
                                acceptedFiles: 'image/*'
                            }"
                        ></vue-dropzone>
                        <v-card class="mt-4">
                            <v-card-title class="subtitle-1 text-uppercase font-weight-bold ml-1">
                                Status
                            </v-card-title>
                            <v-card-text>
                                <v-switch
                                    v-model="form.status"
                                    inset
                                    :label="form.status ? 'Active' : 'Inactive'"
                                    class="ml-2"
                                >
                                </v-switch>
                            </v-card-text>
                        </v-card>
                        <v-card class="mt-4">
                            <v-card-title class="subtitle-1 text-uppercase font-weight-bold ml-1">
                                Privacy
                            </v-card-title>
                            <v-card-text>
                                <v-radio-group v-model="form.privacy" row>
                                    <v-radio label="Public" value="public"></v-radio>
                                    <v-radio label="Private" value="private"></v-radio>
                                </v-radio-group>
                                <div class="offer__group" v-show="form.privacy === 'private'">
                                    <v-row justify="space-between" align="center" class="px-4">
                                        <h3 class="subtitle-2 text-uppercase">Groups</h3>
                                        <v-btn small color="primary" @click="handleOpenGroupDialog">Add</v-btn>
                                    </v-row>
                                    <div class="mt-2">
                                        <h3 class="body-2 ml-1" v-if="!form.privacyGroups.length">
                                            Please add at least one group.
                                        </h3>
                                        <div class="offer__group__selected" v-else>
                                            <v-list>
                                                <v-list-item
                                                    v-for="groupIndex in form.privacyGroups"
                                                    :key="`group_selected_${groupIndex}`"
                                                    @click="handleDeleteGroup(groupIndex)"
                                                >
                                                    <v-list-item-content>
                                                        <v-list-item-title v-text="groupOptions[groupIndex].name"></v-list-item-title>
                                                    </v-list-item-content>
                                                    <v-list-item-icon>
                                                        <v-icon>delete</v-icon>
                                                    </v-list-item-icon>
                                                </v-list-item>
                                            </v-list>
                                        </div>
                                    </div>
                                    <v-dialog v-model="showGroupDialog" scrollable max-width="500px">
                                        <v-card>
                                            <v-card-title>Add Groups</v-card-title>
                                            <v-divider></v-divider>
                                            <v-card-text style="height: 300px;">
                                                <v-list two-line>
                                                    <v-list-item-group
                                                        v-model="form.privacyGroups"
                                                        multiple
                                                    >
                                                        <template v-for="(item, index) in groupOptions">
                                                            <v-list-item :key="`group_${item.id}`">
                                                                <template v-slot:default="{ active, toggle }">
                                                                    <v-list-item-content>
                                                                        <v-list-item-title v-text="item.name"></v-list-item-title>
                                                                        <v-list-item-subtitle v-text="item.description"></v-list-item-subtitle>
                                                                    </v-list-item-content>
                                                                    <v-list-item-action>
                                                                        <v-icon
                                                                            v-if="!active"
                                                                        >
                                                                            add_circle_outline
                                                                        </v-icon>

                                                                        <v-icon
                                                                            v-else
                                                                            color="primary"
                                                                        >
                                                                            done
                                                                        </v-icon>
                                                                    </v-list-item-action>
                                                                </template>
                                                            </v-list-item>
                                                            <v-divider
                                                                v-if="index + 1 < groupOptions.length"
                                                                :key="index"
                                                            ></v-divider>
                                                        </template>
                                                    </v-list-item-group>
                                                </v-list>
                                            </v-card-text>
                                            <v-divider></v-divider>
                                            <v-card-actions>
                                                <v-btn color="blue darken-1" text @click="showGroupDialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" text @click="showGroupDialog = false">OK</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </div>
                            </v-card-text>
                        </v-card>
                        <v-card class="mt-4">
                            <v-card-title class="subtitle-1 text-uppercase font-weight-bold ml-1">
                                Seller
                            </v-card-title>
                            <v-card-text>
                                <v-radio-group v-model="form.seller.contact_mode" row>
                                    <v-radio label="Use from my profile" value="profile"></v-radio>
                                    <v-radio label="Enter new contact" value="new"></v-radio>
                                </v-radio-group>
                                <div class="offer__seller" v-show="form.seller.contact_mode === 'new'">
                                    <v-row justify="center" align="center">
                                        <v-avatar width="130" height="130">
                                            <img
                                                :src="this.form.sellerAvatarPreview"
                                                alt="Seller"
                                            >
                                        </v-avatar>
                                        <div class="upload-btn-wrapper">
                                            <input name="sellerAvatar" type="file" id="sellerAvatar" @change="handleChangeSellerAvatar" />
                                            <label for="sellerAvatar">
                                                <v-btn class="ma-4 pointer-event-none" outlined fab color="primary">
                                                    <v-icon>mdi-pencil</v-icon>
                                                </v-btn>
                                            </label>
                                        </div>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="form.seller.name"
                                                label="Name"
                                                required
                                                :error-messages="sellerNameErrors"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="form.seller.prename"
                                                label="Prename"
                                                required
                                                :error-messages="sellerPrenameErrors"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="form.seller.email"
                                                label="Email"
                                                required
                                                :error-messages="sellerEmailErrors"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="form.seller.phone"
                                                label="Phone number"
                                                required
                                                :error-messages="sellerPhoneErrors"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="form.seller.company"
                                                label="Company"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="form.seller.website"
                                                label="Website"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="form.seller.address"
                                                label="Address"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="form.seller.city"
                                                label="City"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="form.seller.zipcode"
                                                label="Zip code"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="form.title"
                            label="Headline"
                            required
                            :error-messages="titleErrors"
                        ></v-text-field>
                        <v-select
                            v-model="form.offer_category_id"
                            :items="categoryOptions"
                            :error-messages="categoryErrors"
                            label="Type"
                            required
                        ></v-select>
                        <div class="offer__data mt-5">
                            <v-expansion-panels
                                v-model="selectedPanels"
                                multiple
                            >
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <h3 class="subtitle-1 font-weight-bold text-uppercase">Location</h3>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <vuetify-google-autocomplete
                                            ref="location"
                                            id="offerLocation"
                                            placeholder="Location"
                                            v-model="form.locationText"
                                            v-on:placechanged="handleChangeLocation"
                                            required
                                            :error-messages="locationErrors"
                                        >
                                        </vuetify-google-autocomplete>
                                        <v-textarea
                                            v-model="form.location.description"
                                            label="Description"
                                        ></v-textarea>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <h3 class="subtitle-1 font-weight-bold text-uppercase">General Information</h3>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.price"
                                                    label="Price"
                                                    name="primary.price"
                                                    required
                                                    suffix="$"
                                                    :error-messages="priceErrors"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.priceTax"
                                                    label="Price incl VAT"
                                                    name="primary.priceTax"
                                                    required
                                                    suffix="$"
                                                    :error-messages="priceTaxErrors"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.commission"
                                                    label="Commission"
                                                    name="primary.commission"
                                                    required
                                                    suffix="%"
                                                    :error-messages="commissionErrors"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="form.data.primary.size"
                                                    label="Size"
                                                    name="primary.size"
                                                    required
                                                    suffix="m2"
                                                    :error-messages="sizeErrors"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <v-select
                                                    v-model="form.data.primary.year_of_construction"
                                                    :items="yearOptions"
                                                    label="Year of Construction"
                                                    required
                                                    :error-messages="yearOfConstructionErrors"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-dialog
                                                    ref="freeFromDialog"
                                                    v-model="freeFromModal"
                                                    :return-value.sync="form.data.primary.free_from"
                                                    persistent
                                                    width="290px"
                                                >
                                                    <template v-slot:activator="{ on }">
                                                        <v-text-field
                                                            v-model="form.data.primary.free_from"
                                                            label="Free from"
                                                            v-on="on"
                                                            required
                                                            :error-messages="freeFromErrors"
                                                        ></v-text-field>
                                                    </template>
                                                    <v-date-picker v-model="form.data.primary.free_from" scrollable>
                                                        <v-spacer></v-spacer>
                                                        <v-btn text color="primary" @click="freeFromModal = false">Cancel</v-btn>
                                                        <v-btn text color="primary" @click="$refs.freeFromDialog.save(form.data.primary.free_from)">OK</v-btn>
                                                    </v-date-picker>
                                                </v-dialog>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <v-select
                                                    v-model="form.data.primary.status"
                                                    :items="statusOptions"
                                                    label="Status"
                                                    :error-messages="statusErrors"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <h3 class="subtitle-1 font-weight-bold text-uppercase">Tags</h3>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col
                                                v-for="tag in tagOptions"
                                                :key="`tag_${tag.value}`"
                                                cols="12"
                                                md="4"
                                            >
                                                <v-checkbox
                                                    v-model="form.tags"
                                                    :label="tag.label"
                                                    :value="tag.value"
                                                    dense
                                                    class="mt-0"
                                                ></v-checkbox>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <h3 class="subtitle-1 font-weight-bold text-uppercase">
                                            Property Information
                                        </h3>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.rooms"
                                                    label="Rooms"
                                                    name="secondary.rooms"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.bedroom"
                                                    label="Bedroom"
                                                    name="secondary.bedroom"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.living_room"
                                                    label="Living room"
                                                    name="secondary.living_room"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.bath_room"
                                                    label="Bathroom"
                                                    name="secondary.bath_room"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.cellars"
                                                    label="Cellars"
                                                    name="secondary.cellars"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.floor_in_total"
                                                    label="Floors in total"
                                                    name="secondary.floor_in_total"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.secondary.parking_space"
                                                    label="Parking space"
                                                    name="secondary.parking_space"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <h3 class="subtitle-1 font-weight-bold text-uppercase">
                                            Building fabric & energy certificate
                                        </h3>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.building_fabric.object_state"
                                                    label="Object state"
                                                    name="secondary.object_state"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.building_fabric.equipment"
                                                    label="Equipment"
                                                    name="secondary.equipment"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.building_fabric.energy_source"
                                                    label="Energy source"
                                                    name="secondary.energy_source"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="form.data.building_fabric.heating_type"
                                                    label="Heating type"
                                                    name="secondary.heating_type"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <h3 class="subtitle-1 font-weight-bold text-uppercase">
                                            Furnishing
                                        </h3>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.data.furnishing"
                                            name="secondary.furnishing"
                                            placeholder="Enter text..."
                                        ></v-textarea>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                            <v-card class="mt-4">
                                <v-card-title class="subtitle-1 text-uppercase font-weight-bold ml-1">
                                    Floor Plan
                                </v-card-title>
                                <v-card-text>
                                    <vue-dropzone
                                        ref="offerFloorPlan"
                                        id="offerFloorPlan"
                                        class="offer-dropzone offer_floorPlan"
                                        :options="{
                                            ...dropzoneOptions,
                                            acceptedFiles: 'image/*'
                                        }"
                                    ></vue-dropzone>
                                </v-card-text>
                            </v-card>
                            <v-card class="mt-4">
                                <v-card-title class="subtitle-1 text-uppercase font-weight-bold ml-1">
                                    Documents
                                </v-card-title>
                                <v-card-text>
                                    <vue-dropzone
                                        ref="offerDocuments"
                                        id="offerDocuments"
                                        class="offer-dropzone offer_documents"
                                        :options="{
                                            ...dropzoneOptions,
                                            dictDefaultMessage: 'Drop your documents here'
                                        }"
                                    ></vue-dropzone>
                                </v-card-text>
                            </v-card>
                        </div>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row justify="end">
                    <v-btn
                        dark
                        color="primary"
                        type="submit"
                        class="mt-3 mr-3"
                        :loading="sending"
                    >
                        SAVE
                    </v-btn>
                </v-row>
                <v-snackbar
                    v-model="showNotification"
                    :timeout="3000"
                    :color="notificationColor"
                >
                    {{ notificationMessage }}
                </v-snackbar>
            </form>
        </v-container>
    </div>
</template>
<script>
    import axios from 'axios';
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import { validationMixin } from 'vuelidate'
    import {
        required,
        email,
        numeric
    } from 'vuelidate/lib/validators'
    export default {
        name: 'FormCreateOffer',
        components: {
            vueDropzone: vue2Dropzone
        },
        mixins: [validationMixin],

        beforeCreate() {
            const jsonUser = localStorage.getItem('user');
            if (!jsonUser) {
                window.location.replace('/');
            }
        },

        data() {
            return {
                form: {
                    id: null,
                    title: '',
                    offer_type_id: 1,
                    offer_category_id: null,
                    status: true,
                    privacy: 'public',
                    privacyGroups: [],
                    tags: [],
                    location: {
                        address: '',
                        street: '',
                        city: '',
                        country: '',
                        zip_code: '',
                        coordinates: {
                            lat: 0,
                            lng: 0,
                        },
                        description: ''
                    },
                    locationText: '',
                    seller: {
                        contact_mode: 'profile',
                        avatar: '',
                        name: '',
                        prename: '',
                        email: '',
                        phone: '',
                        company: '',
                        website: '',
                        address: '',
                        city: '',
                        zipcode: '',
                    },
                    sellerAvatarPreview: 'https://via.placeholder.com/200x200',
                    data: {
                        primary: {},
                        secondary: {},
                        building_fabric: {},
                        furnishing: {},
                        floor_plan: {},
                    },
                },

                categoryOptions: [
                    {
                        text: 'Apartment',
                        value: 1,
                    },
                    {
                        text: 'House',
                        value: 2,
                    },
                    {
                        text: 'Commercial property',
                        value: 3,
                    },
                    {
                        text: 'Hotel',
                        value: 4,
                    },
                    {
                        text: 'Resort',
                        value: 5,
                    },
                    {
                        text: 'Property',
                        value: 6,
                    },
                    {
                        text: 'Miscellaneous',
                        value: 7,
                    },
                ],
                groupOptions: [],
                tagOptions: [],
                selectedPanels: [0, 1],
                freeFromModal: false,
                loading: false,
                sending: false,
                logoImage: '/images/logo.svg',
                showGroupDialog: false,

                isCreateSuccess: false,
                showNotification: false,
                notificationMessage: '',
                notificationColor: 'info',

                dropzoneOptions: {
                    url: '/',
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    autoProcessQueue: false,
                    dictRemoveFile: 'Remove',
                    dictDefaultMessage: 'Drop your pictures here',
                    // headers: { Authorization: `Bearer ${user.api_token}` }
                }
            };
        },

        computed: {
            rules () {
                return {
                    title: {
                        required
                    },
                    offer_category_id: {
                        required
                    },
                    locationText: {
                        required
                    },
                    price: {
                        required,
                        numeric
                    },
                    priceTax: {
                        required,
                        numeric
                    },
                    commission: {
                        required,
                    },
                    seller: {
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
                    },
                    data: {
                        primary: {
                            size: {
                                required,
                                numeric
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
                }
            },

            yearOptions () {
                const years = [];
                const currentYear = (new Date()).getFullYear();
                for (let i = currentYear; i > 1900; i -= 1) {
                    years.push(i);
                }
                return years;
            },

            statusOptions () {
                return [
                    'For rent',
                    'For sale',
                ];
            },

            titleErrors () {
                const errors = []
                if (!this.$v.form.title.$dirty) return errors
                !this.$v.form.title.required && errors.push('Please enter your offer\'s title.')
                return errors
            },

            categoryErrors () {
                const errors = []
                if (!this.$v.form.offer_category_id.$dirty) return errors
                !this.$v.form.offer_category_id.required && errors.push('Please select your offer\'s type.')
                return errors
            },

            locationErrors () {
                const errors = []
                if (!this.$v.form.locationText.$dirty) return errors
                !this.$v.form.locationText.required && errors.push('Please enter the location.')

                /* Open the location panel */
                if (errors.length && !this.selectedPanels.includes(0)) {
                    this.selectedPanels.push(0);
                }

                return errors
            },

            priceErrors () {
                const errors = []
                if (!this.$v.form.price.$dirty) return errors
                !this.$v.form.price.required && errors.push('This field is required.')
                !this.$v.form.price.numeric && errors.push('Please enter a valid price.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            priceTaxErrors () {
                const errors = []
                if (!this.$v.form.priceTax.$dirty) return errors
                !this.$v.form.priceTax.required && errors.push('This field is required.')
                !this.$v.form.priceTax.numeric && errors.push('Please enter a valid price.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            commissionErrors () {
                const errors = []
                if (!this.$v.form.commission.$dirty) return errors
                !this.$v.form.commission.required && errors.push('This field is required.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            sizeErrors () {
                const errors = []
                if (!this.$v.form.data.primary.size.$dirty) return errors
                !this.$v.form.data.primary.size.required && errors.push('This field is required.')
                !this.$v.form.data.primary.size.numeric && errors.push('Please enter a valid size.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            freeFromErrors () {
                const errors = []
                if (!this.$v.form.data.primary.free_from.$dirty) return errors
                !this.$v.form.data.primary.free_from.required && errors.push('This field is required.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            yearOfConstructionErrors () {
                const errors = []
                if (!this.$v.form.data.primary.year_of_construction.$dirty) return errors
                !this.$v.form.data.primary.year_of_construction.required && errors.push('This field is required.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            statusErrors () {
                const errors = []
                if (!this.$v.form.data.primary.status.$dirty) return errors
                !this.$v.form.data.primary.status.required && errors.push('This field is required.')

                /* Open the general information panel */
                if (errors.length && !this.selectedPanels.includes(1)) {
                    this.selectedPanels.push(1);
                }

                return errors
            },

            sellerNameErrors () {
                /* Only validate if New Contact mode is selected */
                if (this.form.seller.contact_mode === 'profile') return [];

                const errors = []
                if (!this.$v.form.seller.name.$dirty) return errors
                !this.$v.form.seller.name.required && errors.push('This field is required.')
                return errors
            },

            sellerPrenameErrors () {
                /* Only validate if New Contact mode is selected */
                if (this.form.seller.contact_mode === 'profile') return [];

                const errors = []
                if (!this.$v.form.seller.prename.$dirty) return errors
                !this.$v.form.seller.prename.required && errors.push('This field is required.')
                return errors
            },

            sellerEmailErrors () {
                /* Only validate if New Contact mode is selected */
                if (this.form.seller.contact_mode === 'profile') return [];

                const errors = []
                if (!this.$v.form.seller.email.$dirty) return errors
                !this.$v.form.seller.email.required && errors.push('This field is required.')
                !this.$v.form.seller.email.email && errors.push('Please enter a valid email.')
                return errors
            },

            sellerPhoneErrors () {
                /* Only validate if New Contact mode is selected */
                if (this.form.seller.contact_mode === 'profile') return [];

                const errors = []
                if (!this.$v.form.seller.phone.$dirty) return errors
                !this.$v.form.seller.phone.required && errors.push('This field is required.')
                return errors
            },
        },

        validations () {
            return {
                form: this.rules
            }
        },

        created () {
            const jsonUser = localStorage.getItem('user');
            if (!jsonUser) {
                window.location.replace('/');
            } else {
                this.fetchTags();
                this.fetchGroups();

                /* In case edit offer, just fetch the offer data */
                const { pathname } = window.location;
                const matches = /^\/offers\/(\d+)\/edit$/.exec(pathname);
                if (matches) {
                    const offerId = matches[1];
                    this.getOffer(offerId);
                }
            }
        },

        methods: {
            getOffer (offerId) {
                const user = JSON.parse(localStorage.getItem('user'));
                axios.get(
                    `/api/offers/${offerId}`,
                    {
                        headers: { Authorization: `Bearer ${user.api_token}` }
                    }
                )
                    .then((response) => {
                        if (response.status === 200) {
                            const { data } = response;
                            const primary = data.data.primary.data;
                            const secondary = data.data.secondary.data;
                            const floorPlan = data.data.floor_plan.data.images.value;
                            const buildingFabric = data.data.building_fabric.data;
                            const furnishing = data.data.furnishing.data;
                            const documents = data.documents;

                            this.form.id = data.id;
                            this.form.title = data.title;
                            this.form.offer_category_id = data.type.id;
                            this.form.status = data.status === 'activated';
                            this.form.tags = data.tags.map((tag) => tag.id);
                            this.form.price = data.price;
                            this.form.priceTax = data.price_tax;
                            this.form.commission = data.commission;
                            this.form.seller = data.seller;

                            /* Privacy */
                            this.form.privacy = data.privacy;
                            if (data.privacy === 'private') {
                                this.form.privacyGroups = data.groups.map((group) => {
                                    const index = this.groupOptions.findIndex(item => item.id === group.id);
                                    return index;
                                });
                            }

                            /* Seller avatar */
                            if (data.seller.contact_mode === 'new'
                                && data.seller.avatar
                                && data.seller.avatar.length
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
                                        type: 'image/jpeg',
                                        url: image.url,
                                    };
                                    offerImages.dropzone.files.push(mockFile);
                                    offerImages.dropzone.emit('addedfile', mockFile);
                                    offerImages.dropzone.emit('thumbnail', mockFile, image.url);
                                    offerImages.dropzone.emit('complete', mockFile);
                                });
                            }

                            /* Floor Plan */
                            const floorPlanKeys = floorPlan ? Object.keys(floorPlan) : [];
                            if (floorPlanKeys.length) {
                                const offerFloorPlan = this.$refs.offerFloorPlan;
                                floorPlanKeys.forEach((key) => {
                                    const image = floorPlan[key];
                                    const mockFile = {
                                        name: image.name,
                                        size: 999,
                                        type: 'image/jpeg',
                                        url: image.url,
                                    };
                                    offerFloorPlan.dropzone.files.push(mockFile);
                                    offerFloorPlan.dropzone.emit('addedfile', mockFile);
                                    offerFloorPlan.dropzone.emit('thumbnail', mockFile, image.url);
                                    offerFloorPlan.dropzone.emit('complete', mockFile);
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
                                        type: 'image/jpeg',
                                        url: image.url,
                                    };
                                    offerDocuments.dropzone.files.push(mockFile);
                                    offerDocuments.dropzone.emit('addedfile', mockFile);
                                    offerDocuments.dropzone.emit('thumbnail', mockFile, image.url);
                                    offerDocuments.dropzone.emit('complete', mockFile);
                                });
                            }

                            /* Populate location */
                            this.form.location = data.location;
                            this.form.locationText = data.location.address;

                            /* Primary */
                            this.form.data.primary = {
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
                        }
                    })
                    .catch((error) => {
                        console.log({ error });
                    })
            },

            fetchTags () {
                const user = JSON.parse(localStorage.getItem('user'));
                axios.get(
                    '/api/tags',
                    {
                        headers: { Authorization: `Bearer ${user.api_token}` }
                    }
                )
                    .then((response) => {
                        if (response.status === 200) {
                            const { data } = response;
                            this.tagOptions = data.map((item) => ({
                                value: item.id,
                                label: item.display_name
                            }))
                        }
                    })
                    .catch((error) => {
                        console.log({ error });
                    })
            },

            fetchGroups () {
                const user = JSON.parse(localStorage.getItem('user'));
                axios.get(
                    '/api/groups',
                    {
                        headers: { Authorization: `Bearer ${user.api_token}` }
                    }
                )
                    .then((response) => {
                        if (response.status === 200) {
                            const { data } = response;
                            this.groupOptions = data;
                        }
                    })
                    .catch((error) => {
                        console.log({ error });
                    })

            },

            handleLogout () {
                if (localStorage.getItem('user')) {
                    localStorage.removeItem('user');
                }
                window.location.replace('/');
            },

            handleChangeLocation (addressData, placeResultData, id) {
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

            handleChangeSellerAvatar (event) {
                const reader = new FileReader();
                const file = event.target.files[0];

                reader.onload = () => {
                    this.form.sellerAvatarPreview = reader.result;
                };
                reader.readAsDataURL(file);

                this.form.sellerAvatar = file;
            },

            handleOpenGroupDialog () {
                this.showGroupDialog = true;
            },

            handleCloseGroupDialog () {
                this.showGroupDialog = false;
            },

            handleDeleteGroup (index) {
                this.form.privacyGroups = this.form.privacyGroups.filter(groupIndex => groupIndex != index);
            },

            validate () {
                this.$v.form.$touch()
                if (this.$v.form.$invalid) {
                    this.showNotification = true;
                    this.notificationMessage = 'Some data are not valid!';
                    this.notificationColor = 'error';
                    return;
                }
                this.submit()
            },

            async submit() {
                this.sending = true;

                const user = JSON.parse(localStorage.getItem('user'));
                const submittedData = await this.getSubmittedData();
                const submittedUrl = this.form.id ? `/api/offers/${this.form.id}` : 'api/offers';
                const submittedMethod = this.form.id ? 'put' : 'post';
                axios({
                    method: submittedMethod,
                    url: submittedUrl,
                    data: submittedData,
                    headers: {
                        Authorization: `Bearer ${user.api_token}`
                    }
                })
                    .then((response) => {
                        const { data } = response.data;

                        /* Update states */
                        this.sending = false;
                        this.isCreateSuccess = true;
                        this.showNotification = true;
                        this.notificationMessage = 'Your offer has been saved!';
                        this.notificationColor = 'success';

                        /* Redirect to the offer list page */
                        setTimeout(function () {
                            window.location.replace('/offers');
                        }, 2000);
                    })
                    .catch((error) => {
                        console.log({ error });
                        this.sending = false;
                        this.isCreateSuccess = false;
                        this.showNotification = true;
                        this.notificationMessage = 'Save failed! Please try again later.';
                        this.notificationColor = 'error';
                    })
            },

            async handleUpload () {
                const user = JSON.parse(localStorage.getItem('user'));
                let offerImages = [];
                let offerFloorPlan = [];
                let offerDocuments = [];
                let sellerAvatar = '';
                let uploadedImages = [];
                let uploadedFloorPlan = [];
                let uploadedDocuments = [];

                const offerImageFiles = this.$refs.offerImages.dropzone.files;
                if (offerImageFiles.length) {
                    const uploadFiles = offerImageFiles.filter(item => item.status === 'queued');
                    if (uploadFiles.length) {
                        const formData = new FormData();
                        uploadFiles.forEach(function (file) {
                            formData.append('file[]', file);
                        });
                        uploadedImages = await axios
                            .post(
                                '/api/offer-images',
                                formData,
                                {
                                    headers: {
                                        Authorization: `Bearer ${user.api_token}`
                                    }
                                },
                            )
                            .then(({ data }) => data['files']);
                    }

                    let j = 0;
                    offerImageFiles.forEach((file, i) => {
                        if (offerImageFiles[i].status !== 'queued') {
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
                        const uploadFiles = offerFloorPlanFiles.filter(item => item.status === 'queued');
                        if (uploadFiles.length) {
                            const formData = new FormData();
                            uploadFiles.forEach(function (file) {
                                formData.append('file[]', file);
                            });
                            uploadedFloorPlan = await axios
                                .post(
                                    '/api/offer-files',
                                    formData,
                                    {
                                        headers: {
                                            Authorization: `Bearer ${user.api_token}`
                                        }
                                    },
                                )
                                .then(({ data }) => data['files']);
                        }

                        let j = 0;
                        offerFloorPlanFiles.forEach((file, i) => {
                            if (offerFloorPlanFiles[i].status !== 'queued') {
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
                        const uploadFiles = offerDocumentFiles.filter(item => item.status === 'queued');
                        if (uploadFiles.length) {
                            const formData = new FormData();
                            uploadFiles.forEach(function (file) {
                                formData.append('file[]', file);
                            });
                            uploadedDocuments = await axios
                                .post(
                                    '/api/offer-files',
                                    formData,
                                    {
                                        headers: {
                                            Authorization: `Bearer ${user.api_token}`
                                        }
                                    },
                                )
                                .then(({ data }) => data['files']);
                        }

                        let j = 0;
                        offerDocumentFiles.forEach((file, i) => {
                            if (offerDocumentFiles[i].status !== 'queued') {
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
                    formData.append('file[]', this.form.sellerAvatar);
                    sellerAvatar = await axios
                        .post(
                            '/api/offer-images',
                            formData,
                            {
                                headers: {
                                    Authorization: `Bearer ${user.api_token}`
                                }
                            },
                        )
                        .then(({ data }) => data['files'][0]['url']);
                }

                return {
                    offerImages,
                    offerFloorPlan,
                    offerDocuments,
                    sellerAvatar,
                };
            },

            async getSubmittedData () {
                let images = {};
                let floorPlan = {};
                let documents = {};
                const {
                    offerImages,
                    offerFloorPlan,
                    offerDocuments,
                    sellerAvatar,
                } = await this.handleUpload();
                const user = JSON.parse(localStorage.getItem('user'));

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

                const data = {
                    primary: {
                        data: {
                            size: {
                                name: 'Size',
                                value: this.form.data.primary.size
                            },
                            year_of_construction: {
                                name: 'Year of Construction',
                                value: this.form.data.primary.year_of_construction
                            },
                            free_from: {
                                name: 'Free from',
                                value: this.form.data.primary.free_from
                            },
                            status: {
                                name: 'Status',
                                value: this.form.data.primary.status
                            },
                        },
                    },
                    secondary: {
                        data: {
                            rooms: {
                                name: 'Rooms',
                                value: this.form.data.secondary.rooms || ''
                            },
                            bedroom: {
                                name: 'Bedroom',
                                value: this.form.data.secondary.bedroom || ''
                            },
                            living_room: {
                                name: 'Living room',
                                value: this.form.data.secondary.living_room || ''
                            },
                            bath_room: {
                                name: 'Bathroom',
                                value: this.form.data.secondary.bath_room || ''
                            },
                            cellars: {
                                name: 'Cellars',
                                value: this.form.data.secondary.cellars || ''
                            },
                            floor_in_total: {
                                name: 'Floor in total',
                                value: this.form.data.secondary.floor_in_total || ''
                            },
                            parking_space: {
                                name: 'Parking space',
                                value: this.form.data.secondary.parking_space || ''
                            },
                        },
                    },
                    building_fabric: {
                        name: 'Building fabric & energy certificate',
                        data: {
                            object_state: {
                                name: 'Object state',
                                value: this.form.data.building_fabric.object_state || '',
                            },
                            equipment: {
                                name: 'Equipment',
                                value: this.form.data.building_fabric.equipment || '',
                            },
                            energy_source: {
                                name: 'Energy source',
                                value: this.form.data.building_fabric.energy_source || '',
                            },
                            heating_type: {
                                name: 'Heating type',
                                value: this.form.data.building_fabric.heating_type || '',
                            },
                        },
                    },
                    furnishing: {
                        name: 'Furnishing',
                        data: {
                            description: {
                                value: this.form.data.furnishing || ''
                            },
                        },
                    },
                    floor_plan: {
                        name: 'Floor plan',
                        data: {
                            images: {
                                value: floorPlan['file_0'] ? floorPlan : null
                            },
                        },
                    },
                };

                return {
                    data,
                    title: this.form.title,
                    user_id: user.id,
                    offer_type_id: 1, // Default to real estate
                    offer_category_id: this.form.offer_category_id,
                    price: this.form.price,
                    price_tax: this.form.priceTax,
                    commission: this.form.commission,
                    location: this.form.location,
                    tags: this.form.tags,
                    privacy: this.form.privacy,
                    groups: this.form.privacy === 'private'
                        ? this.form.privacyGroups.map(i => this.groupOptions[i].id)
                        : [],
                    seller: {
                        ...this.form.seller,
                        avatar: !!sellerAvatar
                            ? sellerAvatar
                            : (this.form.seller.avatar || ''),
                    },
                    status: this.form.status ? 'activated' : 'deactivated',
                    images: images['file_0'] ? images : null,
                    documents: documents['file_0'] ? documents : null,
                };
            }

        }
    }
</script>
