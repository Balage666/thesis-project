<script setup>

import Pagination from '*/js/Components/DataDisplay/Pagination.vue';
import { Link, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: {
        type: Object
    }
});


</script>

<template>

    <Head>
        <title>{{ __("List users") }}</title>
    </Head>

    <div>
        <h1>List users</h1>


        <p>{{ props.users }}</p>

        <!--TODO: Complete the design!-->

        <div class="container p-5 bg-info-subtle border-0 rounded-5">

            <div class="row m-3 d-none d-md-flex">

                <div class="col-lg-3 col-md-12 col-12 mt-3">

                    <form class="d-flex align-content-center justify-content-center" role="search">
                        <input class="form-control form-control-lg border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
                        <button class="btn btn-primary border-2 rounded-start-0" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                    </form>

                </div>

                <div class="col-lg-3 col-md-12 col-12 mt-3"></div>

                <div class="col-lg-3 col-md-12 col-12 mt-3">
                    <Pagination :pagination="props.users.meta"/>
                </div>
                <div class="col-lg-3 col-md-12 col-12 mt-3"></div>

            </div>

            <div class="navbar row m-3 d-flex d-md-none">
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
                    <!-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form> -->
                </div>


            </div>

            <div class="row m-3">
                <div class="col-12">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item authFormCardBackground bg-gradient p-3"  v-for="user in props.users.data" :key="user.id" :class="{'bg-warning' : user.checked}">
                            <div class="row">
                                <!--FIXME: Shouldn't store the selected state in the backend I guess-->
                                <div class="col-12">
                                    <input type="checkbox" name="" id="" v-model="user.checked">
                                </div>
                            </div>
                            <div class="row">
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
                            </div>

                            <div :id="'open' + user.id" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="container-fluid accordion-body">

                                    <div class="row">
                                        <div class="col-md-12 p-md-5 col-lg-8">

                                            <div class="card">
                                                <div class="card-header container-fluid no-padding">
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <img :src="user.profile_picture" class="img-fluid p-3" :alt="user.name" :title="user.name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">{{ user.name }}</h5>
                                                    <p class="card-text text-center">{{ user.email }}</p>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li v-for="role in user.roles" class="list-group-item">{{ role.name }}</li>
                                                </ul>
                                                <div class="card-body">
                                                    <div class="d-grid gap-2">
                                                        <Link href="#" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">User Profile</Link>
                                                        <a :href="route('user-edit', { user: user })" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">Legacy User Editor</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-md-12 p-md-5 col-lg-4">

                                            <div class="my-3 my-lg-0">
                                                <h2 class="text-center">List</h2>
                                                <ul class="list-group ">
                                                    <li class="list-group-item">An item</li>
                                                    <li class="list-group-item">A second item</li>
                                                    <li class="list-group-item">A third item</li>
                                                    <li class="list-group-item">A fourth item</li>
                                                    <li class="list-group-item">And a fifth one</li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow. -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-12">
                    <Pagination :pagination="props.users.meta"/>
                </div>
            </div>
        </div>


        <!-- <div class="p-5 bg-warning">

            <div v-for="user in props.users.data" :key="user.id">


                #({{ user.id }}): {{ user.name }}


            </div>

            <Pagination :pagination="props.users.meta"/>

        </div> -->
    </div>
</template>
