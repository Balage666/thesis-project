<script setup>

import { ref, reactive } from 'vue';
import { Link, Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { useForm, router } from '@inertiajs/vue3';

import BodyLayout from '*/js/Pages/Layouts/BodyLayout.vue';
import CreatePhoneNumber from '*vue-components/Input/CreatePhoneNumber.vue'
import CreateAddress from '*vue-components/Input/CreateAddress.vue';

import ListPhoneNumbers from '*vue-components/DataDisplay/PhoneNumber/ListPhoneNumbers.vue';
import ListAddresses from '*vue-components/DataDisplay/Address/ListAddresses.vue';
import Accordion from '*vue-components/DataDisplay/Accordion.vue';

import editUserModeObj from '*js-shared/edit-user-mode-obj';

const props = defineProps({
    userToShow: {
        type: Object
    }
})


const EditMode = reactive(editUserModeObj);
const PhoneNumberFormVisible = ref(false);
const AddressFormVisible = ref(false);


const toggleEditMode = () => {
    for (const key in EditMode) {
        if (Object.hasOwnProperty.call(EditMode, key)) {
            EditMode[key] = !EditMode[key]
        }
    }
}

const togglePhoneNumberFormComponent = () => {
    PhoneNumberFormVisible.value = !PhoneNumberFormVisible.value;
}

const toggleAddressFormComponent = () => {
    AddressFormVisible.value = !AddressFormVisible.value;
}

// console.log(usePage().props.value.flash);

const user = ref(props.userToShow.data[0]);

const editNameForm = useForm({
    name: user.value.name
})

const editEmailForm = useForm({
    email: user.value.email
})

// console.log(user.value);

const sendModifiedEmailData = () => {

    router.post(route('user-email-edit', { user: user.value }), editEmailForm);

}

const sendModifiedNameData = () => {
    router.post(route('user-name-edit', { user: user.value }), editNameForm);
}

const sendEmittedPhoneNumberData = (payload) => {
    // console.log(payload);
    router.post(route('phone-number-add', { user: user.value }), payload);
}

</script>

<style scoped>

@import url(*/css/edit-user-mode.css);

</style>

<template>

    <Head>
        <title>{{ __(':name\'s details', user) }}</title>
    </Head>

    <div>

        <div class="container-fluid bg-info-subtle border-0 rounded-5 px-4 py-5 my-3">
            <div class="row">

                <div class="alert alert-success" v-if="$page.props.flash.message">{{ __($page.props.flash.message) }}</div>
                <div class="alert alert-danger" v-if="$page.props.errors" v-for="error in $page.props.errors">{{ __(error) }}</div>
                <!--DONE: Implement edit mode-->
                <div class="col-12 col-lg-12">
                    <Accordion title="User Details">
                        <div class="border-0 rounded-5 p-5">
                            <div class="row">

                                <div class="col-lg-4 col-12 mb-2 mb-lg-0">

                                    <div class="card border-0 rounded-5">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <div class="container-img">
                                                    <img :src="user.profile_picture" :alt="user.name" class="rounded-circle" width="150">
                                                    <button class="btn btn-lg btn-primary" v-if="EditMode.changeProfilePictureButtonVisible">Change Picture</button>
                                                </div>
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
                                                    <h6 class="my-0 fw-bold text-center text-lg-start text-md-start text-sm-start">Full Name</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 class="my-0 text-secondary text-center text-lg-start text-md-start text-sm-start" v-if="!EditMode.editNameFormVisible">{{ user.name }}</h6>
                                                    <form v-if="EditMode.editNameFormVisible" @submit.prevent="sendModifiedNameData">
                                                        <input class="form-control-sm border-0 rounded-end-0" type="text" name="name" id="name" v-model="editNameForm.name" required>
                                                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                                                    </form>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h6 class="my-0 fw-bold text-center text-lg-start text-md-start text-sm-start">Email</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 class="text-secondary text-center text-lg-start text-md-start text-sm-start my-0" v-if="!EditMode.editEmailFormVisible">{{ user.email }}</h6>
                                                    <form v-if="EditMode.editEmailFormVisible" @submit.prevent="sendModifiedEmailData">
                                                        <input class="form-control-sm border-0 rounded-end-0" type="email" name="email" id="email" v-model="editEmailForm.email" required>
                                                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                                                    </form>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h6 class="my-0 fw-bold text-center text-lg-start text-md-start text-sm-start">Password</h6>
                                                </div>
                                                <div class="col-sm-6 text-center text-lg-start text-md-start text-sm-start">
                                                    <h6 class="my-0 text-secondary" v-if="!EditMode.resetPasswordButtonVisible">************************</h6>
                                                    <Link :href="route('user-reset-password', { user: user })" method="post"  class="text-secondary my-0 " v-if="EditMode.resetPasswordButtonVisible">{{__('Reset :name\'s password', user)}}</Link>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-12 d-grid gap-2 gap-lg-0 d-lg-flex d-md-flex align-items-md-center align-items-lg-center justify-content-md-center justify-content-lg-between">
                                                    <Link :href="route('user-edit', { user: user })" class="btn btn-lg btn-info" as="button" type="button">{{ __("Legacy Editor") }}</Link>
                                                    <button @click="toggleEditMode" class="btn btn-lg btn-info">{{ __("Edit Mode") }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </Accordion>
                </div>

            </div>


            <div class="row mt-3">

                <!-- TODO: List and create Addresses -->
                <div class="col-12 col-lg-6">
                    <!-- <div class="accordion" id="accordionAddresses">

                        <div class="accordion-item authFormCardBackground bg-gradient">
                            <h2 class="accordion-header" id="headingAddresses">
                                <button class="accordion-button py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddresses" aria-expanded="true" aria-controls="collapseAddresses">
                                    <h1 class="text-black">Addresses</h1>
                                </button>
                            </h2>
                            <div id="collapseAddresses" class="accordion-collapse collapse show" aria-labelledby="headingAddresses" data-bs-parent="#accordionAddresses">
                                <div class="accordion-body">

                                </div>
                            </div>
                        </div>

                    </div> -->

                    <Accordion title="Addresses">
                        <div class="form-outline mb-4">
                            <div class="text-end">
                                <button class="btn" :class="[ AddressFormVisible ? 'btn-secondary' : 'btn-info' ]" @click="toggleAddressFormComponent"><i class="fa-solid" :class="[ AddressFormVisible ? 'fa-x' : 'fa-plus' ]"></i> {{ AddressFormVisible ? 'Cancel' : 'New address'}} </button>
                            </div>
                            <CreateAddress :visible="AddressFormVisible" :user="user" />
                        </div>
                        <!-- <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow. -->
                        <ListAddresses/>
                    </Accordion>
                </div>


                <!-- TODO: List Phones -->
                <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                    <!-- <div class="accordion" id="accordionPhones">

                        <div class="accordion-item authFormCardBackground bg-gradient">
                            <h2 class="accordion-header" id="headingPhones">
                                <button class="accordion-button py-3 px-5 bg-info bg-gradient" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePhones" aria-expanded="true" aria-controls="collapsePhones">
                                    <h1 class="text-black">Phones</h1>
                                </button>
                            </h2>
                            <div id="collapsePhones" class="accordion-collapse collapse show" aria-labelledby="headingPhones" data-bs-parent="#accordionPhones">
                                <div class="accordion-body">
                                    <div class="form-outline mb-4">
                                        <div class="text-end">
                                            <button class="btn" :class="[ PhoneNumberFormVisible ? 'btn-secondary' : 'btn-info' ]" @click="togglePhoneNumberFormComponent"><i class="fa-solid" :class="[ PhoneNumberFormVisible ? 'fa-x' : 'fa-plus' ]"></i> {{ PhoneNumberFormVisible ? 'Cancel' : 'New phone number' }} </button>
                                        </div>
                                        <CreatePhoneNumber :visible="PhoneNumberFormVisible" :user="user" @submitted="sendEmittedPhoneNumberData"/>
                                    </div>
                                    <ListPhoneNumbers :list="user.phone_numbers"/>
                                </div>
                            </div>
                        </div>

                    </div> -->

                    <Accordion title="Phones">
                        <div class="form-outline mb-4">
                            <div class="text-end">
                                <button class="btn" :class="[ PhoneNumberFormVisible ? 'btn-secondary' : 'btn-info' ]" @click="togglePhoneNumberFormComponent"><i class="fa-solid" :class="[ PhoneNumberFormVisible ? 'fa-x' : 'fa-plus' ]"></i> {{ PhoneNumberFormVisible ? 'Cancel' : 'New phone number' }} </button>
                            </div>
                            <CreatePhoneNumber :visible="PhoneNumberFormVisible" :user="user" @submitted="sendEmittedPhoneNumberData"/>
                        </div>
                        <ListPhoneNumbers :list="user.phone_numbers"/>
                    </Accordion>
                </div>

            </div>

            <!-- FIXED: Arrow button renders active when the accordion is closed -->
            <div class="row mt-3">

                <div class="col-12 col-lg-6">

                    <Accordion title="Favorites" :startsCollapsed="true">
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
                    </Accordion>

                </div>

                <div class="col-12 col-lg-6">

                    <!-- FIXED: Arrow button renders active when the accordion is closed -->
                    <Accordion title="Orders" :startsCollapsed="true">
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
                    </Accordion>
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-12">

                    <!-- FIXED: Arrow button renders active when the accordion is closed -->
                    <!-- TODO: List User's products -->
                    <!-- <div class="accordion" id="accordionCreatedProducts">

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

                    </div> -->

                    <Accordion title="Created Products">
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
                    </Accordion>

                </div>

            </div>

        </div>
        <!-- <BodyLayout>
        </BodyLayout> -->

    </div>


</template>
