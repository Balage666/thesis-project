<script setup>

import { FormKit } from '@formkit/vue';

import { useForm, router } from '@inertiajs/vue3';

import { userRoles } from '../../Shared/user-roles';

import { filterUserRoles } from '../../Shared/filtered-user-roles';

const props = defineProps({
    userToEdit: {
        type: Object
    }
})

const userValues = props.userToEdit.data[0];

const rolesUserHave = userValues.roles.map(r => r.name).filter(r => r != 'Customer');

console.log(rolesUserHave);

const form = useForm({
    name: userValues.name,
    email: userValues.email,
    roles: rolesUserHave
})

const sendFormData = () => {

    form.post(route('user-update', { user: userValues }));

}

</script>
<template>
    <Head>
        <title>Legacy Edit</title>
    </Head>

    <div>
        <h1>Legacy Edit</h1>
        <!-- <pre>{{ props.userToEdit }}</pre> -->


        <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

            <FormKit type="multi-step" tab-style="progress" :allow-incomplete="true" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center ">

                <FormKit type="step" name="editUserInfo">
                    <h3 class="mb-7 text-center"> {{ __("Edit :name's data", userValues) }} </h3>

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

                    <FormKit type="button"
                        :label="__('Reset :name\'s password', userValues)"
                        outer-class="form-outline mb-4 text-center"
                        input-class="btn btn-lg btn-info shadow-sm fw-bold"
                    />


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

                <FormKit type="step" name="editRoles">

                    <h3 class="mb-7 text-center"> {{ __("Modify roles for :name!", userValues) }} </h3>

                    <FormKit
                        id="roles"
                        name="roles"
                        type="checkbox"
                        :label="__(':name\'s Roles', userValues)"
                        v-model="form.roles"
                        :options="filterUserRoles"
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
                            label="Update"
                            outer-class="form-outline mb-4"
                            input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                        />

                    </template>

                </FormKit>

            </FormKit>

        </FormKit>

    </div>

</template>