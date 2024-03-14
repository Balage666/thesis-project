<script setup>
import { ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    carouselId: {
        type: String,
        default: ''
    },
    products: {
        type: [Array, Object],
        required: true
    },
    visiblePerSlide: {
        type: [Number, String],
        default: 3
    }
})

const chunk = (array, size) => {
    return Array.from({ length: Math.ceil(array.length / size) }, (value, index) =>
        array.slice(index * size, index * size + size)
    );
}

const chunkedCarouselProducts = computed(() => {
    return chunk(props.products, props.visiblePerSlide);
})


</script>


<template>
    <div :id="props.carouselId + 'productCarousel'" class="carousel carousel-dark slide py-5">
            <div class="carousel-indicators my-auto">
                <button
                    v-for="(item, index) in chunkedCarouselProducts"
                    :key="index"
                    type="button"
                    :data-bs-target="'#'+ props.carouselId + 'productCarousel'"
                    :data-bs-slide-to="index"
                    :class="{ 'active' : index === 0 }"
                    :aria-current="index === 0"
                    :aria-label="'Slide '+ index"
                ></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item" v-for="(itemArray, index) in chunkedCarouselProducts" :key="index" :class="{ 'active' : index === 0 }">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card my-2 mx-2 bg-light border-info border-3 p-2" v-for="product in itemArray">
                            <img :src="product.preview_image" class="card-img-top" :alt="product.name" />
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">{{ product.name }}</h5>
                                    <h5 class="text-dark mb-0">{{ product.price }}</h5>
                                </div>

                                <div class="d-flex justify-content-between gap-1">
                                    <a href="#" class="btn btn-lg btn-outline-danger" v-show="$page.props.permissions.authenticated"><i class="fa-regular fa-heart"></i></a>
                                    <a href="#" class="btn btn-lg btn-info"><i class="fa-solid fa-basket-shopping"></i></a>
                                    <Link :href="route('product-show', { product: product })" class="btn btn-lg btn-secondary"><i class="fa-solid fa-eye"></i></Link>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-12 col-md-5 col-lg-5 p-3 text-center">
                                        <span class="fw-bold">{{ product.price }}</span>
                                    </div>
                                    <div class="col-12 col-md-7 col-lg-7 text-center d-grid gap-2 gap-lg-1 d-md-flex d-lg-flex align-items-md-center justify-content-md-center align-items-lg-center justify-content-lg-between">
                                        <a href="#" class="btn btn-lg btn-outline-danger"><i class="fa-regular fa-heart"></i></a>
                                        <a href="#" class="btn btn-lg btn-info"><i class="fa-solid fa-basket-shopping"></i></a>
                                        <a href="#" class="btn btn-lg btn-primary"><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" :data-bs-target="'#'+ props.carouselId + 'productCarousel'" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" :data-bs-target="'#'+ props.carouselId + 'productCarousel'" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
</template>


<style scoped>



</style>
