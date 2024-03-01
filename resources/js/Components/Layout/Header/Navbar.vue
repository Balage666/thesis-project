<script setup>

import { Link } from '@inertiajs/vue3';

</script>


<template>
    <nav class="navbar navbar-expand-lg banner-bg-color">
        <div class="container-fluid bg-light rounded-5 mx-3 p-3">
            <a class="navbar-brand py-2" href="#">{{ __("Storefront") }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="w-75 py-2 ms-lg-auto me-lg-auto ms-sm-auto me-sm-auto">
                    <form class="d-flex" role="search">
                        <input class="form-control form-control-lg form-control-sm rounded-start-5" type="search" :placeholder="__('Search')" aria-label="Search">
                        <button class="btn btn-primary rounded-end-5" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                    </form>
                </div>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 py-2">

                    <div>
                        <li class="nav-item dropdown" v-if="!$page.props.permissions.authenticated">
                            <button class="nav-link" href="#" role="button" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-circle-user"></i> {{ __("Account") }}
                            </button>
                            <ul class="dropdown-menu bg-white">
                                <li><Link :href="route('log-in')" method="get" as="button" class="dropdown-item text-center"><i class="fa-solid fa-right-to-bracket"></i> {{ __("Login") }}</Link></li>
                                <li><Link :href="route('sign-up')" method="get" as="button" class="dropdown-item text-center"><i class="fa-solid fa-plus"></i> {{ __("SignUp") }}</Link></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown" v-else>
                            <button class="nav-link" role="button" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false"> <i class="col-12 fa-solid fa-user"></i> <span class="col-12">{{ $page.props.active_session.user.name }}</span> </button>
                            <ul class="dropdown-menu bg-white">
                                <li><Link :href="route('log-out')" as="button" method="get" class="dropdown-item text-center"><i class="fa-solid fa-door-open"></i> {{ __("LogOut") }}</Link></li>
                            </ul>

                        </li>
                    </div>


                    <li class="nav-item">
                        <button class="nav-link" href="#"> <i class="fa-solid fa-heart"></i> {{ __("Favorites") }}</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" href="#"> <i class="fa-solid fa-basket-shopping"></i> {{ __("Basket") }}</button>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</template>
