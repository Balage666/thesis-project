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
                            {{ __("Blue Venue is a completely made up brand name for my webshop application created for my thesis. The app developed with the following technologies mainly: Laravel, Inertia, Vue3, FormKit, PrimeVue, Bootstrap") }}
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">{{ __('Main Sources') }}</h6>
                        <p>
                            <a href="https://laravel.com/docs/11.x" class="text-white">{{ __('Laravel Documentation') }}</a>
                        </p>
                        <p>
                            <a href="https://inertiajs.com/" class="text-white">{{ __('Inertia Documentation') }}</a>
                        </p>
                        <p>
                            <a href="https://vuejs.org/" class="text-white">{{ __('Vue3 Documentation') }}</a>
                        </p>
                        <p>
                            <a href="https://getbootstrap.com/docs/5.3/getting-started/introduction/" class="text-white">{{ __('Bootstrap Documentation') }}</a>
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">
                            {{ __('Account') }}
                        </h6>
                        <p>
                            <Link :href="route('user-profile', {user: $page.props.active_session.user } )" class="text-white" v-if="$page.props.permissions.authenticated">{{ __('Your Account') }}</Link>
                            <Link :href="route('log-in')" class="text-white" v-else>{{ __('Login') }}</Link>
                        </p>
                    </div>

                </div>

            </section>

            <hr class="my-3">

            <section v-if="!$page.props.permissions.authenticated">

                <p class="d-flex justify-content-center align-items-center">
                    <span class="me-3 fw-bold">{{ __('Register for free!') }}</span>
                    <Link :href="route('sign-up')" type="button" class="fw-bold btn btn-secondary rounded">
                        {{ __('Sign up') }}
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
