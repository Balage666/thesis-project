<script setup>

import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue';

const pageProps = ref(usePage().props.value);

const currentUser = ref(pageProps.value.active_session.user);
const permissions = ref(pageProps.value.permissions)
const guest_cart = ref(pageProps.value.guest_cart);


const removeFromFavorites = (user, product) => {

    router.post(route('remove-from-favorites', { user: user, product: product }))

}

const removeFromBasket = (product) => {

    // console.log('clicked');
    router.post(route('remove-from-basket', { product: product }));

}

</script>


<template>
    <nav class="navbar navbar-expand-lg banner-bg-color">
        <div class="container-fluid bg-light rounded-5 mx-3 p-3">
            <Link class="navbar-brand ms-5 me-auto py-2" :href="route('storefront')"> <i class="fa-solid fa-store"></i> {{ __("Storefront") }}</Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa-solid fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto me-5 mb-2 mb-lg-0 py-2">

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


                    <li class="nav-item m-auto dropdown-center" v-if="permissions.authenticated">
                        <button class="nav-link row dropdown-center" role="button" data-bs-display="static" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                            <i class="fa-solid fa-heart"></i>
                            <span class="col-12">
                                {{ __("Favorites") }}
                                <span data-cy="favorite-counter" v-if="currentUser?.favorites.length > 0" class="badge text-bg-danger">{{ currentUser?.favorites.length }}</span>
                            </span>
                        </button>
                        <ul class="dropdown-menu bg-white p-3">
                            <li v-if="currentUser?.favorites.length == 0">
                                <span class="dropdown-header">{{ __('Favorites are empty!') }}</span>
                            </li>
                            <span v-else v-for="favorite in currentUser.favorites" >
                                <li class="dropdown-item text-center">
                                    <div class="row d-lg-flex">
                                        <div class="col-2 col-lg-12 mt-1">
                                            <img :src="favorite.product.pictures[0]?.product_picture" width="20px" height="20px" :alt="favorite.product.name">
                                        </div>
                                        <div class="col-8 col-lg-12 mt-1">
                                            <span>{{ favorite.product.name }}</span>
                                        </div>
                                        <div class="col-2 col-lg-12">
                                            <button type="button" @click="removeFromFavorites(currentUser, favorite.product)" class="btn btn-link text-danger text-nowrap" role="button">
                                                <i class="fa-solid fa-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            </span>
                        </ul>

                    </li>

                    <li class="nav-item m-auto dropdown-center">
                        <button class="nav-link row dropdown-center" role="button" data-bs-display="static" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                            <i class="fa-solid fa-basket-shopping"></i>
                            <span class="col-12">
                                {{ __("Basket") }}
                                <span v-if="permissions.authenticated && currentUser.cart?.cart_items.reduce((acc, ci) => acc + ci.amount, 0) > 0" class="badge text-bg-danger">{{ currentUser.cart?.cart_items.reduce((acc, ci) => acc + ci.amount, 0) }}</span>
                                <span v-if="!permissions.authenticated && guest_cart?.cart_items.reduce((acc, ci) => acc + ci.amount, 0) > 0" class="badge text-bg-danger">{{ guest_cart?.cart_items.reduce((acc, ci) => acc + ci.amount, 0) }}</span>
                            </span>
                        </button>

                        <!--Guest User-->
                        <ul class="dropdown-menu bg-white p-3" v-if="!permissions.authenticated">
                            <li v-if="guest_cart?.cart_items.length == 0">
                                <span class="dropdown-header">{{ __('Basket is empty :(') }}</span>
                            </li>
                            <span v-else v-for="cart_item in guest_cart?.cart_items">
                                <li class="dropdown-item text-center">
                                    <div class="row d-lg-flex">
                                        <div class="col-2 col-lg-12 mt-2">
                                            <img :src="cart_item.product_item.pictures[0]?.product_picture" width="20px" height="20px" :alt="cart_item.product_item.name">
                                        </div>
                                        <div class="col-8 col-lg-12 mt-2">
                                            <span>{{ cart_item.product_item.name }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <span>{{ `€ ${cart_item.price}` }}</span>
                                        </div>
                                        <div class="col-12">
                                            <span>{{ `(${cart_item.product_item.price} * ${cart_item.amount})` }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown-item text-center">
                                    <button @click="removeFromBasket(cart_item.product_item)" class="btn btn-link text-danger text-nowrap" role="button">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                </li>

                                <li><hr class="dropdown-divider"></li>
                            </span>
                            <li class="dropdown-item text-center">
                                <Link :href="route('basket-list')" class="btn btn-link text-secondary" as="button" type="button"> <i class="fa-solid fa-bag-shopping"></i> {{ __('View Basket') }}</Link>
                            </li>
                        </ul>

                        <!--Authenticated User-->
                        <ul class="dropdown-menu bg-white p-3" v-if="permissions.authenticated">
                            <li v-if="currentUser.cart?.cart_items.length == 0">
                                <span class="dropdown-header">{{ __('Basket is empty :(') }}</span>
                            </li>
                            <span v-else v-for="cart_item in currentUser.cart?.cart_items">
                                <li class="dropdown-item text-center">
                                    <div class="row d-lg-flex">
                                        <div class="col-2 col-lg-12 mt-2">
                                            <img :src="cart_item.product_item.pictures[0]?.product_picture" width="20px" height="20px" :alt="cart_item.product_item.name">
                                        </div>
                                        <div class="col-8 col-lg-12 mt-2">
                                            <span>{{ cart_item.product_item.name }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <span>{{ `€ ${cart_item.price}` }}</span>
                                        </div>
                                        <div class="col-12">
                                            <span>{{ `(€ ${cart_item.product_item.price} * ${cart_item.amount})` }}</span>
                                        </div>
                                    </div>
                                </li>

                                <li class="text-center">
                                    <button @click="removeFromBasket(cart_item.product_item)" class="btn btn-link text-danger text-nowrap" role="button">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            </span>
                            <li class="dropdown-item text-center">
                                <Link :href="route('basket-list')" class="btn btn-link text-secondary" as="button" type="button"> <i class="fa-solid fa-bag-shopping"></i> {{ __('View Basket') }}</Link>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</template>
