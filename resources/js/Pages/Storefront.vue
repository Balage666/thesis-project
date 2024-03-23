<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { usePage, useForm } from '@inertiajs/inertia-vue3';
import { computed, ref } from 'vue';

import { useIntersectionObserver } from '@vueuse/core';

import Slider from 'primevue/slider'
import "primevue/resources/themes/lara-light-cyan/theme.css";

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import ProductCarousel from '*vue-components/DataDisplay/Product/ProductCarousel.vue';
import Pagination from '*vue-components/DataDisplay/Pagination.vue';

import { translations } from '../Mixins/translations'

import axios from 'axios';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    carouselProducts: {
        type: [Array, Object]
    },
    allProducts: {
        type: [Array, Object]
    },
    categories: {
        type: [Array, Object]
    },
    distributors: {
        type: [Array, Object]
    }
})

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);

const currentUser = ref(pageProps.value.active_session.user);
const currentLocale = ref(pageProps.value.current_locale);
const filterForm = useForm({

    selectedCategories: route().params.selectedCategories || [],
    selectedDistributors: route().params.selectedDistributors || [],
    rangeInput: route().params.rangeInput || [],
    availability: route().params.availability || false
});

const selectedFilters = computed(() => {
    // console.log(filterForm.selectedDistributors.length);
    let count = filterForm.selectedCategories.length + filterForm.selectedDistributors.length + (filterForm.rangeInput.length == 2 ? 1 : 0) + (filterForm.availability ? 1 : 0);

    // console.log(count);

    return count;

})

const filter = () => {

    console.log(filterForm);
    const {selectedCategories, selectedDistributors, availability, rangeInput} = filterForm;
    router.get(route(route().current()), { selectedCategories: selectedCategories, selectedDistributors: selectedDistributors, rangeInput: rangeInput, availability: availability })
}

const clearFilters = () => {

    filterForm.selectedCategories = [];
    filterForm.selectedDistributors = [];
    filterForm.rangeInput = [];
    filterForm.availability = false;

    console.log(route().current());
    router.get(route(route().current()));

}

// console.log(filterForm.availability);

const carouselProductsShowCase = computed(() => props.carouselProducts.data);
const allProductsShowCase = computed(() => props.allProducts.data);

const calculateStars = (avg) => {

    return Math.round(avg);
}

const scrollable = ref(null);

console.log(currentLocale.value);
const next = ref(currentLocale.value == 'en' ? props.allProducts.meta.links.filter(l => l.label == 'Next').shift()?.url : props.allProducts.meta.links.filter(l => l.label == 'Következő').shift()?.url);
console.log(next.value);

useIntersectionObserver(scrollable, ([{ isIntersecting }]) => {
    if (!isIntersecting) {
        return
    }

    if (next.value === null) {
        return
    }
    else {

        axios.get(`${next.value}`).then((response) => {


            props.allProducts.data.push(...response.data.data);
            console.log(props.allProducts.data, props.allProducts.meta, response.data.data, response.data.meta);
            props.allProducts.meta = response.data.meta;
            next.value = currentLocale.value == 'en' ? props.allProducts.meta.links.filter(l => l.label == 'Next').shift()?.url : props.allProducts.meta.links.filter(l => l.label == 'Következő').shift()?.url;

        })
    }
})

const processEmit = (payload) => {

    if (payload.emitType == 'favoriteAdded') {
        addToFavorites(payload.user, payload.product);
    }

    if (payload.emitType == 'favoriteRemoved') {
        removeFromFavorites(payload.user, payload.product);
    }

}

const addToFavorites = (user, product) => {

    router.post(route('add-to-favorites', { user: user, product: product }));

}

const removeFromFavorites = (user, product) => {

    router.post(route('remove-from-favorites', { user: user, product: product }));
}

const addToCart = (product) => {

    router.post(route('add-to-basket', { product: product }));

}

</script>

