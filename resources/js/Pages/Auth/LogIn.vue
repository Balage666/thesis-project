<script setup>

import { Link, useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
    email: null,
    password: null,
})

</script>

<template>
    <Head>
        <title>Login</title>
    </Head>
    <div>

        <div class="container py-5 h-100">

            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong authFormCardBackground" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h1 class="mb-5">Hi!</h1>

                            <h3 class="mb-7">Please, type your email and password!</h3>

                            <form @submit.prevent="form.post('/auth/log-on')">

                                <div class="alert alert-danger" v-if="form.errors.email">{{ form.errors.email }}</div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex justify-content-start" for="email">Email</label>
                                    <input
                                        class="form-control form-control-lg formInputFieldBackground"
                                        id="email"
                                        name="email"
                                        type="email"
                                        placeholder="Enter your email"
                                        v-model="form.email"
                                        required
                                    >
                                </div>

                                <div class="alert alert-danger" v-if="form.errors.password">{{ form.errors.password }}</div>
                                <div class="form-outline mb-4">
                                    <label class="form-label d-flex justify-content-start" for="password">Type your password</label>
                                    <input
                                        class="form-control form-control-lg formInputFieldBackground"
                                        id="password"
                                        name="password"
                                        type="password"
                                        v-model="form.password"
                                        placeholder="Type your password"
                                        required
                                    >
                                </div>


                                <!-- TODO: implement the backend behind this -->
                                <!-- <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="checkbox" />
                                    <label class="form-check-label" for="checkbox"> Remember password </label>
                                </div> -->

                            <div class="d-grid gap-2">
                                <button class="btn btn-lg authSubmitButtonBackground" type="submit">Login</button>
                            </div>


                            </form>

                            <hr class="my-4">

                            <div class="d-grid">
                            <button class="btn btn-lg signInWithGoogleButtonBackground"
                                type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid">

                                <h4 class="text-start">I'm new here!</h4>

                                <div class="d-grid">
                                    <Link href="/auth/sign-up" method="get" as="button" type="button" class="btn btn-outline btn-lg authNormalButtonBackground">Register</Link>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
