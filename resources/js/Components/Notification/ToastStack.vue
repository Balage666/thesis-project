<script setup>
import Toast from '*vue-components/Notification/Toast.vue';

const props = defineProps({
    notifications: {
        type: [Array, Object],
        required: true
    }
})



</script>
<template>
    <div class="position-fixed fixed-top">
        <div class="float-end">
            <Toast v-for="n in props.notifications" :message="n"/>
        </div>
    </div>
</template>

