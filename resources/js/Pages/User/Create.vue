<script setup>

import { FormKit } from '@formkit/vue';

import { useForm, router } from '@inertiajs/vue3';

import { ref } from 'vue';

import { userRoles } from '../../Shared/user-roles'

console.log(userRoles);

const createUserForm = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    roles: []
});

const sendFormData = () => {

    console.log(`data about to be submitted: ${createUserForm.name}, ${createUserForm.email}, ${createUserForm.password}, ${createUserForm.roles}`)

    createUserForm.post(route('user-store'));

}

</script>

<template>
    <div>
        <h1>Create user</h1>

        <!-- /^[\p{L} ,.'-]+$/u -->
        <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData">
            <FormKit type="multi-step" tab-style="progress" steps-class="authFormCardBackground">

                <FormKit type="step" name="userInformations">
                    <FormKit
                        type="text"
                        name="name"
                        v-model="createUserForm.name"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        label="Your Name"
                        :validation="[['required'], ['matches', /^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u]]"
                        validation-visibility="live"

                    />
                    <FormKit
                        type="email"
                        name="email"
                        v-model="createUserForm.email"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        label="User Email"
                        validation="required|email"
                        validation-visibility="live"
                    />

                    <FormKit type="group">
                        <FormKit
                            type="password"
                            name="password"
                            v-model="createUserForm.password"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            label="User password"
                            :validation="[['required'], ['matches', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]]"
                            validation-visibility="live"
                        />

                        <FormKit
                            type="password"
                            name="password_confirm"
                            v-model="createUserForm.password_confirmation"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            label="Confirm user password"
                            :validation="[['required'], ['confirm']]"
                            validation-label="Confirmation"
                            validation-visibility="live"
                        />
                    </FormKit>

                    <template #stepNext="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(1)()"
                            label="Custom Next"
                            data-next="true"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />

                    </template>
                </FormKit>

                        <!-- label-class="form-label d-flex justify-content-start fw-bold" -->
                <FormKit type="step" name="userRoles">

                    <FormKit
                        type="checkbox"
                        label="Roles"
                        v-model="createUserForm.roles"
                        :options="userRoles"
                        help="Select roles"
                        validation="required|min:1"
                    />


                    <FormKit type="submit"
                        outer-class="form-outline mb-4"
                        input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                    >
                        Create
                    </FormKit>

                    <template #stepPrevious="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(-1)()"
                            label="Custom Previous"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />

                    </template>

                </FormKit>

            </FormKit>
        </FormKit>

    </div>
</template>
