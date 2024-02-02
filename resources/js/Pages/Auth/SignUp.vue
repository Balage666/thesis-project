<script setup>

import { Link, useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
})

</script>

<template>
    <Head>
        <title>Registration</title>
    </Head>

    <div>

    <div class="container py-5 h-100">

    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong authFormCardBackground" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                    <h1 class="mb-5">Welcome!</h1>

                    <h3 class="mb-7">Create your account!</h3>

                    <form @submit.prevent="form.post(route('sign-on'))">

                        <div class="alert alert-danger" v-if="form.errors.name">{{ form.errors.name }}</div>
                        <div class="form-outline mb-4">
                            <label class="form-label d-flex justify-content-start" for="name">Full Name</label>
                            <input
                                class="form-control form-control-lg formInputFieldBackground"
                                id="name"
                                name="name"
                                type="text"
                                placeholder="Give your name"
                                v-model="form.name"
                                required
                            >
                        </div>


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
                            <label class="form-label d-flex justify-content-start" for="password">Password</label>
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

                        <div class="alert alert-danger" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</div>
                        <div class="form-outline mb-4">
                            <label class="form-label d-flex justify-content-start" for="password_confirmation">Password confirmation</label>
                            <input
                                class="form-control form-control-lg formInputFieldBackground"
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                placeholder="Confirm your password"
                                required
                            >
                        </div>


                    <div class="d-grid gap-2">
                        <button class="btn btn-lg btn-primary fw-bold" type="submit">Register</button>
                    </div>


                    </form>

                    <hr class="my-4">

                    <div class="d-grid">

                        <h4 class="text-start">Already have an account?</h4>

                        <div class="d-grid">
                            <Link :href="route('log-in')" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-warning fw-bold">Login</Link>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

</div>

</template>
