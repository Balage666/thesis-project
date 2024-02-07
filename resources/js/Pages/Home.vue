<script setup>

import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue';
import { FormKit } from '@formkit/vue';


import BodyLayout from './Layouts/BodyLayout.vue';

//TODO: Remove commented lines
// const step = ref('contactInfo')
// const stepNames = ['contactInfo', 'organizationInfo', 'application']

// const camel2title = (str) =>
//     str
//     .replace(/([A-Z])/g, (match) => ` ${match}`)
//     .replace(/^./, (match) => match.toUpperCase())
//     .trim()


</script>

<!--<style scoped>

@import 'https://cdn.formk.it/web-assets/multistep-form.css';

</style>-->

<template>
    <div>
        <BodyLayout>

            <h1>Vue3 & FormKit test</h1>


            <!-- <h1 class="text-2xl font-bold mb-4">Carbon Sequestration Grant</h1>

            <FormKit type="form" #default="{ value }">
                <ul class="steps">
                <li
                    v-for="stepName in stepNames"
                    class="step"
                    @click="step = stepName"
                    :data-step-active="step === stepName"
                >
                    {{ camel2title(stepName) }}
                </li>
                </ul>

                <div class="form-body">
                <section v-show="step === 'contactInfo'">
                    <FormKit type="group" id="contactInfo" name="contactInfo">
                    <FormKit
                        type="email"
                        label="*Email address"
                        validation="required|email"
                    />
                    </FormKit>
                </section>

                <section v-show="step === 'organizationInfo'">
                    <FormKit id="organizationInfo" type="group" name="organizationInfo">
                    <FormKit
                        type="text"
                        label="*Organization name"
                        validation="required|length:3"
                    />
                    </FormKit>
                </section>

                <section v-show="step === 'application'">
                    <FormKit id="application" type="group" name="application">
                    <FormKit
                        type="textarea"
                        label="*How will you use the money?"
                        validation="required|length:20,500"
                    />
                    </FormKit>
                </section>

                <details>
                    <summary>Form data</summary>
                    <pre>{{ value }}</pre>
                </details>
                </div>
            </FormKit> -->


            <div v-if="$page.props.active_session.user">
                <h2>{{ $page.props.active_session.user.name }}</h2>
                <hr>
                <h2>{{ $page.props.active_session.user.email }}</h2>
                <hr>
                <h2>{{ $page.props.active_session.user }}</h2>
                <hr>
                <h2>{{ route().has('storefront') }}</h2>
                <hr>
                <img
                    :src="$page.props.active_session.user.profile_picture"
                    :title="$page.props.active_session.user.name"
                    :alt="$page.props.active_session.user.name"
                >
            </div>

            <Link
                v-if="$page.props.active_session.user"
                class="btn btn-outline btn-lg btn-warning fw-bold"
                :href="route('log-out')"
            >
                {{ __("Log Out") }}
            </Link>

        </BodyLayout>

    </div>
</template>
