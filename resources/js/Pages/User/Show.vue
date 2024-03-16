<script setup>

import { ref, reactive, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { Modal } from 'bootstrap';


import BodyLayout from '*/js/Pages/Layouts/BodyLayout.vue';
import CreatePhoneNumber from '*vue-components/Input/CreatePhoneNumber.vue'
import CreateAddress from '*vue-components/Input/CreateAddress.vue';
import FileUploadDialog from '*vue-components/Input/FileUploadDialog.vue';

import ListProduct from '*vue-components/DataDisplay/Product/ListProduct.vue';
import ListPhoneNumbers from '*vue-components/DataDisplay/PhoneNumber/ListPhoneNumbers.vue';
import ListAddresses from '*vue-components/DataDisplay/Address/ListAddresses.vue';
import UserCard from '*vue-components/DataDisplay/UserDetail/UserCard.vue';
import UserDetailsCard from '*vue-components/DataDisplay/UserDetail/UserDetailsCard.vue';
import Accordion from '*vue-components/DataDisplay/Accordion.vue';

import editUserModeObj from '*js-shared/edit-user-mode-obj';

const props = defineProps({
    userToShow: {
        type: Object
    }
})

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);
const currentUser = ref(pageProps.value.active_session.user);

const changeProfilePictureModal = ref(null);

const EditMode = reactive(editUserModeObj);
const PhoneNumberFormVisible = ref(false);
const AddressFormVisible = ref(false);

onMounted(() => {
    changeProfilePictureModal.value = new Modal(document.getElementById('fileUpload'));
});


const toggleEditMode = (payload) => {

    console.log(payload)

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

const showDialog = () => {

    changeProfilePictureModal.value.show();
}

const closeDialog = () => {

    changeProfilePictureModal.value.hide();

}

const user = ref(props.userToShow.data[0]);
const targetUserRolesRef = ref(user.value.roles);
const targetUserRoles = ref(targetUserRolesRef.value.map(r => r.name));

console.log(user.value);
console.log(targetUserRoles.value);

const sendEmittedModifiedEmailData = (payload) => {

    // console.log(payload);
    router.post(route('user-email-edit', { user: user.value }), payload);

}

const sendEmittedModifedNameData = (payload) => {

    // console.log(payload);
    router.post(route('user-name-edit', { user: user.value }), payload);
}

const sendEmittedPhoneNumberData = (payload) => {

    // console.log(payload);
    router.post(route('phone-number-add', { user: user.value }), payload);
}

const sendEmittedAddressData = (payload) => {
    console.log(payload);
    router.post(route('address-create', { user: user.value }), payload);
}

const sendEmittedChangedPhoneNumberData = (payload) => {
    // console.log(payload)
    const [form, phone] = payload;

    console.log(phone)
    console.log(form)

    router.post(route('phone-number-update', { phone: phone }), form)
}

const sendEmittedChangedProfilePictureData = (payload) => {

    console.log(payload);

    router.post(route('user-change-profile-picture', { user: user.value }), payload);
}

</script>


<template>

    <!-- TODO: Make a separate accordion for user roles -->

    <Head>
        <title>{{ __(':name\'s details', user) }}</title>
    </Head>

    <!-- <pre>{{ permissions }}</pre> -->

    <BodyLayout>
        <div>

            <FileUploadDialog
                :id="'fileUpload'"
                @onModalClose="closeDialog"
                @pictureModified="sendEmittedChangedProfilePictureData"
                :user="user"
            />

            <div class="container-fluid bg-info-subtle border-0 rounded-5 px-4 py-5 my-3">
                <div class="row">

                    <!-- <div class="alert alert-success" v-if="$page.props.flash.message">{{ __($page.props.flash.message) }}</div>
                    <div class="alert alert-danger" v-if="$page.props.errors" v-for="error in $page.props.errors">{{ __(error) }}</div> -->
                    <!--DONE: Implement edit mode-->
                    <div class="col-12 col-lg-12">

                        <Accordion title="User Details">
                            <div class="border-0 rounded-5 p-5">
                                <div class="row">

                                    <div class="col-lg-4 col-12 mb-lg-0">

                                        <UserCard
                                            :user="user"
                                            :profilePictureEditModeVisible="EditMode.changeProfilePictureButtonVisible"
                                            @onPictureButtonClick="showDialog"
                                        />

                                    </div>

                                    <div class="col-lg-8 col-12">

                                        <UserDetailsCard
                                            :user="user"
                                            :nameEditModeVisible="EditMode.editNameFormVisible"
                                            :emailEditModeVisible="EditMode.editEmailFormVisible"
                                            :resetPasswordButtonVisible="EditMode.resetPasswordButtonVisible"
                                            @editModeToggled="toggleEditMode"
                                            @nameModified="sendEmittedModifedNameData"
                                            @emailModified="sendEmittedModifiedEmailData"
                                        />

                                    </div>

                                </div>
                            </div>
                        </Accordion>

                    </div>

                </div>

                <!-- !permissions.has_only_customer_role && ( ( permissions.has_moderator_role_at_most && !targetUserRoles.includes('Moderator') ) || permissions.has_admin_role) || permissions.has_moderator_role && currentUser.id == props.user.id -->
                <div class="row mt-3" v-show="(!permissions.has_only_customer_role && !permissions.has_only_customer_role_and_seller_role && ( permissions.has_moderator_role_at_most && !targetUserRoles.includes('Moderator') ) ) || permissions.has_admin_role || currentUser.id == user.id">

                    <div class="col-12 col-lg-6">

                        <Accordion title="Addresses">
                            <div class="form-outline mb-4">
                                <div class="text-end">
                                    <button class="btn" :class="[ AddressFormVisible ? 'btn-secondary' : 'btn-info' ]" @click="toggleAddressFormComponent"><i class="fa-solid" :class="[ AddressFormVisible ? 'fa-x' : 'fa-plus' ]"></i> {{ AddressFormVisible ? 'Cancel' : 'New address'}} </button>
                                </div>
                                <CreateAddress :visible="AddressFormVisible" @submitted="sendEmittedAddressData" />
                            </div>
                            <ListAddresses :list="user.addresses"/>
                        </Accordion>

                    </div>

                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">

                        <Accordion title="Phones">
                            <div class="form-outline mb-4">
                                <div class="text-end">
                                    <button class="btn" :class="[ PhoneNumberFormVisible ? 'btn-secondary' : 'btn-info' ]" @click="togglePhoneNumberFormComponent"><i class="fa-solid" :class="[ PhoneNumberFormVisible ? 'fa-x' : 'fa-plus' ]"></i> {{ PhoneNumberFormVisible ? 'Cancel' : 'New phone number' }} </button>
                                </div>
                                <CreatePhoneNumber :visible="PhoneNumberFormVisible" @submitted="sendEmittedPhoneNumberData"/>
                            </div>
                            <ListPhoneNumbers :list="user.phone_numbers" @listChanged="sendEmittedChangedPhoneNumberData"/>
                        </Accordion>

                    </div>

                </div>

                <div class="row mt-3" v-show="(!permissions.has_only_customer_role && permissions.has_admin_role) || currentUser.id == user.id">

                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">

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

                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">

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

                        <Accordion title="Created Products">

                            <ListProduct :products="user.products"/>

                        </Accordion>

                    </div>

                </div>

            </div>

            <!-- <BodyLayout>
            </BodyLayout> -->

        </div>
    </BodyLayout>


</template>
