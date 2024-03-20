<script setup>

import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue';
import { Popover } from 'bootstrap';

const pageProps = ref(usePage().props.value);

const currentUser = ref(pageProps.value.active_session.user);
const permissions = ref(pageProps.value.permissions)

// const popOverList = ref([]);

// onMounted(() => {

//     let list = document.querySelectorAll('[data-bs-toggle="popover"]');

//     popOverList.value = [...list].map(element => new Popover(element));

// })


</script>


<template>
    <nav class="navbar navbar-expand-lg banner-bg-color">
        <div class="container-fluid bg-light rounded-5 mx-3 p-3">
            <Link class="navbar-brand py-2" :href="route('storefront')">{{ __("Storefront") }}</Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa-solid fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!--TODO: Remove this-->
                <!-- <div class="w-75 py-2 ms-lg-auto me-lg-auto ms-sm-auto me-sm-auto" v-show="route().current('storefront')">
                    <form class="d-flex" role="search">
                        <input class="form-control form-control-lg form-control-sm rounded-start-5" type="search" :placeholder="__('Search')" aria-label="Search">
                        <button class="btn btn-primary rounded-end-5" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                    </form>
                </div> -->

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 py-2">

                    <!-- FIXME: Dropdown is bugged on smaller screen resolutions, when items are shown -->
                    <div class="m-auto">
                        <li class="nav-item dropdown-center" v-if="!permissions.authenticated">
                            <button class="nav-link row" role="button" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user"></i> <span class="col-12"> {{ __("Account") }} </span>
                            </button>
                            <ul class="dropdown-menu bg-white">
                                <li><Link :href="route('log-in')" method="get" as="button" class="dropdown-item text-center"><i class="fa-solid fa-right-to-bracket"></i> {{ __("Login") }}</Link></li>
                                <li><Link :href="route('sign-up')" method="get" as="button" class="dropdown-item text-center"><i class="fa-solid fa-plus"></i> {{ __("SignUp") }}</Link></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown-center" v-else>
                            <button class="nav-link row" role="button" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="col-12 fa-solid fa-user"></i> <span class="col-12">{{ currentUser.name }}</span>
                            </button>
                            <ul class="dropdown-menu bg-white">
                                <li v-show="permissions.elligible_for_dashboard"><Link :href="route('dashboard-main')" as="button" method="get" class="dropdown-item text-center"><i class="fa-solid fa-toolbox"></i> {{ __("Dashboard") }}</Link></li>
                                <li v-show="permissions.authenticated"><Link :href="route('user-profile', { user: currentUser })" as="button" method="get" class="dropdown-item text-center"><i class="fa-solid fa-address-card"></i> {{ __("My profile") }}</Link></li>
                                <li><Link :href="route('log-out')" as="button" method="get" class="dropdown-item text-center"><i class="fa-solid fa-door-open"></i> {{ __("LogOut") }}</Link></li>
                            </ul>
                        </li>
                    </div>


                    <li class="nav-item m-auto" v-if="permissions.authenticated">
                        <!-- <button
                            class="nav-link row"
                            data-bs-toggle="popover"
                            data-bs-content="And here's some amazing content. It's very engaging. Right?"
                            data-bs-placement="left"
                            data-bs-custom-class="navbar-popover"
                        > -->
                        <button class="nav-link row">
                            <i class="fa-solid fa-heart"></i>
                            <span class="col-12">
                                {{ __("Favorites") }}
                                <span v-if="currentUser?.favorites.length > 0" class="badge text-bg-danger">{{ currentUser?.favorites.length }}</span>
                            </span>
                        </button>

                    </li>

                    <li class="nav-item m-auto">
                        <!-- <button
                            class="nav-link row"

                            data-bs-toggle="popover"
                            data-bs-content="And here's some amazing content. It's very engaging. Right?"
                            data-bs-placement="left"
                            data-bs-custom-class="navbar-popover"
                        > -->
                        <button class="nav-link row">
                            <i class="fa-solid fa-basket-shopping"></i> <span class="col-12">{{ __("Basket") }}</span>
                        </button>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</template>
