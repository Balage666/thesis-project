<script setup>

import AddressItem from '*vue-components/DataDisplay/Address/AddressItem.vue';

const props = defineProps({
    list: {
        type: Array,
        required: true
    }
})

</script>

<template>
    <div class="container">

        <div v-if="props.list.length > 0">

            <AddressItem v-for="address in props.list" :item="address"/>
        </div>

        <h3 v-else class="text-center">{{ __('There are no addresses!') }}</h3>
    </div>
</template>

