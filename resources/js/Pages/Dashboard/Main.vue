<script setup>

import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';


import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const permissions = ref(usePage().props.value.permissions);

console.log(permissions.value);

</script>

<template>

    <Head>
        <title>{{ __('Dashboard - Main') }}</title>
    </Head>

    <BodyLayout>

        <div class="container-fluid p-5 bg-info-subtle">

            <div class="p-5 row row-cols-1 row-cols-lg-4 text-center d-grid d-lg-flex d-md-flex g-3 g-lg-0 g-md-2">
                <div class="col" v-if="permissions.has_moderator_role || permissions.has_admin_role">
                    <h2 class="mt-3 mb-3">Create user</h2>
                    <Link :href="route('user-create')" class="btn btn-lg btn-info" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-user-plus fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <div class="col" v-if="permissions.has_moderator_role || permissions.has_admin_role">
                    <h2 class="mt-3 mb-3">User list</h2>
                    <Link :href="route('user-list')" class="btn btn-lg btn-info" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-users fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <div class="col" v-if="permissions.has_seller_role || permissions.has_admin_role">
                    <h2 class="mt-3 mb-3">Create product</h2>
                    <Link :href="route('product-create')" class="btn btn-lg btn-secondary" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-circle-plus fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <div class="col" v-if="permissions.has_seller_role || permissions.has_admin_role">
                    <h2 class="mt-3 mb-3">Product list</h2>
                    <Link :href="route('product-list')" class="btn btn-lg btn-secondary" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-list fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <!-- <div class="col">
                    <h2 class="mt-3 mb-3">Create order</h2>
                    <Link :href="route('order-create')" class="btn btn-lg btn-warning" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-box-open fa-2xl"></i>
                        </div>
                    </Link>
                </div> -->

                <div class="col">
                    <h2 class="mt-3 mb-3">Order list</h2>
                    <Link :href="route('all-orders')" class="btn btn-lg btn-warning" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-boxes-stacked fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <div class="col" v-if="permissions.has_seller_role || permissions.has_admin_role">
                    <h2 class="mt-3 mb-3">Category list</h2>
                    <Link :href="route('category-list')" class="btn btn-lg btn-success" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-layer-group fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <div class="col" v-if="permissions.has_admin_role">
                    <h2 class="mt-3 mb-3">Charts</h2>
                    <Link class="btn btn-lg btn-danger" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-chart-simple fa-2xl"></i>
                        </div>
                    </Link>
                </div>

                <div class="col">
                    <h2 class="mt-3 mb-3">Storefront</h2>
                    <Link class="btn btn-lg btn-light" type="button" as="button">
                        <div class="p-5">
                            <i class="fa-solid fa-store fa-2xl"></i>
                        </div>
                    </Link>
                </div>

            </div>


        </div>
    </BodyLayout>
</template>


