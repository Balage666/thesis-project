<script setup>
import { Link, router } from '@inertiajs/vue3';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { computed, ref } from 'vue';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import ListAccordion from '*vue-components/DataDisplay/ListAccordion.vue';
import ListAccordionItem from '*vue-components/DataDisplay/ListAccordionItem.vue';

const props = defineProps({
    products: {
        type: Object
    }
})

const productList = computed(() => props.products.data);

const currentUser = ref(usePage().props.value.active_session.user);

const sendDeleteRequest = (product) => {

    router.post(route('product-delete', { product: product }));

}

const searchForm = useForm({
    search: route().params.search || ''
})

const sendSearch = () => {

    router.get(route(route().current()), { search: searchForm.search })

}

const sendCleanSearch = () => {

    if (searchForm.search === '') {
        router.get(route(route().current()));
    }

}

</script>

<style scoped>

</style>

<template>
    <Head>
        <title>{{ __('List products') }}</title>
    </Head>
    <BodyLayout>

        <div class="container-fluid bg-info-subtle border-0 p-5">
            <div v-if="productList.length == 0">
                <h3 class="p-5 text-center fw-bold fs-1" >{{ __('There are no products!') }}</h3>
            </div>
            <div v-else>
                <div class="row m-3 d-none d-md-flex">

                    <div class="col-lg-6 col-md-6 col-12 mt-3">

                        <form @submit.prevent="sendSearch" class="d-flex align-content-center justify-content-center" role="search">
                            <input @input="sendCleanSearch" v-model="searchForm.search" class="form-control border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
                            <button class="btn btn-primary border-2 rounded-start-0" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        </form>

                    </div>

                </div>

                <div class="row overflow-y-scroll" style="height: 650px;">
                    <div class="col-12">
                        <ListAccordion>

                            <ListAccordionItem v-for="product in productList" :item="product">
                                <template v-slot:accordion-header>
                                    <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + product.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="col-12 col-md-6 col-lg-9 mt-1">
                                            <span class="fw-bold">{{ product.name }}</span>
                                        </div>
                                    </button>
                                </template>

                                <template v-slot:accordion-body>
                                    <div class="col-md-12 p-md-5 col-lg-12">
                                        <div class="card border-0 rounded-5">
                                            <div class="card-body">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="row">
                                                        <div class="col-12 col-xs-12 col-md-4 col-lg-3 mt-md-2">
                                                            <span>{{ __('Distributed by: ') }}</span>
                                                            <h4>{{ product.distributor.name }}</h4>
                                                        </div>
                                                        <div class="col-12 col-xs-12 col-md-4 col-lg-6 mt-0 mt-md-3">
                                                            <span>{{ __('Product name: ') }}</span>
                                                            <h4 class="fw-bold">{{ product.name }}</h4>
                                                        </div>
                                                        <div class="col-12 col-xs-12 col-md-4 col-lg-3 mt-md-3">
                                                            <button v-if="product.distributor.id === currentUser.id || currentUser.roles.some(({name}) => name === 'Admin')" class="btn btn-danger" @click="sendDeleteRequest(product)"><i class="fa-solid fa-x"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 p-md-5 mt-3 mt-md-0 mt-lg-0 col-lg-6">

                                        <div class="card mb-3">
                                            <div class="row g-0">
                                                <div class="col-lg-4 col-12 text-center d-none d-lg-flex">
                                                    <img :src="product.preview_image" class="img-fluid" :alt="product.name" :title="product.name">
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-12">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ product.name }}</h5>
                                                        <p class="card-text">{{ product.shortened_description }}</p>
                                                        <p class="card-text">{{ __('Category:') }}  {{ product.category.name }}</p>
                                                        <p class="card-text"><small class="text-muted">Last updated {{ product.updated_at_human_readable }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 col-md-6 p-md-5 mt-3 mt-md-0 mt-lg-0 col-lg-6">

                                        <div class="card mb-3 border-0">
                                            <div class="row g-0">
                                                <div class="d-grid gap-2">
                                                    <Link :href="route('product-show', { product: product })"  method="get" as="button" type="button" class="btn btn-lg btn-info shadow-sm fw-bold">{{ __('View Product') }}</Link>
                                                    <Link :href="route('product-edit', { product: product })" method="get" as="button" type="button" class="btn btn-lg btn-info shadow-sm fw-bold">{{ __('Legacy Product Editor') }}</Link>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </template>
                            </ListAccordionItem>

                        </ListAccordion>


                    </div>
                </div>
            </div>
        </div>


    </BodyLayout>



</template>



