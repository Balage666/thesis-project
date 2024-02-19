<script setup>


import { FormKit } from '@formkit/vue';

import { useForm, router } from '@inertiajs/vue3';

import { ref } from 'vue';

import { userRoles } from '*js-shared/user-roles'


const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    roles: []
});

console.log(form.errors.name);

const sendFormData = () => {

    console.log(`data about to be submitted: ${form.name}, ${form.email}, ${form.password}, ${form.roles}`)

    form.post(route('user-store'));

}

</script>

<template>

    <div>

        <h1>Create user</h1>

        <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

            <FormKit type="multi-step" tab-style="progress" :allow-incomplete="false" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center ">


                <FormKit type="step" name="userInformations">
                    <h3 class="mb-7 text-center"> {{ __("Create a user with filling the form below!") }} </h3>

                    <div class="alert alert-danger" v-if="$page.props.errors" v-for="error in $page.props.errors">{{ __(error) }}</div>

                    <FormKit
                        id="name"
                        type="text"
                        name="name"
                        v-model="form.name"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        label="User's name"
                        :validation="[['required'], ['matches', /^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u]]"
                        validation-visibility="live"

                    />


                    <FormKit
                        id="email"
                        type="email"
                        name="email"
                        v-model="form.email"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        label="User's email"
                        validation="required|email"
                        validation-visibility="live"
                    />

                    <FormKit type="group">
                        <FormKit
                            id="password"
                            type="password"
                            name="password"
                            v-model="form.password"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            label="User's password"
                            :validation="[['required'], ['matches', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]]"
                            validation-visibility="live"
                        />

                        <FormKit
                            id="password_confirm"
                            type="password"
                            name="password_confirm"
                            v-model="form.password_confirmation"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            label="Confirm user's password"
                            :validation="[['required'], ['confirm']]"
                            validation-label="Confirmation"
                            validation-visibility="live"
                        />
                    </FormKit>

                    <template #stepNext="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(1)()"
                            label="Continue"
                            data-next="true"
                            outer-class="form-outline mb-4 ms-auto me-auto"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />

                    </template>
                </FormKit>

                <FormKit type="step" name="userRoles">

                    <h3 class="mb-7 text-center"> {{ __("Select roles for the user!") }} </h3>

                    <FormKit
                        id="roles"
                        name="roles"
                        type="checkbox"
                        label="Roles"
                        v-model="form.roles"
                        :options="userRoles"
                        help="Select roles"
                        validation="required|min:1"
                    />

                    <template #stepPrevious="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(-1)()"
                            label="Back"
                            data-next="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />


                        <FormKit type="submit"
                            label="Create"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                        />

                    </template>

                </FormKit>

            </FormKit>
        </FormKit>

    </div>
</template>
