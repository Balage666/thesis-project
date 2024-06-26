<script setup>


import { FormKit } from '@formkit/vue';
import { useForm, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import { userRoles } from '*js-shared/user-roles'
import { userRolesAsModeratorForCreate } from '*js-shared/user-roles-as-moderator_for_create';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    roles: []
});

const sendFormData = () => {

    form.post(route('user-store'));

}

const getRoles = () => {

    if (permissions.value.has_moderator_role_at_most) {
        return userRolesAsModeratorForCreate;
    }
    return userRoles;

}

</script>

<template>

    <Head>
        <title>{{ __('Create user') }}</title>
    </Head>

    <BodyLayout>

        <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

            <FormKit type="multi-step" tab-style="progress" :allow-incomplete="false" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center">

                <FormKit type="step" :name="__('userInformations')">
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
                        :label="__(`User's name`)"
                        :validation="[['required'], ['matches', /^[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{1,}\s[A-ZÁÉÍÓÖŐÚÜŰ][a-záéíóöőúüű]{2,}$/u]]"
                        validation-visibility="live"
                        :validation-messages="{
                            required: __(`User's name is required`),
                            matches: __(`Incorrect format for user's name`)
                        }"
                    />


                    <FormKit
                        id="email"
                        type="email"
                        name="email"
                        v-model="form.email"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        :label="__(`User's email`)"
                        validation="required|email"
                        validation-visibility="live"
                        :validation-messages="{
                            required: __(`User's email is required`),
                            email: __(`User's email is incorrect`)
                        }"
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
                            :label="__(`User's password`)"
                            :validation="[['required'], ['matches', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]]"
                            validation-visibility="live"
                            :validation-messages="{
                                required: __('Password is required'),
                                matches: __('Incorrect format for password')
                            }"
                        />

                        <FormKit
                            id="password_confirm"
                            type="password"
                            name="password_confirm"
                            v-model="form.password_confirmation"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__(`Confirm user's password`)"
                            :validation="[['required'], ['confirm']]"
                            validation-label="Confirmation"
                            validation-visibility="live"
                            :validation-messages="{
                                required: __('Password confirmation is required'),
                                confirm: __('Passwords must match')
                            }"
                        />
                    </FormKit>

                    <template #stepNext="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(1)()"
                            :label="__('Continue')"
                            data-next="true"
                            outer-class="form-outline mb-4 ms-auto me-auto"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />

                    </template>
                </FormKit>

                <FormKit type="step" :name="__('userRoles')">

                    <h3 class="mb-7 text-center"> {{ __("Select roles for the user!") }} </h3>

                    <FormKit
                        id="roles"
                        name="roles"
                        type="checkbox"
                        :label="__('Roles')"
                        v-model="form.roles"
                        :options="getRoles()"
                        :help="__('Select roles')"
                        validation="required|min:1"
                        :validation-messages="{
                            required: __('Select roles is required'),
                            min: __('Select roles is required')
                        }"
                    />

                    <template #stepPrevious="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(-1)()"
                            :label="__('Back')"
                            data-next="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />


                        <FormKit type="submit"
                            :label="__('Create')"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                        />

                    </template>

                </FormKit>

            </FormKit>
        </FormKit>

    </BodyLayout>
</template>
