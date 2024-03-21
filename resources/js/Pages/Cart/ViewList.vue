<script setup>

import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    cart: {
        type: [Array, Object]
    }
})

const cartShow = ref(props.cart);

console.log(props.cart);

console.log(cartShow.value);

const sendIncrement = (product) => {

    router.post(route('basket-increment', { product: product }));

}

const sendDecrement = (product) => {

    router.post(route('basket-decrement', { product: product }));

}

const sendDelete = (product) => {

    router.post(route('remove-from-basket', { product: product }));
}

const sendClear = () => {

    router.post(route('clear-basket'));
}

</script>

<template>
    <div class="container-fluid bg-info-subtle my-5 p-5">

        <div class="row">
            <h3 class="mb-4">{{ __('Shopping Cart') }}</h3>
        </div>

        <div class="row d-flex justify-content-center align-items-center" v-if="cartShow.cart_items?.length > 0">
            <div class="col-10">

                <div class="card rounded-3 mb-4" v-for="cart_item in cartShow.cart_items">
                    <div class="card-body p-4">
                        <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                            <img
                            :src="cart_item.product_item.pictures[0]?.product_picture"
                            class="img-fluid rounded-3" :alt="cart_item.product_item.name">
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3">
                            <p class="lead fw-normal mb-2">{{ cart_item.product_item.name }}</p>
                            <p><span class="text-muted">Category: </span> {{ cart_item.product_item.category.name }} </p>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                            <button @click="sendDecrement(cart_item.product_item)" class="btn btn-link px-2">
                                <i class="fas fa-minus"></i>
                            </button>

                            <input v-model="cart_item.amount" readonly id="amountForm" name="amount" type="number"
                            class="form-control form-control-sm" />

                            <button @click="sendIncrement(cart_item.product_item)" class="btn btn-link px-2">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                            <h5 class="mb-0">{{ `€ ${cart_item.price}` }}</h5>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                            <a as="button" role="button" @click="sendDelete(cart_item.product_item)" class="text-danger">
                                <i class="fas fa-trash fa-lg"></i>
                            </a>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-info btn-lg">{{ __('Checkout') }}</button>
                        <button @click="sendClear" type="button" class="btn btn-secondary btn-lg">{{ __('Clear Basket') }}</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row" v-else>
            <h1 class="text-center">{{ ('Your basket is empty ') }} <i class="fa-solid fa-face-frown"></i> </h1>
        </div>
    </div>
</template>
