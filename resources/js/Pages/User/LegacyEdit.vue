<script setup>

import { FormKit } from '@formkit/vue';

import { useForm, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';

import { filterUserRoles } from '*js-shared/filtered-user-roles';
import { userRolesAsModeratorForEdit } from '*js-shared/user-roles-as-moderator_for_edit';
import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    userToEdit: {
        type: Object
    }
})

const pageProps = ref(usePage().props.value);
const currentUser = ref(pageProps.value.active_session.user);

const userValues = props.userToEdit.data[0];

const rolesUserHave = userValues.roles.map(r => r.name).filter(r => filterUserRoles.includes(r));

const getRoles = () => {

    if (currentUser.value.roles.some((r) => r.name == 'Moderator') &&
    !currentUser.value.roles.some((r) => r.name == 'Admin') &&
    currentUser.value.id != userValues.id)
    {
        return userRolesAsModeratorForEdit;
    }
    return filterUserRoles;

}

const rolesReadOnly = () => {

    let readOnly = false;
    if (currentUser.value.id == userValues.id) {
        readOnly = true;
    }
    return readOnly;

}

const form = useForm({
    name: userValues.name,
    email: userValues.email,
    roles: rolesUserHave
})

const sendFormData = () => {

    form.post(route('user-update', { user: userValues }));

}

const callResetPassword = () => {
    router.post(route('user-reset-password', { user: userValues }));
}

</script>
<template>
    <Head>
        <title>{{ __(':name - Legacy Edit', userValues) }}</title>
    </Head>

    <BodyLayout>
        <div class="p-5">

            <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

                <FormKit type="multi-step" tab-style="progress" :allow-incomplete="true" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center ">

                    <FormKit type="step" :name="__('editUserInfo')">
                        <h3 class="mb-7 text-center"> {{ __("Edit data for :name", userValues) }} </h3>

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

                        <FormKit type="button"
                            :label="__(`Reset :name's password`, userValues)"
                            outer-class="form-outline mb-4 text-center"
                            input-class="btn btn-lg btn-info shadow-sm fw-bold"
                            @click="callResetPassword"
                        />


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

                    <FormKit type="step" :name="__('editRoles')">

                        <h3 class="mb-7 text-center"> {{ __("Modify roles for :name!", userValues) }} </h3>

                        <FormKit
                            id="roles"
                            name="roles"
                            type="checkbox"
                            :label="__(`:name's Roles`, userValues)"
                            v-model="form.roles"
                            :options="getRoles()"
                            :help="__('Select roles')"
                            validation="required|min:1"
                            :disabled="rolesReadOnly()"
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
                                :label="__('Update')"
                                outer-class="form-outline mb-4"
                                input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                            />

                        </template>

                    </FormKit>

                </FormKit>

            </FormKit>

        </div>
    </BodyLayout>

</template>
