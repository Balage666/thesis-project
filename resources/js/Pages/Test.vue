<script setup>

import { Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';

import ProductCarousel from '*vue-components/DataDisplay/Product/ProductCarousel.vue';
import Tiptap from '*vue-components/Input/TipTap.vue'
import ToastStack from '*vue-components/Notification/ToastStack.vue';
import RateProduct from '*vue-components/Input/RateProduct.vue';
import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    products: {
        type: [Array, Object]
    }
})

const globalProps = usePage().props.value;
const currentUser = ref(globalProps.active_session.user);
// console.log(currentUser.product_ratings.some((r) => r.product_id == props.products.data[0].id));

const checkAlreadyRated = (user, product) => {
    return user?.product_ratings.some((r) => r.product_id == product.id);
}

// console.log(checkAlreadyRated(currentUser, props.products.data[0]));

const randomProduct = computed(() => {
    const random = Math.floor(Math.random() * props.products.data.length)
    return props.products.data[random];
})

const carouselProducts = ref(props.products.data);

const check = (payload) => {

    console.log(payload);

    const data = {
        rating: payload.rating
    }

    router.post(route('product-rate', { product: payload.product }), data);
}

</script>


<template>
    <div>

        <BodyLayout>
            <h1>New Feature test</h1>

            <pre>{{ $page.props.permissions }}</pre>

            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ props.products.data[0].name }}</h5>
                    <p class="card-text">{{ props.products.data[0].shortened_description }}</p>
                    <p class="card-text">{{ props.products.data[0].price }}</p>
                    <p>Rating</p>
                    <RateProduct :alreadyRated="checkAlreadyRated(currentUser, props.products.data[0])" :product="props.products.data[0]" @onRated="check"/>

                    <!-- <Rating v-model="rating" :stars="5" :cancel="false" @update:modelValue="check"/> -->
                    <!-- <Link :href="route('add-to-basket', { product: props.products.data[0] })" method="post" as="button" type="button" class="btn btn-primary">Add to Basket</Link>
                    <Link :href="route('remove-from-basket', { product: props.products.data[0] })" method="post" as="button" type="button" class="btn btn-danger">Remove from Basket</Link> -->
                </div>
            </div>


            <!-- <LanguageSwitcher/> -->
        </BodyLayout>



    </div>



</template>

<style scoped>


</style>

