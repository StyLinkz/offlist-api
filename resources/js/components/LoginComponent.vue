<template>
    <div class="page-login bg-full bg-cover bg-overlay" :style="{ backgroundImage: 'url(' + backgroundImage + ')' }">
        <v-row justify="center" align="center" class="page-login__inner">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12">
                        <v-container>
                            <v-row justify="center" align="center">
                                <v-col cols="8">
                                    <div class="login-content">
                                        <img :src="logoImage" class="logo" alt="offlist" />
                                        <p class="title text-white mt-6 mb-8 font-normal">
                                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                        </p>
                                        <div class="d-flex flex-row">
                                            <a href="https://itunes.apple.com" target="_blank" class="btn-download-app mr-2">
                                                <img :src="appStoreImage" alt="offlist" />
                                            </a>
                                            <a href="https://play.google.com" target="_blank" class="btn-download-app">
                                                <img :src="googlePlayImage" alt="offlist" />
                                            </a>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="4">
                                    <form
                                        novalidate
                                        @submit.prevent="validate"
                                        class="login-form"
                                    >
                                        <v-card class="mx-auto">
                                            <v-card-title class="justify-center">Member Login</v-card-title>
                                            <v-card-text class="pt-0">
                                                <v-text-field
                                                    v-model="email"
                                                    label="Email"
                                                    name="email"
                                                    required
                                                    :error-messages="emailErrors"
                                                    @input="$v.email.$touch()"
                                                    @blur="$v.email.$touch()"
                                                ></v-text-field>
                                                <v-text-field
                                                    v-model="password"
                                                    label="Password"
                                                    name="password"
                                                    type="password"
                                                    required
                                                    :error-messages="passwordErrors"
                                                    @input="$v.password.$touch()"
                                                    @blur="$v.password.$touch()"
                                                ></v-text-field>
                                                <v-btn
                                                    block
                                                    dark
                                                    color="primary"
                                                    type="submit"
                                                    class="mt-6"
                                                    :loading="sending"
                                                >
                                                    Sign In
                                                </v-btn>
                                            </v-card-text>
                                        </v-card>
                                    </form>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-col>
                </v-row>
            </v-container>
        </v-row>
        <v-snackbar
            v-model="showNotification"
            :timeout="3000"
            :color="isLoginSuccess ? 'success' : 'error'"
        >
            {{ isLoginSuccess ? 'Login successful!' : 'Email or Password is incorrect!' }}
        </v-snackbar>
    </div>
</template>

<script>
    import axios from 'axios';
    import { validationMixin } from 'vuelidate'
    import {
        required,
        email,
    } from 'vuelidate/lib/validators'
    export default {
        name: 'FormLogin',
        mixins: [validationMixin],
        validations: {
            email: {
                required,
                email
            },
            password: {
                required
            }
        },
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
                email: null,
                password: null,
                sending: false,
                showNotification: false,
                isLoginSuccess: false,
                logoImage: '/images/logo.svg',
                appStoreImage: '/images/app-store.png',
                googlePlayImage: '/images/google-play.png',
                backgroundImage: '/images/bg-login.jpg',
            };
        },
        computed: {
            emailErrors () {
                const errors = []
                if (!this.$v.email.$dirty) return errors
                !this.$v.email.required && errors.push('Please enter your email address.')
                !this.$v.email.email && errors.push('Please enter a valid email address.')
                return errors
            },
            passwordErrors () {
                const errors = []
                if (!this.$v.password.$dirty) return errors
                !this.$v.password.required && errors.push('Please enter your password.')
                return errors
            },
        },
        methods: {
            clearForm () {
                this.$v.$reset()
                this.email = null
                this.password = null
            },
            submit() {
                this.sending = true;

                /* Handle submit here */
                axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                })
                    .then((response) => {
                        const { data } = response.data;

                        /* Save user's data to local storage */
                        localStorage.setItem('user', JSON.stringify(data));

                        /* Update states */
                        this.sending = false;
                        this.isLoginSuccess = true;
                        this.showNotification = true;

                        /* Redirect to the offer list page */
                        setTimeout(function () {
                            window.location.replace('/offers');
                        }, 2000);
                    })
                    .catch((error) => {
                        console.log({ error });
                        this.sending = false;
                        this.isLoginSuccess = false;
                        this.showNotification = true;
                    })
            },
            validate () {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.submit()
                }
            }
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
