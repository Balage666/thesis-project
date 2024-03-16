<script setup>

import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({

    item: {
        type: Object,
        required: true
    }

})

const sendDeleteProductRequest = () => {

    router.post(route('product-delete', { product: props.item }));

}

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);
const currentUser = ref(pageProps.value.active_session.user);

</script>
<template>
    <div class="row justify-content-center mb-3">
        <div class="col-md-12 col-xl-10">
            <div class="card border rounded-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                            <div class="">
                                <img :src="props.item.preview_image"
                                    class="w-100"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-6">
                            <h5>{{ props.item.name }}</h5>
                            <div class="d-flex flex-row">
                                <div class="text-danger mb-1 me-2">
                                    <i v-for="r in Math.trunc(props.item.avg_of_ratings)" class="fa fa-star"></i>
                                </div>
                                <span>{{ props.item.avg_of_ratings.toFixed(2) }}</span>
                            </div>
                            <div class="mt-1 mb-0 text-muted small">
                                <span>{{ __('In stock') }}: {{ props.item.stock }}</span>
                                <span class="text-primary"> • </span>
                                <span>{{ __(props.item.category.name) }}<br /></span>
                            </div>
                            <p class="text mb-4 mb-md-0">
                                {{ props.item.description }}
                            </p>
                        </div>
                        <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                            <div class="d-flex flex-row align-items-center mb-1">
                                <h4 class="mb-1 me-1">{{ props.item.price }}</h4>
                            </div>
                            <div class="d-flex flex-column mt-4">
                                <Link :href="route('product-show', { product: props.item })" as="button" type="button" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-eye fa-sm"></i> {{ __('View') }}
                                </Link>
                                <button v-show="currentUser.id != props.item.distributor.id" class="btn btn-outline-danger btn-sm mt-2" type="button">
                                    <i class="fa-regular fa-heart fa-sm"></i> {{ __('Add to Favorites') }}
                                </button>
                                <Link v-show="permissions.has_admin_role || (permissions.has_seller_role && currentUser.id == props.item.distributor.id)" :href="route('product-edit', { product: props.item })" as="button" type="button" class="btn btn-info btn-sm mt-2">
                                    <i class="fa-solid fa-screwdriver-wrench fa-sm"></i> {{ __('Legacy Edit') }}
                                </Link>
                                <button @click="sendDeleteProductRequest" v-show="permissions.has_admin_role || (permissions.has_seller_role && currentUser.id == props.item.distributor.id)" class="btn btn-danger btn-sm mt-2" type="button">
                                    <i class="fa-solid fa-circle-xmark fa-sm"></i> {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

