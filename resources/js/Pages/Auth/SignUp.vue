<script setup>

import { Link, useForm } from '@inertiajs/inertia-vue3'
import { router } from '@inertiajs/vue3';

import ToastStack from '*vue-components/Notification/ToastStack.vue';

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
});

const clearForm = () => {

    form.name = null;
    form.email = null;
    form.password = null;
    form.password_confirmation = null;

}

const signUp = () => {

    const data = useForm({ ...form });

    clearForm();

    router.post(route('sign-on'), data);
}

</script>

<template>
    <Head>
        <title>{{ __("Registration") }}</title>
    </Head>

    <ToastStack/>

    <div>

    <div class="container py-5 h-100">

    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong authFormCardBackground bg-gradient" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                    <h1 class="mb-3">{{ __("Welcome!") }}</h1>

                    <h3 class="mb-3">{{ __("Create your account!") }}</h3>

                    <form @submit.prevent="signUp">

                        <!-- <div class="alert alert-danger" v-if="form.errors.name">{{ form.errors.name }}</div> -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-flex justify-content-start" for="name">{{ __("Full Name") }}</label>
                            <input
                                class="form-control form-control-lg formInputFieldBackground"
                                id="name"
                                name="name"
                                type="text"
                                :placeholder="__('Give your name')"
                                v-model="form.name"
                                required
                            >
                        </div>


                        <!-- <div class="alert alert-danger" v-if="form.errors.email">{{ form.errors.email }}</div> -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-flex justify-content-start" for="email">{{ __("Email address") }}</label>
                            <input
                                class="form-control form-control-lg formInputFieldBackground"
                                id="email"
                                name="email"
                                type="email"
                                :placeholder="__('Enter your email')"
                                v-model="form.email"
                                required
                            >
                        </div>

                        <!-- <div class="alert alert-danger" v-if="form.errors.password">{{ form.errors.password }}</div> -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-flex justify-content-start" for="password">{{ __("Password") }}</label>
                            <input
                                class="form-control form-control-lg formInputFieldBackground"
                                id="password"
                                name="password"
                                type="password"
                                v-model="form.password"
                                :placeholder="__('Type your password')"
                                required
                            >
                        </div>

                        <!-- <div class="alert alert-danger" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</div> -->
                        <div class="form-outline mb-4">
                            <label class="form-label d-flex justify-content-start" for="password_confirmation">{{ __("Password confirmation") }}</label>
                            <input
                                class="form-control form-control-lg formInputFieldBackground"
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                :placeholder="__('Confirm your password')"
                                required
                            >
                        </div>


                    <div class="d-grid gap-2">
                        <button class="btn btn-lg btn-primary fw-bold" type="submit"> <i class="fa-solid fa-plus"></i> {{ __("Register") }}</button>
                    </div>


                    </form>

                    <hr class="my-4">

                    <div class="d-grid">

                        <h4 class="text-start">{{__("Already have an account?")}}</h4>

                        <div class="d-grid">
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

                </div>
            </div>
        </div>
    </div>

</div>

</div>

</template>
