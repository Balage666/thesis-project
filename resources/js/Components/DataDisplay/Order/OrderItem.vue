<script setup>

import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
})

const sendDeleteOrderRequest = () => {

    router.post(route('order-destroy', { order: props.item }));

}

</script>
<template>
    <li>
        <div class="row">
            <div class="col-6 text-start my-4 my-md-2">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-6">
                        <Link :href="route('order-show', { order: props.item })" class=" text-black text-decoration-none ">
                            <span><i class="fa-solid fa-boxes-packing"></i> {{ `${__('Order #')}${item.id}` }}</span>
                        </Link>
                    </div>
                    <div class="col-6">
                        <span class="fw-bold">{{ __(item.status) }}</span>
                    </div>

                </div>
            </div>
            <div class="col-6 text-end d-flex align-items-center justify-content-evenly">

                <button @click="sendDeleteOrderRequest" type="button" class="btn btn-danger"> <i class="fa-solid fa-circle-xmark fa-sm"></i> {{ __('Delete') }}</button>

            </div>

        </div>
    </li>
</template>

