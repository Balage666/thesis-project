<script setup>

import OrderItem from '*vue-components/DataDisplay/Order/OrderItem.vue';

const props = defineProps({
    list: {
        type: [Array, Object],
        required: true,
    }
})

</script>
<template>
    <div class="container">
        <ul class="list-group" v-if="props.list.length > 0">
            <OrderItem class="list-group-item" v-for="orderItem in props.list" :item="orderItem" />
        </ul>

        <h3 v-else class="text-center">{{ __('No orders found!') }}</h3>
    </div>
</template>

