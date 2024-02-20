<script setup>

import PhoneNumberItem from '*vue-components/DataDisplay/PhoneNumber/PhoneNumberItem.vue';

const props = defineProps({
    list: {
        type: Array,
        required: true
    }
})

</script>

<template>
    <div class="container">
        <ul class="list-group" v-if="props.list.length > 0">
        <!-- <pre v-for="item in props.list">{{ item }}</pre> -->
            <PhoneNumberItem class="list-group-item" v-for="phoneNumberItem in props.list" :item="phoneNumberItem"/>
        </ul>

        <h3 v-else class="text-center">There are no available phone numbers!</h3>
    </div>

</template>

