<template>
    <div class="page-login page-free-listing">
        <a href="/imprint" target="_blank" class="login-imprint">Imprint</a>
        <v-carousel
            cycle
            hide-delimiters
            hide-delimiter-background
            :show-arrows="false"
            height="100%"
            interval="3000"
        >
            <v-carousel-item
                v-for="(slide, i) in slides"
                class="login-slide bg-full bg-cover bg-overlay fill-height"
                :key="i"
                :style="{ backgroundImage: 'url(' + slide + ')' }"
            >
            </v-carousel-item>
        </v-carousel>
        <div class="login-container">
            <v-container class="h-100">
                <div class="d-flex flex-column align-center fill-height">
                    <v-row justify="center" align="center">
                        <v-col cols="12" sm="8" md="8">
                            <div class="login-content">
                                <img :src="logoImage" class="logo" alt="offlist" />
                                <p class="title text-white mt-6 mb-8 font-normal">
                                    The closed off-market marketplace for real estate, luxury cars, art, horses, yachts, private jets and other luxury goods that are not traded in public.
                                </p>
                                <div class="login-app-download d-flex flex-row">
                                    <a href="https://itunes.apple.com" target="_blank" class="btn-download-app mr-2">
                                        <img :src="appStoreImage" alt="offlist" />
                                    </a>
                                    <a href="https://play.google.com" target="_blank" class="btn-download-app">
                                        <img :src="googlePlayImage" alt="offlist" />
                                    </a>
                                </div>
                            </div>
                        </v-col>
                        <v-col cols="12" sm="4" md="4" class="no-padding">
                            <v-card class="free-listing-card">
                                <v-card-title class="justify-center free-listing-title">
                                    <span>
                                        Your free listing to an exclusive network:
                                    </span>
                                </v-card-title>
                                <v-card-text class="pt-0">
                                    <p class="font-size-regular">
                                        Here you place an exclusive and free advertisement for real estate, luxury cars, art, horses, yachts and private jets to offer for sale to our elite circle. Your data will be treated absolutely confidential and the ad will only be published in the protected and not freely accessible app. There are no costs for you!
                                        <br/>
                                        <br/>
                                        Submit your offer here:
                                    </p>
                                    <div class="free-listing-categories">
                                        <h4 class="text-center text-uppercase">Please select a category</h4>
                                    </div>
                                    <v-btn
                                        block
                                        dark
                                        color="primary"
                                        class="mt-6"
                                        @click="submit"
                                        :loading="loading"
                                    >
                                        Apply
                                    </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </div>
            </v-container>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FreeListing',
        beforeCreate() {
            const jsonUser = localStorage.getItem('user');
            if (jsonUser) {
                const user = JSON.parse(jsonUser);
                if (user.api_token) {
                    window.location.replace('/offers');
                }
            }
        },
        data() {
            return {
                showNotification: false,
                logoImage: '/images/logo.svg',
                appStoreImage: '/images/app-store.png',
                googlePlayImage: '/images/google-play.png',
                backgroundImage: '/images/bg-login.jpg',
                slides: [
                    '/images/slides/bg-real-estate.jpg',
                    '/images/slides/bg-car.jpg',
                    '/images/slides/bg-art.jpg',
                    '/images/slides/bg-horse.jpg',
                    '/images/slides/bg-yatch.jpg',
                    '/images/slides/bg-jet.jpg',
                ],
            };
        },
        computed: {
        },
        methods: {
            submit () {
                console.log('submit');
            },
        }
    }
</script>

<style lang="scss" scoped>
    .md-progress-bar {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
    }
</style>
