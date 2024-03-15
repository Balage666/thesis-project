<script setup>

import { Link, Head, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue'
import Pagination from '*/js/Components/DataDisplay/Pagination.vue';

const props = defineProps({
    users: {
        type: Object
    }
});

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);

// console.log(permissions.value);

const sendUserDeleteRequest = (user) => {

    console.log(user);
    router.post(route('user-delete', { user: user }));

}

</script>

<template>

    <Head>
        <title>{{ __("List users") }}</title>
    </Head>

    <BodyLayout>
        <div>

            <!-- <pre>{{ props.users }}</pre> -->

            <!--TODO: Make it scrollable-->

            <div class="container-fluid p-5 bg-info-subtle border-0">

                <div class="row m-3 d-none d-md-flex">

                    <div class="col-lg-6 col-md-6 col-12 mt-3">

                        <form class="d-flex align-content-center justify-content-center" role="search">
                            <input class="form-control border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
                            <button class="btn btn-primary border-2 rounded-start-0" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        </form>

                    </div>

                    <!-- <div class="col-lg-3 col-md-12 col-12 mt-3"></div>

                    <div class="col-lg-12 col-md-12 col-12 mt-3">
                        <Pagination :pagination="props.users.meta"/>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12 mt-3"></div> -->

                </div>

                <!-- <div class="navbar row m-3 d-flex d-md-none">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav px-3 me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                            <li class="nav-item">
                                <Pagination :pagination="props.users.meta"/>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" aria-disabled="true">Link</a>
                            </li>
                            <li class="nav-item">
                                <form class="d-flex align-content-center justify-content-center" role="search">
                                    <input class="form-control form-control-lg border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
                                    <button class="btn btn-primary border-2 rounded-start-0" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                                </form>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>


                </div> -->

                <div class="row m-3 overflow-y-scroll" style="height: 650px;">
                    <div class="col-12">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item authFormCardBackground bg-gradient"  v-for="user in props.users.data" :key="user.id">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + user.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="col-3 me-2">
                                            <img :src="user.profile_picture" class="border-0 rounded-5" width="45px" height="45px">
                                        </div>
                                        <div class="col-3 mt-1">
                                            <span class="fw-bold">{{ user.name }}</span>
                                        </div>
                                    </button>
                                </h2>

                                <div :id="'open' + user.id" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="container-fluid accordion-body">

                                        <div class="row">
                                            <div class="col-md-12 p-md-5 col-lg-8">

                                                <div class="card border-0 rounded-5">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-column align-items-center text-center">
                                                            <img :src="user.profile_picture" :alt="user.name" class="rounded-circle" width="150">
                                                            <div class="mt-1">
                                                                <h4>{{ user.name }}</h4>
                                                                <!-- <p class="text-secondary my-1" v-for="role in user.roles">{{ __(role.name) }}</p> -->
                                                                <div class="d-grid gap-2">
                                                                    <Link :href="route('user-show', { user: user })" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">View User</Link>
                                                                    <Link :href="route('user-edit', { user: user })" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">Legacy User Editor</Link>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-12 p-md-5 col-lg-4">

                                                <div class="my-3 my-lg-0">
                                                    <h2 class="text-center">{{ __(":first_name\'s roles: ", user) }}</h2>
                                                    <ul class="list-group border-0 rounded-5">
                                                        <li class="list-group-item p-3 text-center" v-for="role in user.roles">{{ __(role.name) }}</li>
                                                    </ul>
                                                </div>

                                            </div>

                                            <div class="col-12">

                                                <div class="my-3 my-lg-0 text-center">
                                                    <button @click="sendUserDeleteRequest(user)" class="btn btn-lg btn-danger" type="button">Delete</button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row m-3">
                    <div class="col-12">
                        <Pagination :pagination="props.users.meta"/>
                    </div>
                </div> -->
            </div>
        </div>
    </BodyLayout>
</template>
