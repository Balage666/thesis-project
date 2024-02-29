<script setup>

import UserCard from '*vue-components/DataDisplay/UserDetail/UserCard.vue';
import UserDetailsCard from '*vue-components/DataDisplay/UserDetail/UserDetailsCard.vue'

import editProfileModeObj from '*js-shared/edit-profile-mode-obj.js'
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputMask from 'primevue/inputmask'

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const uservalues = props.user.data[0];


const EditMode = reactive(editProfileModeObj);

const editNameForm = useForm({
    name: uservalues.name
});

const editEmailForm = useForm({
    email: uservalues.email
});

const editPhoneNumberForm = useForm({
    number: uservalues.phone_numbers[0]?.formatted_number,
    mask: uservalues.phone_numbers[0]?.mask
});

const toggelEditMode = () => {
    for (const key in EditMode) {
        if (Object.hasOwnProperty.call(EditMode, key)) {
            EditMode[key] = !EditMode[key]
        }
    }
}

</script>
<template>

    <pre>{{ uservalues }}</pre>

    <Head>
        <title>Profile page</title>
    </Head>

    <div class="container">
        <div class="main-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <!-- <UserCard :user="uservalues"/> -->

                    <div class="card rounded-3">
                        <div class="card-body">

                            <div class="d-flex flex-column align-items-center text-center">
                                <img :src="uservalues.profile_picture" :alt="uservalues.name" :title="uservalues.name" class="rounded-circle" width="150px">
                                <div class="mt-3">
                                    <h4>{{ uservalues.name }}</h4>
                                    <p>Created at: {{ uservalues.created_at_human_readable }}</p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <!-- <UserDetailsCard :user="uservalues"/> -->

                    <div class="card py-1 rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span v-if="!EditMode.editNameFormVisible">{{ uservalues.name }}</span>
                                    <form v-if="EditMode.editNameFormVisible">
                                        <input class="form-control-sm border-0 rounded-end-0" type="text" name="name" id="name" v-model="editNameForm.name" required>
                                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                                    </form>

                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span v-if="!EditMode.editEmailFormVisible">{{ uservalues.email }}</span>
                                    <form v-if="EditMode.editEmailFormVisible">
                                        <input class="form-control-sm border-0 rounded-end-0" type="email" name="email" id="email" v-model="editEmailForm.email" required>
                                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                                    </form>

                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Mobile</h6>
                                </div>
                                <!--FIXME: Cannot be forced to disappear when toggle button pressed-->
                                <div class="col-sm-9 text-secondary">
                                    <span v-if="!EditMode.editPhoneNumberFormVisible">{{ uservalues.phone_numbers[0]?.number ?? '-' }}</span>
                                    <form v-if="EditMode.editPhoneNumberFormVisible ">
                                        <InputMask
                                            class="form-control-sm border-0 rounded-end-0 formInputFieldBackground"
                                            id="phone_mask"
                                            name="phone_mask"
                                        />
                                        <input class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" type="submit" value="Modify">
                                    </form>
                                    <button v-if="EditMode.addPhoneNumberButtonVisible" type="button"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ uservalues.addresses[0]?.address_text ?? '-' }}
                                </div>
                            </div>

                            <hr>

                            <div class="text-center">
                                <button @click="toggelEditMode" class="btn btn-lg btn-info">{{ __("Edit Mode") }}</button>
                            </div>

                            <!-- <div class="row">
                                <div class="col-12 text-center">
                                </div>
                            </div> -->
                        </div>
                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-12">

                    <div class="card py-1">
                        <div class="card-body">
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Inventore tempore est id quo aspernatur iusto modi, veritatis qui excepturi quisquam amet repellendus rem voluptatum tenetur. Deleniti ipsa nemo modi vitae.</p>

                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id voluptas dignissimos nostrum autem quidem nulla, quisquam odit earum quam optio ullam soluta dicta fuga aut sapiente sequi inventore ea dolorem.</p>

                            <p>border nose story somebody many happen death replied fresh gravity happy industry except respect lesson salt affect mouse surrounded uncle had meet gain shop</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</template>

<style scoped>

body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}

</style>
