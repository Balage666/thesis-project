<script setup>
import { ref, onMounted, computed } from 'vue';

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
                    <div class="d-flex align-items-center justify-content-center ">
                        <div class="card my-0 mx-2 bg-light border-success border-3 p-2" v-for="product in itemArray">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">{{ product.name }}</h5>
                            <p class="card-text">{{ product.shortened_description }}</p>

                            <div class="row">
                                <div class="col-12 text-center d-grid gap-2 gap-lg-1 d-md-flex d-lg-flex align-items-md-center justify-content-md-center align-items-lg-center justify-content-lg-between">
                                    <a href="#" class="btn btn-lg btn-primary">Go somewhere</a>
                                    <a href="#" class="btn btn-lg btn-primary">Go somewhere</a>
                                </div>
                                <!-- <div class="col-12 col-md-6 col-lg-6 text-center">
                                </div> -->
                            </div>
                        </div>
                        </div>
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
