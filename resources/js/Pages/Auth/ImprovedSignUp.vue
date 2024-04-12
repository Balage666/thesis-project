<script setup>

import { FormKit } from '@formkit/vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';

import selectRoleObj from '*js-shared/select-role-obj';

import ToastStack from '*vue-components/Notification/ToastStack.vue';

const signUpForm = useForm({
    name: null,
    email: null,
    role: null,
    password: null,
    password_confirmation: null
})

const sendFormData = () => {

    router.post(route('sign-on'), signUpForm);
}

</script>
<template>
    <Head>
        <title>{{ __('User registration') }}</title>
    </Head>

    <ToastStack />

    <div class="my-2">
        <FormKit type="form" @submit="sendFormData()" :actions="false" #default="{ disabled }">

            <FormKit type="multi-step" tab-style="progress" :hide-progress-labels="false" :allow-incomplete="false" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center mb-5">

                <FormKit type="step" :name="__('userDetails')">

                    <h1 class="mb-3 mx-5 text-center">{{ __("Welcome!") }}</h1>

                    <h3 class="mb-3 mx-5 text-center"> {{ __("Create your account!") }} </h3>

                    <FormKit
                        id="name"
                        type="text"
                        name="name"
                        v-model="signUpForm.name"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        :label="__('Full Name')"
                        :placeholder="__('Enter your name')"
                        :validation="[['required']]"
                        validation-visibility="submit"
                        :validation-messages="{
                            required: __('Full Name is required')
                        }"

                    />

                    <FormKit
                        id="email"
                        type="email"
                        name="email"
                        v-model="signUpForm.email"
                        label-class="form-label d-flex justify-content-start fw-bold"
                        outer-class="form-outline mb-4"
                        input-class="form-control form-control-lg"
                        :label="__('Email address')"
                        :placeholder="__('Enter your email')"
                        :validation="[['required']]"
                        validation-visibility="submit"
                        :validation-messages="{
                            required: __('Email address is required')
                        }"

                    />

                    <template #stepNext="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(1)()"
                            :label="__('Continue')"
                            data-next="true"
                            outer-class="form-outline mb-4 ms-auto me-auto"
                            input-class="btn btn-lg btn-success shadow-sm fw-bold"
                        />

                    </template>

                </FormKit>


                <FormKit type="step" :name="__('roleSelection')">
                    <h3 class="mb-3 mx-auto text-center"> {{ __("Select your role for your user!") }} </h3>

                    <FormKit
                        id="role"
                        type="radio"
                        name="role"
                        v-model="signUpForm.role"
                        label-class="form-check-label my-1 d-flex justify-content-start fw-bold"
                        outer-class="form-check mb-4 p-3"
                        input-class="form-check-input form-check-input-lg"
                        :options="selectRoleObj"
                        :validation="[['required']]"
                        validation-visibility="submit"
                        :validation-message="{
                            required: __('Selecting a role is required')
                        }"
                        :help="__('Choose a role!')"

                    />

                    <template #stepPrevious="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(-1)()"
                            :label="__('Back')"
                            data-next="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline ms-auto me-auto mb-4"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />

                    </template>

                    <template #stepNext="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(1)()"
                            :label="__('Continue')"
                            data-next="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline ms-auto me-auto mb-4"
                            input-class="btn btn-lg btn-success shadow-sm fw-bold"
                        />

                    </template>


                </FormKit>

                <FormKit type="step" :name="__('credentials')">

                    <FormKit type="group">

                        <h3 class="mb-3 mx-auto text-center"> {{ __("Enter your password and confirm it!") }} </h3>

                        <FormKit
                            id="password"
                            type="password"
                            name="password"
                            v-model="signUpForm.password"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__('Password')"
                            :placeholder="__('Enter your password!')"
                            :validation="[['required'], ['matches', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/]]"
                            validation-visibility="submit"
                            :validation-messages="{
                                required: __('Password is required')
                            }"
                        />

                        <FormKit
                            id="password_confirm"
                            type="password"
                            name="password_confirm"
                            v-model="signUpForm.password_confirmation"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__('Password confirmation')"
                            :placeholder="__('Confirm your password')"
                            :validation="[['required'], ['confirm']]"
                            :validation-label="__('Password confirmation')"
                            validation-visibility="submit"
                            :validation-messages="{
                                required: __('Password confirmation is required')
                            }"
                        />
                    </FormKit>


                    <template #stepPrevious="{ handlers, node }">

                        <FormKit
                            type="button"
                            @click="handlers.incrementStep(-1)()"
                            :label="__('Back')"
                            data-next="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline ms-auto me-auto mb-4"
                            input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                        />

                    </template>


                    <template #stepNext="{ handlers, node }">

                        <FormKit
                            type="submit"
                            :label="__('Register')"
                            data-next="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline ms-auto me-auto mb-4"
                            input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                        />

                    </template>


                </FormKit>

            </FormKit>


        </FormKit>
    </div>


    <hr class="my-4">

    <div class="ps-2 d-flex gap-2">

        <div>
            <h4 class="text-start mt-2">{{__("Already have an account?")}}</h4>
        </div>

        <div>
            <Link
                :href="route('log-in')"
                method="get"
                as="button"
                type="button"
                class="btn btn-outline btn-lg btn-warning fw-bold"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                {{ __("Login with existing account") }}
            </Link>
        </div>

    </div>
</template>