<template>
    <Head>
        <title>{{ __('Storefront') }}</title>
    </Head>

    <div>

        <BodyLayout>

            <div class="container-fluid bg-info-subtle border-0">

                <div class="row">
                    <h3 class="mt-3">{{ __('Show case') }}</h3>
                </div>

                <hr>

                <div class="row">

                    <div class="col-12">
                        <ProductCarousel
                            class="d-none d-md-none d-lg-flex"
                            :carouselId="'large'"
                            :products="carouselProductsShowCase"
                            :visiblePerSlide="4"
                            @favoriteAdded="processEmit"
                            @favoriteRemoved="processEmit"
                        />

                        <ProductCarousel
                            class="d-none d-md-flex d-sm-none d-lg-none"
                            :carouselId="'mid'"
                            :products="carouselProductsShowCase"
                            :visiblePerSlide="2"
                            @favoriteAdded="processEmit"
                            @favoriteRemoved="processEmit"
                        />

                        <ProductCarousel
                            class="d-flex d-md-none d-sm-flex d-lg-none"
                            :carouesleId="'small'"
                            :products="carouselProductsShowCase"
                            :visiblePerSlide="1"
                            @favoriteAdded="processEmit"
                            @favoriteRemoved="processEmit"
                        />
                    </div>
                </div>

                <div class="row mt-5">

                    <div class="col-12 col-md-4 filter-board-bg-color border-0 rounded-top-5 rounded-bottom-0 p-3">

                        <div class="text-center">
                            <h3>{{ __('Filters') }}</h3>
                        </div>
                        <hr>
                        <div class="container">

                            <form @submit.prevent="filter">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>{{ __('Categories') }}</h4>
                                        <hr>
                                    </div>

                                    <div class="overflow-y-scroll overflow-x-hidden" style="height: 300px">
                                        <div class="col-12 form-check-inline d-flex gap-2" v-for="category in props.categories">
                                            <label class="form-check-label" :for="category.id">{{ __(category.name) }}</label>
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :name="category.name"
                                                :id="category.id"
                                                :value="category.id"
                                                v-model="filterForm.selectedCategories"
                                                :true-value="[]"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">

                                    <div class="col-12">
                                        <h4>{{ __('Distributors') }}</h4>
                                        <hr>
                                    </div>

                                    <div class="overflow-y-scroll overflow-x-hidden" style="height: 200px">
                                        <div class="col-12 form-check-inline d-flex gap-2" v-for="distributor in props.distributors">
                                            <label class="form-check-label" :for="distributor.id">{{ distributor.name }}</label>
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :name="distributor.name"
                                                :id="distributor.id"
                                                :value="distributor.id"
                                                v-model="filterForm.selectedDistributors"
                                                :true-value="[]"
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-3">

                                    <div class="col-12">
                                        <h4>{{ __('Price') }}</h4>
                                        <hr>
                                    </div>

                                    <div class="col-12">
                                        <div class="row d-flex align-content-between gap-2">

                                            <div class="col-12 col-md-2 ps-0 pe-0 text-center">
                                                <input type="number" style="width: 50px" v-model="filterForm.rangeInput[0]" readonly>
                                            </div>

                                            <div class="col-12 col-md-7 px-0 text-center ">
                                                <Slider :min="1" :max="100" v-model="filterForm.rangeInput" range/>
                                            </div>

                                            <div class="col-12 col-md-2 ps-0 pe-0 text-center">
                                                <input type="number" style="width: 50px" v-model="filterForm.rangeInput[1]" readonly>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h4>{{ __('Availability') }}</h4>
                                        <hr>
                                    </div>

                                    <div class="col-12 form-check-inline d-flex gap-2">
                                        <label class="form-check-label" for="stock">{{ __('In Stock') }}</label>
                                        <input class="form-check-input" type="checkbox" name="stock" id="stock" v-model="filterForm.availability">
                                    </div>
                                </div>

                                <div class="row mt-3 text-center d-flex align-items-center">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-lg btn-info">{{ __('Filter') }}</button>
                                    </div>

                                    <div class="col-12 col-md-6 mt-sm-2">
                                        <button type="button" @click="clearFilters" class="btn btn-lg btn-secondary">{{ __('Clear') }} <span v-if="selectedFilters > 0">{{ selectedFilters }}</span></button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="col-12 col-md-8 p-3">

                        <div class="text-center">
                            <h3>{{ __('Products') }}</h3>
                        </div>

                        <hr>

                        <div class="container">

                            <div class="row overflow-y-scroll" style="height: 950px">

                                <h4 v-if="props.allProducts.data.length == 0">{{ __('No products found!') }}</h4>

                                <div v-else class="mt-2 col-md-12 col-lg-4 mb-4 mb-lg-0" v-for="product in props.allProducts.data" :key="product.id">

                                    <div class="card border-3 border-info">
                                        <img :src="product.preview_image" class="card-img-top" :title="product.category.name" :alt="product.name" style="height: 260px;" />
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <p class="small">
                                                    <span class="text-muted">{{ product.category.name }}</span>
                                                </p>
                                            </div>

                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ product.name }}</h5>
                                                <h5 class="text-dark mb-0">{{ product.price }}</h5>
                                            </div>

                                            <div class="d-flex justify-content-between mb-2">
                                                <p class="text-muted mb-0">{{ __('Available:') }} <span class="fw-bold">{{ product.stock }}</span></p>
                                                <div class="ms-auto text-warning">
                                                    <i v-for="s in calculateStars(product.avg_of_ratings)" class="fa fa-star"></i>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between">

                                                    <button @click="addToFavorites(currentUser, product)" class="btn btn-lg btn-outline-danger" v-if="permissions.authenticated && !currentUser?.favorites.find(f => f.product_id === product.id) && currentUser.id != product.distributor.id"><i class="fa-regular fa-heart"></i></button>
                                                    <button @click="removeFromFavorites(currentUser, product)" class="btn btn-lg btn-danger" v-if="permissions.authenticated && currentUser?.favorites.find(f => f.product_id === product.id) && currentUser.id != product.distributor.id"><i class="fa-solid fa-heart"></i></button>

                                                    <button @click="addToCart(product)" v-if="currentUser?.id != product.distributor.id" class="btn btn-lg btn-info"><i class="fa-solid fa-basket-shopping"></i></button>
                                                    <Link method="get" :href="route('product-show', { product: product })" class="btn btn-lg btn-secondary"><i class="fa-solid fa-eye"></i></Link>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div v-if="next !== null" class="mt-2 col-md-12 col-lg-4 mb-4 mb-lg-0" ref="scrollable" v-for="n in 3">
                                    <div class="card" aria-hidden="true">
                                        <div class="card-body">
                                            <h5 class="card-title placeholder-glow">
                                                <span class="placeholder col-6"></span>
                                            </h5>
                                            <p class="card-text placeholder-glow">
                                            <span class="placeholder col-7"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-4"></span>
                                            <span class="placeholder col-6"></span>
                                            <span class="placeholder col-8"></span>
                                            </p>

                                            <div class="d-flex justify-content-between">
                                                <a class="btn btn-lg btn-outline-danger disabled placeholder" aria-disabled="true"></a>
                                                <a class="btn btn-lg btn-info disabled placeholder" aria-disabled="true"></a>
                                                <a class="btn btn-lg btn-secondary disabled placeholder" aria-disabled="true"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>

            </div>


        </BodyLayout>

    </div>
</template>

<style scoped>



</style>
