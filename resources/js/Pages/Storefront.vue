<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { computed, ref } from 'vue';
import Slider from 'primevue/slider'
import "primevue/resources/themes/lara-light-cyan/theme.css";

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import ProductCarousel from '*vue-components/DataDisplay/Product/ProductCarousel.vue';
import Pagination from '*vue-components/DataDisplay/Pagination.vue';

const props = defineProps({
    carouselProducts: {
        type: [Array, Object]
    },
    allProducts: {
        type: [Array, Object]
    }
})

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);

const rangeInput = ref([]);

const carouselProductsShowCase = computed(() => props.carouselProducts.data);
const allProductsShowCase = computed(() => props.allProducts.data);

const calculateStars = (avg) => {

    return Math.round(avg);
}

</script>

<template>
    <Head>
        <title>{{ __('Storefront') }}</title>
    </Head>

    <div>
        <BodyLayout>

            <!-- <pre>{{ allProductsShowCase }}</pre> -->

            <div class="container-fluid bg-info-subtle border-0">

                <div class="row">

                    <div class="col-12">
                        <h3>Show case</h3>
                        <ProductCarousel class="d-none d-md-none d-lg-flex" :carouselId="'large'" :products="carouselProductsShowCase" :visiblePerSlide="3"/>
                        <ProductCarousel class="d-none d-md-flex d-sm-none d-lg-none" :carouselId="'mid'" :products="carouselProductsShowCase" :visiblePerSlide="2"/>
                        <ProductCarousel class="d-flex d-md-none d-sm-flex d-lg-none" :carouesleId="'small'" :products="carouselProductsShowCase" :visiblePerSlide="1"/>
                    </div>
                </div>

                <div class="row mt-5">

                    <div class="col-4 filter-board-bg-color border-0 rounded-top-5 rounded-bottom-0 p-3">

                        <div class="text-center">
                            <h3>Filters</h3>
                        </div>
                        <hr>
                        <div class="container">

                            <form>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Categories</h4>
                                        <hr>
                                    </div>

                                    <div class="col-12 form-check-inline d-flex gap-2">
                                        <label class="form-check-label" for="category1">Category 1</label>
                                        <input class="form-check-input" type="checkbox" name="category1" id="category1">
                                    </div>

                                    <div class="col-12 form-check-inline d-flex gap-2">
                                        <label class="form-check-label" for="category2">Category 2</label>
                                        <input class="form-check-input" type="checkbox" name="category2" id="category2">
                                    </div>

                                </div>

                                <div class="row mt-3">

                                    <div class="col-12">
                                        <h4>Distributors</h4>
                                        <hr>
                                    </div>

                                    <div class="col-12 form-check-inline d-flex gap-2">
                                        <label class="form-check-label" for="distributor1">Distributor 1</label>
                                        <input class="form-check-input" type="checkbox" name="distributor1" id="distributor1">
                                    </div>

                                    <div class="col-12 form-check-inline d-flex gap-2">
                                        <label class="form-check-label" for="distributor2">Distributor 2</label>
                                        <input class="form-check-input" type="checkbox" name="distributor2" id="distributor2">
                                    </div>

                                </div>

                                <div class="row mt-3">

                                    <div class="col-12">
                                        <h4>Price</h4>
                                        <hr>
                                    </div>

                                    <div class="col-12 mt-1">
                                        <Slider :min="0" :max="250000" v-model="rangeInput" range/>
                                    </div>

                                    <div class="col-6">
                                        <input type="number" v-model="rangeInput[0]" disabled>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" v-model="rangeInput[1]" disabled>
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h4>Availability</h4>
                                        <hr>
                                    </div>

                                    <div class="col-12 form-check-inline d-flex gap-2">
                                        <label class="form-check-label" for="stock">In Stock</label>
                                        <input class="form-check-input" type="checkbox" name="stock" id="stock">
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="col-8 p-3">

                        <div class="text-center">
                            <h3>Products</h3>
                        </div>

                        <hr>

                        <div class="container overflow-y-scroll" style="height: 650px;">

                            <div class="row">

                                    <div class="mt-2 col-md-12 col-lg-4 mb-4 mb-lg-0" v-for="product in allProductsShowCase">
                                        <div class="card border-3 border-info">
                                            <img :src="product.preview_image" class="card-img-top" :title="product.category.name" :alt="product.name" />
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
                                                    <p class="text-muted mb-0">Available: <span class="fw-bold">{{ product.stock }}</span></p>
                                                    <div class="ms-auto text-warning">
                                                        <i v-for="s in calculateStars(product.avg_of_ratings)" class="fa fa-star"></i>
                                                        <!-- <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i> -->
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between">

                                                        <Link method="get" href="#" class="btn btn-lg btn-outline-danger" v-show="permissions.authenticated"><i class="fa-regular fa-heart"></i></Link>
                                                        <Link href="" class="btn btn-lg btn-info"><i class="fa-solid fa-basket-shopping"></i></Link>
                                                        <Link method="get" :href="route('product-show', { product: product })" class="btn btn-lg btn-secondary"><i class="fa-solid fa-eye"></i></Link>
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
