<script setup>

import { ref } from 'vue';
import { Link, Head } from '@inertiajs/vue3';

import BodyLayout from '../Layouts/BodyLayout.vue'

const props = defineProps({
    userToShow: {
        type: Object
    }
})

const user = ref(props.userToShow.data[0]);

</script>

<template>

    <Head>
        <title>{{ __(':name\'s details', user) }}</title>
    </Head>

    <div>

        <BodyLayout>
            <div class="container-fluid bg-info-subtle border-0 rounded-5 px-4 py-5 my-3">
                <div class="row">

                    <!--TODO: Implement edit mode-->
                    <div class="col-12 col-lg-12">
                        <div class="accordion" id="accordionUserDetails">
                            <div class="accordion-item authFormCardBackground bg-gradient">
                                <h2 class="accordion-header" id="headingUserDetails">
                                    <button class="accordion-button py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUserDetails" aria-expanded="true" aria-controls="collapseUserDetails">
                                        <h1 class="text-black">User Details</h1>
                                    </button>
                                </h2>
                                <div id="collapseUserDetails" class="accordion-collapse collapse show" aria-labelledby="headingUserDetails" data-bs-parent="#accordionUserDetails">
                                    <div class="accordion-body">

                                        <div class="border-0 rounded-5 p-5">
                                            <div class="row">

                                                <div class="col-lg-4 col-12 mb-2 mb-lg-0">

                                                    <div class="card border-0 rounded-5">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-column align-items-center text-center">
                                                                <img :src="user.profile_picture" :alt="user.name" class="rounded-circle" width="150">
                                                                <div class="mt-1">
                                                                    <h4>{{ user.name }}</h4>
                                                                    <!-- TODO: Make a separate accordion for user roles -->
                                                                    <p class="text-secondary my-1" v-for="role in user.roles">{{ __(role.name) }}</p>
                                                                    <div class="d-grid d-lg-flex gap-2">
                                                                        <button class="btn btn-lg btn-primary">Follow</button>
                                                                        <button class="btn btn-lg btn-secondary">Message</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-8 col-12 py-lg-5">
                                                    <div class="card border-0 rounded-5 p-2">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <h6 class="my-0 fw-bold">Full Name</h6>
                                                                </div>
                                                                <div class="col-sm-6 text-secondary">
                                                                    <h6 class="my-0">{{ user.name }}</h6>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <h6 class="my-0 fw-bold">Email</h6>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h6 class="text-secondary my-0">{{ user.email }}</h6>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <h6 class="my-0 fw-bold">Password</h6>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h6 class="my-0 text-secondary">************************</h6>
                                                                    <!-- <a href="" class="text-secondary my-0">{{__('Reset :name\'s password', user)}}</a> -->
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="row">
                                                                <div class="col-sm-12 d-grid gap-2 gap-lg-0 d-lg-flex d-md-flex align-items-md-center align-items-lg-center justify-content-md-center justify-content-lg-between">
                                                                    <Link :href="route('user-edit', { user: user })" class="btn btn-lg btn-info" as="button" type="button">{{ __("Legacy Editor") }}</Link>
                                                                    <button class="btn btn-lg btn-info">{{ __("Edit Mode") }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row mt-3">

                    <!-- TODO: List Addresses -->
                    <div class="col-12 col-lg-6">
                        <div class="accordion" id="accordionAddresses">

                            <div class="accordion-item authFormCardBackground bg-gradient">
                                <h2 class="accordion-header" id="headingAddresses">
                                    <button class="accordion-button py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddresses" aria-expanded="true" aria-controls="collapseAddresses">
                                        <h1 class="text-black">Addresses</h1>
                                    </button>
                                </h2>
                                <div id="collapseAddresses" class="accordion-collapse collapse show" aria-labelledby="headingAddresses" data-bs-parent="#accordionAddresses">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- TODO: List Phones -->
                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                        <div class="accordion" id="accordionPhones">

                            <div class="accordion-item authFormCardBackground bg-gradient">
                                <h2 class="accordion-header" id="headingPhones">
                                    <button class="accordion-button py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePhones" aria-expanded="true" aria-controls="collapsePhones">
                                        <h1 class="text-black">Phones</h1>
                                    </button>
                                </h2>
                                <div id="collapsePhones" class="accordion-collapse collapse show" aria-labelledby="headingPhones" data-bs-parent="#accordionPhones">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- FIXED: Arrow button renders active when the accordion is closed -->
                <div class="row mt-3">

                    <div class="col-12 col-lg-6">

                        <div class="accordion" id="accordionFavorites">

                            <div class="accordion-item authFormCardBackground bg-gradient">
                                <h2 class="accordion-header" id="headingFavorites">
                                    <button class="accordion-button collapsed py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFavorites" aria-expanded="false" aria-controls="collapseFavorites">
                                        <h1 class="text-black">Favorites</h1>
                                    </button>
                                </h2>
                                <div id="collapseFavorites" class="accordion-collapse collapse" aria-labelledby="headingFavorites" data-bs-parent="#accordionFavorites">
                                    <div class="accordion-body">
                                        <p>
                                            <strong>
                                                This is the first item's accordion body.
                                            </strong>
                                            It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </p>

                                        <p>
                                            Oh, thank you, thank you. Okay now, we run some industrial strength electrical cable from the top of the clocktower down to spreading it over the street between two lamp posts. Meanwhile, we out-fitted the vehicle with this big pole and hook which runs directly into the flux-capacitor. At the calculated moment, you start off from down the street driving toward the cable execrating to eighty-eight miles per hour. According to the flyer, at !0:04 pm lightning will strike the clocktower sending one point twenty-one gigawatts into the flux-capacitor, sending you back to 1985. Alright now, watch this. You wind up the car and release it, I'll simulate the lightening. Ready, set, release. Huhh. Why not? No. Right. You know Marty, you look so familiar, do I know your mother?
                                        </p>

                                        <p>
                                            Well, she's not doing a very good job. Hey beat it, spook, this don't concern you. Hey Marty, I'm not your answering service, but you're outside pouting about the car, Jennifer Parker called you twice. About 30 years, it's a nice round number. Well gee, I don't know.
                                        </p>

                                        <p>
                                            Why that's me, look at me, I'm an old man. Oh yes sir. That was so stupid, Grandpa hit him with the car. Breakfast. What did you sleep in your clothes again last night.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-12 col-lg-6">

                        <!-- FIXED: Arrow button renders active when the accordion is closed -->
                        <div class="accordion" id="accordionOrders">

                            <div class="accordion-item authFormCardBackground bg-gradient">
                                <h2 class="accordion-header" id="headingOrders">
                                    <button class="accordion-button collapsed py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrders" aria-expanded="false" aria-controls="collapseOrders">
                                        <h1 class="text-black">Orders</h1>
                                    </button>
                                </h2>
                                <div id="collapseOrders" class="accordion-collapse collapse" aria-labelledby="headingOrders" data-bs-parent="#accordionOrders">
                                    <div class="accordion-body">
                                        <p>
                                            <strong>
                                                This is the first item's accordion body.
                                            </strong>
                                            It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </p>

                                        <p>
                                            Oh, thank you, thank you. Okay now, we run some industrial strength electrical cable from the top of the clocktower down to spreading it over the street between two lamp posts. Meanwhile, we out-fitted the vehicle with this big pole and hook which runs directly into the flux-capacitor. At the calculated moment, you start off from down the street driving toward the cable execrating to eighty-eight miles per hour. According to the flyer, at !0:04 pm lightning will strike the clocktower sending one point twenty-one gigawatts into the flux-capacitor, sending you back to 1985. Alright now, watch this. You wind up the car and release it, I'll simulate the lightening. Ready, set, release. Huhh. Why not? No. Right. You know Marty, you look so familiar, do I know your mother?
                                        </p>

                                        <p>
                                            Well, she's not doing a very good job. Hey beat it, spook, this don't concern you. Hey Marty, I'm not your answering service, but you're outside pouting about the car, Jennifer Parker called you twice. About 30 years, it's a nice round number. Well gee, I don't know.
                                        </p>

                                        <p>
                                            Why that's me, look at me, I'm an old man. Oh yes sir. That was so stupid, Grandpa hit him with the car. Breakfast. What did you sleep in your clothes again last night.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-12">

                        <!-- FIXED: Arrow button renders active when the accordion is closed -->
                        <!-- TODO: List User's products -->
                        <div class="accordion" id="accordionCreatedProducts">

                            <div class="accordion-item authFormCardBackground bg-gradient">

                                <h2 class="accordion-header" id="headingCreatedProducts">
                                    <button class="accordion-button collapsed py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreatedProducts" aria-expanded="false" aria-controls="collapseCreatedProducts">
                                        <h1 class="text-black">Created Products</h1>
                                    </button>
                                </h2>
                                <div id="collapseCreatedProducts" class="accordion-collapse collapse" aria-labelledby="headingCreatedProducts" data-bs-parent="#accordionCreatedProducts">
                                    <div class="accordion-body">
                                        <p>
                                            <strong>
                                                This is the first item's accordion body.
                                            </strong>
                                            It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                        </p>

                                        <p>
                                            Oh, thank you, thank you. Okay now, we run some industrial strength electrical cable from the top of the clocktower down to spreading it over the street between two lamp posts. Meanwhile, we out-fitted the vehicle with this big pole and hook which runs directly into the flux-capacitor. At the calculated moment, you start off from down the street driving toward the cable execrating to eighty-eight miles per hour. According to the flyer, at !0:04 pm lightning will strike the clocktower sending one point twenty-one gigawatts into the flux-capacitor, sending you back to 1985. Alright now, watch this. You wind up the car and release it, I'll simulate the lightening. Ready, set, release. Huhh. Why not? No. Right. You know Marty, you look so familiar, do I know your mother?
                                        </p>

                                        <p>
                                            Well, she's not doing a very good job. Hey beat it, spook, this don't concern you. Hey Marty, I'm not your answering service, but you're outside pouting about the car, Jennifer Parker called you twice. About 30 years, it's a nice round number. Well gee, I don't know.
                                        </p>

                                        <p>
                                            Why that's me, look at me, I'm an old man. Oh yes sir. That was so stupid, Grandpa hit him with the car. Breakfast. What did you sleep in your clothes again last night.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </BodyLayout>

    </div>


</template>
