<script setup>
import ListProductItem from '*vue-components/DataDisplay/Product/ListProductItem.vue';


const props = defineProps({
    products: {
        type: [Array, Object],
        required: true
    }
})

</script>
<template>
    <div class="container-fluid no-padding">
        <h3 v-if="props.products.length < 1" class="text-center">{{  __('Such emptiness!') }}</h3>
        <ListProductItem v-else v-for="product in props.products" :item="product"/>
    </div>
</template>
