<script setup>

import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'

import { router } from '@inertiajs/vue3';

import ToastStack from '*vue-components/Notification/ToastStack.vue';

const form = useForm({
    email: null,
    password: null,
})

const clearForm = () => {
    form.email = '',
    form.password = ''
}

const logIn = () => {

    const data = useForm({ ...form });

    clearForm();

    router.post(route('log-on'), data);

}

</script>

<template>
    <Head>
        <title>{{ __("Login") }}</title>
    </Head>
    <div>

        <ToastStack/>

        <div class="container py-5 h-100">


            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg p-3 authFormCardBackground bg-gradient" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h1 class="mb-3">{{ __("Hi!") }}</h1>

                            <h3 class="mb-3">{{ __("Please, type your email and password!") }}</h3>

                            <form @submit.prevent="logIn">
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

                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex justify-content-start" for="password">{{__("Password")}}</label>
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

                                <div class="d-grid gap-2">
                                    <button class="btn btn-lg btn-primary shadow-sm fw-bold" type="submit"> <i class="fa-solid fa-right-to-bracket"></i> {{ __("Login") }}</button>
                                </div>


                            </form>

                            <hr class="my-4">

                            <div class="d-grid">
                            <a :href="route('google-log-in')" class="btn btn-lg btn-secondary shadow-sm fw-bold"
                                type="button"><i class="fab fa-google me-2"></i> {{ __("Sign in with Google") }}</a>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid">

                                <h4 class="text-start">{{ __("I'm new here!") }}</h4>

                                <div class="d-grid">
                                    <Link
                                        :href="route('sign-up')"
                                        method="get"
                                        as="button"
                                        type="button"
                                        class="btn btn-outline btn-lg btn-warning shadow-sm fw-bold"
                                    >
                                            <i class="fa-solid fa-plus"></i> {{ __("Create a new account!") }}
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
