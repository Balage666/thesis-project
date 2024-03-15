<script setup>
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { computed, ref } from 'vue';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import ListAccordion from '*vue-components/DataDisplay/ListAccordion.vue';
import ListAccordionItem from '*vue-components/DataDisplay/ListAccordionItem.vue';

const props = defineProps({
    products: {
        type: Object
    }
})

// const propArray = [
// 'id',,'is_out_of_stock','is_close_to_run_out_of_stock',
// 'description', 'created_at_human_readable', 'updated_at_human_readable',
// 'comments', 'ratings'
// ];

const productList = computed(() => props.products.data);
// const ObjectProperties = computed(() => Object.getOwnPropertyNames(productList.value[0])
// .filter(
//     p => !propArray.includes(p)
// )
// .map(
//     (p) => `${p[0].toUpperCase()}${p.slice(1)}`
// )
// .map(
//     (p) => p.replaceAll('_', ' ')
// ))

// console.log(ObjectProperties.value);

const currentUser = ref(usePage().props.value.active_session.user);

console.log(productList.value);

const sendDeleteRequest = (product) => {

    console.log(product);
    router.post(route('product-delete', { product: product }));

}

</script>

<style scoped>

</style>

<template>
    <!--TODO: Implement Add to favorite button-->
    <Head>
        <title>{{ __('List products (design in development)') }}</title>
    </Head>
    <pre>{{ productList.length }}</pre>
    <BodyLayout>
        <!-- <h1>List products (design in development)</h1> -->


        <!--TODO: Make it scrollable and redesign it-->

        <div class="container-fluid bg-info-subtle border-0 p-5">
            <div v-if="productList.length == 0">
                <h3 class="p-5 text-center fw-bold fs-1" >{{ __('There are no products!') }}</h3>
            </div>
            <div v-else>
                <div class="row m-3 d-none d-md-flex">

                    <div class="col-lg-6 col-md-6 col-12 mt-3">

                        <form class="d-flex align-content-center justify-content-center" role="search">
                            <input class="form-control border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
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
                                                    <Link href="" method="get" as="button" type="button" class="btn btn-lg btn-outline-danger shadow-sm fw-bold">{{ __('Add to Favorites') }}</Link>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </template>

                            </ListAccordionItem>

                        </ListAccordion>


                        <!-- <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item authFormCardBackground bg-gradient" v-for="product in productList" :key="product.id">

                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + product.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="col-12 col-md-6 col-lg-9 mt-1">
                                            <span class="fw-bold">{{ product.name }}</span>
                                        </div>
                                    </button>
                                </h2>

                                <div :id="'open' + product.id" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="container-fluid accordion-body">
                                        <div class="row">
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
                                                                    <button class="btn btn-danger" @click="sendDeleteRequest(product)"><i class="fa-solid fa-x"></i></button>
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

                                                            <Link href="" method="get" as="button" type="button" class="btn btn-lg btn-outline-danger shadow-sm fw-bold">{{ __('Add to Favorites') }}</Link>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->


                    </div>
                </div>
            </div>
        </div>


    </BodyLayout>



</template>
<!-- <div class="col-md-12 p-md-5 col-lg-12">

    <div class="my-2 my-lg-0">
        <h2 class="text-center mb-5">Products in this category</h2>
        <div v-if="category.products.length == 0">
            <h4 class="text-center">{{ __('Such emptiness!') }}</h4>
        </div>
        <div v-else>
            <ul class="list-group border-0 rounded-5">
                <li class="list-group-item p-3 text-center" v-for="product in category.products">
                    <div class="row mt-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <img :src="product.preview_image" class="border-0 rounded-3" style="width: 25%">
                        </div>
                        <div class="col-12 col-md-6 col-lg-9 mt-2">
                            <span class="fw-bold">
                                {{ __(product.name) }}
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</div> -->



