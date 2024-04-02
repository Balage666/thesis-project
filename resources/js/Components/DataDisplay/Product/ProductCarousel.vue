<script setup>
import { ref, onMounted, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';

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

const emits = defineEmits(['favoriteAdded', 'favoriteRemoved']);

const chunk = (array, size) => {
    return Array.from({ length: Math.ceil(array.length / size) }, (value, index) =>
        array.slice(index * size, index * size + size)
    );
}

const chunkedCarouselProducts = computed(() => {
    return chunk(props.products, props.visiblePerSlide);
})

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);
const currentUser = ref(pageProps.value.active_session.user);

const emitFavoriteAdd = (user, product) => {

    emits('favoriteAdded', { emitType: 'favoriteAdded', user: user, product: product });
    // emits('favoriteAdded', data);

}

const emitFavoriteRemove = (user, product) => {

    // console.log('Remove clicked');
    emits('favoriteRemoved', { emitType: 'favoriteRemoved', user: user, product: product });
}

const addToCart = (product) => {

    // console.log(product);

    router.post(route('add-to-basket', { product: product }));

}

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
                            <img :src="product.preview_image" class="card-img-top" :alt="product.name" style="height: 260px;"/>
                            <div class="card-body">

                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">{{ product.name }}</h5>
                                    <h5 class="text-dark mb-0">{{ product.price }}</h5>
                                </div>

                                <div class="d-flex justify-content-between gap-1">
                                    <button @click="emitFavoriteAdd(currentUser, product)" class="btn btn-lg btn-outline-danger" v-if="permissions.authenticated && !currentUser?.favorites.find(f => f.product_id === product.id) && currentUser.id != product.distributor.id"><i class="fa-regular fa-heart"></i></button>
                                    <button @click="emitFavoriteRemove(currentUser, product)" class="btn btn-lg btn-danger" v-if="permissions.authenticated && currentUser?.favorites.find(f => f.product_id === product.id) && currentUser.id != product.distributor.id"><i class="fa-solid fa-heart"></i></button>
                                    <button @click="addToCart(product)" class="btn btn-lg btn-info" v-if="currentUser?.id != product.distributor.id"><i class="fa-solid fa-basket-shopping"></i></button>
                                    <Link :href="route('product-show', { product: product })" class="btn btn-lg btn-secondary"><i class="fa-solid fa-eye"></i></Link>
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
