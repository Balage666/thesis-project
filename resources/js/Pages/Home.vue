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

        <!-- FIXED... I guess: Components don't fill the whole page -->
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


            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tristique orci vel justo feugiat interdum. Sed finibus vitae felis ut venenatis. Nulla volutpat lacus vel augue hendrerit, sit amet eleifend nunc accumsan. Vivamus posuere velit eu posuere condimentum. Vestibulum faucibus, magna vitae hendrerit porttitor, risus sapien varius lorem, vel imperdiet sem orci at nibh. Vivamus ligula mauris, ullamcorper sit amet bibendum non, pellentesque eu elit. Maecenas ante lorem, pharetra sit amet tempus non, pretium a sem. Maecenas blandit tellus malesuada felis vulputate tincidunt. In ut semper dolor. Fusce malesuada ipsum ante, in maximus lacus imperdiet et.</p>

            <p>Quisque fringilla, massa quis lacinia fermentum, nibh nunc tristique erat, ac ultrices lorem nisi vel elit. Duis quis lorem dictum, dignissim turpis a, tristique augue. Suspendisse in facilisis sem. Morbi elementum, nunc at suscipit vehicula, magna nulla interdum quam, eu posuere eros ipsum malesuada nunc. Nullam lacinia interdum feugiat. Aliquam et ante ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Quisque pulvinar purus non arcu hendrerit imperdiet. Etiam tortor dolor, mattis eget consequat porta, varius eu augue. Duis porta efficitur diam vitae imperdiet.</p>

            <p>Integer semper arcu arcu. Integer nec lorem in lacus eleifend sodales. Aenean vestibulum urna ex, ac efficitur nunc mollis nec. Quisque eu libero leo. Suspendisse eu dapibus urna. Etiam sagittis auctor nunc, ac luctus elit lacinia non. Quisque ligula lectus, aliquet a elit non, efficitur mattis diam. Pellentesque nunc erat, luctus accumsan velit ut, dictum iaculis leo. Proin ut mi vitae nisl auctor interdum. Phasellus pulvinar mattis ligula id tincidunt. Mauris semper consequat odio sed imperdiet. Praesent ullamcorper purus sem, vel scelerisque augue convallis vel. Phasellus blandit augue vel nulla ornare tempor. Praesent viverra enim at massa condimentum congue ut vitae tortor.</p>


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
