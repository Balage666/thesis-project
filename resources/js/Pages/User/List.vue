<script setup>

import { Link, Head, router } from '@inertiajs/vue3';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import { useIntersectionObserver } from '@vueuse/core';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue'
import Pagination from '*/js/Components/DataDisplay/Pagination.vue';
import axios from 'axios';

const props = defineProps({
    users: {
        type: Object
    }
});


const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);
const currentLocale = ref(pageProps.value.current_locale);

// console.log(permissions.value);

const sendUserDeleteRequest = (user) => {

    console.log(user);
    router.post(route('user-delete', { user: user }));

}

// console.log(props.users.meta);

const last = ref(null);

const next = ref(currentLocale.value === 'en' ? props.users.meta.links.filter(l => l.label === 'Next').shift()?.url : props.users.meta.links.filter(l => l.label === 'Következő').shift()?.url);

// console.log(next.value);

useIntersectionObserver(last, ([{ isIntersecting }]) => {

    console.log(isIntersecting);

    if (!isIntersecting) {
        return
    }

    if (next.value === null) {
        return
    }

    axios.get(`${next.value}`).then((response) => {

        console.log(response);

        props.users.data.push(...response.data.data);
        props.users.meta = response.data.meta;

        next.value = currentLocale.value === 'en' ? props.users.meta.links.filter(l => l.label === 'Next').shift().url : props.users.meta.links.filter(l => l.label === 'Következő').shift().url;

    })

})
const searchForm = useForm({
    search: route().params.search || ''
});
const sendSearch = () => {

    router.get(route(route().current()), { search: searchForm.search });

}

const sendCleanSearch = () => {

    if (searchForm.search === '') {
        router.get(route(route().current()));
    }

}

// console.log(route().params);

</script>

<template>

    <Head>
        <title>{{ __("List users") }}</title>
    </Head>

    <BodyLayout>
        <div>

            <div class="container-fluid p-5 bg-info-subtle border-0">

                <div class="row m-3">

                    <div class="col-lg-6 col-md-6 col-12 mt-3">

                        <form @submit.prevent="sendSearch" class="d-flex align-content-center justify-content-center" role="search">
                            <input @input="sendCleanSearch" v-model="searchForm.search" class="form-control border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
                            <button class="btn btn-primary border-2 rounded-start-0" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        </form>

                    </div>

                </div>

                <div class="row m-3 overflow-y-scroll" style="height: 600px;">
                    <div class="col-12">
                        <div class="accordion" id="accordionList">
                            <div class="accordion-item authFormCardBackground bg-gradient"  v-for="user in props.users.data" :key="user.id">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + user.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="col-3 me-2">
                                            <img :src="user.profile_picture" class="border-0 rounded-5" width="45px" height="45px">
                                        </div>
                                        <div class="col-3 mt-1">
                                            <span class="fw-bold">{{ user.name }}</span>
                                        </div>
                                    </button>
                                </h2>

                                <div :id="'open' + user.id" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="container-fluid accordion-body">

                                        <div class="row">
                                            <div class="col-md-12 p-md-5 col-lg-8">

                                                <div class="card border-0 rounded-5">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-column align-items-center text-center">
                                                            <img :src="user.profile_picture" :alt="user.name" class="rounded-circle" width="150">
                                                            <div class="mt-1">
                                                                <h4>{{ user.name }}</h4>
                                                                <div class="d-grid gap-2">
                                                                    <Link :href="route('user-show', { user: user })" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">View User</Link>
                                                                    <Link :href="route('user-edit', { user: user })" method="get" as="button" type="button" class="btn btn-outline btn-lg btn-info shadow-sm fw-bold">Legacy User Editor</Link>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-12 p-md-5 col-lg-4">

                                                <div class="my-3 my-lg-0">
                                                    <h2 class="text-center">{{ __(":first_name\'s roles: ", user) }}</h2>
                                                    <ul class="list-group border-0 rounded-5">
                                                        <li class="list-group-item p-3 text-center" v-for="role in user.roles">{{ __(role.name) }}</li>
                                                    </ul>
                                                </div>

                                            </div>

                                            <div class="col-12">

                                                <div class="my-3 my-lg-0 text-center">
                                                    <button @click="sendUserDeleteRequest(user)" class="btn btn-lg btn-danger" type="button">Delete</button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="next !== null" class="col-12 py-1" ref="last">
                        <div class="accordion" id="accordionPlaceholder">
                            <div class="accordion-item authFormCardBackground bg-gradient">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-info placeholder" type="button">
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BodyLayout>
</template>
