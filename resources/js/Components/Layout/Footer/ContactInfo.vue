<script setup>

import { Link } from '@inertiajs/inertia-vue3';

import { usedTechnologies } from '*js-shared/technologies';

</script>

<!--TODO: Add the rest of the technologies-->
<template>
    <div class="p-3 banner-bg-color">

        <div class="p-3 pb-0 rounded-5 contact-info-bg-color">

            <section>

                <div class="row">
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">
                            Blue Venue
                        </h6>
                        <p>
                            Blue Venue is a completely made up brand name for my webshop application
                            created for my thesis. The app developed with the following technologies mainly:
                            Laravel, Inertia, Vue3, FormKit, PrimeVue, Bootstrap
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">Sources</h6>
                        <p>
                            <a class="text-white">Laravel Documentation</a>
                        </p>
                        <p>
                            <a class="text-white">Inertia Documentation</a>
                        </p>
                        <p>
                            <a class="text-white">Vue3 Documentation</a>
                        </p>
                        <p>
                            <a class="text-white">Bootstrap Documentation</a>
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">
                            Useful links
                        </h6>
                        <p>
                            <a class="text-white" v-if="$page.props.permissions.authenticated">Your Account</a>
                            <a class="text-white" v-else>Login</a>
                        </p>
                        <p>
                            <a class="text-white">Distributors</a>
                        </p>
                        <p>
                            <a class="text-white">Brands</a>
                        </p>
                        <p>
                            <a class="text-white">Introduction page</a>
                        </p>
                    </div>

                    <!-- <hr class="w-100 clearfix d-md-none" /> -->

                    <!-- <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">Contact</h6>
                        <p><i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
                        <p><i class="fas fa-envelope mr-3"></i> info@gmail.com</p>
                        <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
                    </div> -->
                </div>

            </section>

            <hr class="my-3">

            <section v-if="!$page.props.permissions.authenticated">

                <p class="d-flex justify-content-center align-items-center">
                    <span class="me-3 fw-bold">Register for free!</span>
                    <Link :href="route('sign-up')" type="button" class="fw-bold btn btn-secondary rounded">
                        Sign up
                    </Link>
                </p>

            </section>

            <hr class="my-3" v-if="!$page.props.permissions.authenticated">

            <section class="p-3 pt-0">
                <div class="row d-flex align-items-center">

                    <div class="col-12 col-lg-6 text-center">
                        <div class="p-3">
                            <span class="fw-bold">{{ __("Technologies used during development:") }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 ml-lg-0 text-center">

                        <a
                            v-for="technology in usedTechnologies"
                            class="btn btn-secondary m-1 text-white"
                            :href="__(technology.url)"
                            :title="technology.title"
                            role="button"
                        > <i :class="technology.icon"></i> </a>

                    </div>
                </div>

            </section>

        </div>

    </div>
</template>
