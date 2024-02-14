<script setup>

import Pagination from '*/js/Components/DataDisplay/Pagination.vue';
import { Link, Head } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Object
    }
});

console.table(props.users.meta);

</script>

<template>

    <Head>
        <title>{{ __("List users") }}</title>
    </Head>

    <div>
        <h1>List users</h1>


        <p>{{ props.users }}</p>

        <!--TODO: Complete the design!-->

        <div class="container p-5">
            <div class="row m-3">
                <div class="col-12">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item authFormCardBackground bg-gradient" v-for="user in props.users.data" :key="user.id">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + user.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    <div> <img :src="user.profile_picture" class="border-0 rounded-5" width="45px" height="45px"> <span>{{ user.name }}</span> </div>
                                </button>
                            </h2>
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
                                                        <Link href="#" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">Legacy User Editor</Link>
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
