<script setup>

import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <div class="p-3 banner-bg-color">

        <div class="p-3 pb-0 rounded-5 contact-info-bg-color">

            <section>

                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">
                            Company name
                        </h6>
                        <p>
                            Here you can use rows and columns to organize your footer
                            content. Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit.
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">Products</h6>
                        <p>
                            <a class="text-white">MDBootstrap</a>
                        </p>
                        <p>
                            <a class="text-white">MDWordPress</a>
                        </p>
                        <p>
                            <a class="text-white">BrandFlow</a>
                        </p>
                        <p>
                            <a class="text-white">Bootstrap Angular</a>
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">
                            Useful links
                        </h6>
                        <p>
                            <a class="text-white">Your Account</a>
                        </p>
                        <p>
                            <a class="text-white">Become an Affiliate</a>
                        </p>
                        <p>
                            <a class="text-white">Shipping Rates</a>
                        </p>
                        <p>
                            <a class="text-white">Help</a>
                        </p>
                    </div>

                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 fw-bold">Contact</h6>
                        <p><i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
                        <p><i class="fas fa-envelope mr-3"></i> info@gmail.com</p>
                        <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
                    </div>
                </div>

            </section>

            <hr class="my-3">

            <section>

                <p class="d-flex justify-content-center align-items-center">
                    <span class="me-3 fw-bold">Register for free!</span>
                    <Link :href="route('sign-up')" type="button" class="fw-bold btn btn-secondary rounded">
                        Sign up
                    </Link>
                </p>

            </section>

            <hr class="my-3">

            <section class="p-3 pt-0">
                <div class="row d-flex align-items-center">

                    <div class="col-12 col-lg-6 text-center">
                        <div class="p-3">
                            <span class="fw-bold">Technologies used during development:</span>
                        </div>
                    </div>

                    <!--TODO: Render the links dynamically -->
                    <div class="col-12 col-lg-6 ml-lg-0 text-center">
                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-laravel"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-vuejs"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-light"
                            role="button"
                        > <i class="fab fa-font-awesome"></i> </a>


                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-bootstrap"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-sass"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-css3-alt"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-js"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-php"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-light"
                            role="button"
                        > <i class="devicon-vitejs-plain"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-light"
                            role="button"
                        > <i class="devicon-mysql-original"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-light"
                            role="button"
                        > <i class="devicon-apache-plain"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-light"
                            role="button"
                        > <i class="fab fa-ubuntu"></i> </a>


                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-github"></i> </a>

                        <a
                            class="btn btn-secondary m-1 text-white"
                            role="button"
                        > <i class="fab fa-trello"></i> </a>


                    </div>
                </div>

            </section>

        </div>

    </div>
</template>
