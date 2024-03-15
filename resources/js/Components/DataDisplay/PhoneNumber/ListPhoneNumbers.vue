<script setup>

import PhoneNumberItem from '*vue-components/DataDisplay/PhoneNumber/PhoneNumberItem.vue';

const props = defineProps({
    list: {
        type: Array,
        required: true
    }
})

const emits = defineEmits(['listChanged']);

const sendChangedData = (payload) => {
    // console.log(payload);
    emits('listChanged', payload);
}

</script>

<template>
    <div class="container">
        <ul class="list-group" v-if="props.list.length > 0">
        <!-- <pre v-for="item in props.list">{{ item }}</pre> -->
            <PhoneNumberItem class="list-group-item" v-for="phoneNumberItem in props.list" :item="phoneNumberItem" @itemChanged="sendChangedData"/>
        </ul>

        <h3 v-else class="text-center">{{ __('There are no available phone numbers!') }}</h3>
    </div>

</template>

