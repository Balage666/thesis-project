<script setup>
import Toast from '*vue-components/Notification/Toast.vue';

import { usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const messages = computed(() => {
    return [usePage().props.value.errors, usePage().props.value.flash.message];
})

const errors = computed(() => {

    let mappedMessagesArray = Object.entries(messages.value[0]).map((element) => element[1]);
    return mappedMessagesArray;
    // return messages.value[0];
});

const notification = computed(() => {
    return messages.value[1];
})

// console.log(errors.value);

</script>
<template>
    <div class="position-fixed fixed-top">
        <div class="float-end">
            <Toast v-if="errors" v-for="(e, idx) in errors" :message="e" :key="idx" :index="idx"/>
            <Toast v-if="notification" :message="notification" :toastType="message"/>
        </div>
    </div>
</template>

