<script setup>

import { onMounted, ref } from 'vue';

const props = defineProps({
    message: {
        type: String,
        default: 'Hello, world! This is a toast message.'
    },
    toastType: {
        type: String,
        default: 'success'
    },
    name: {
        type: String,
        default: 'Bootstrap'
    }
})

const hidden = ref(false);

const close = () => {
    hidden.value = true
}

onMounted(() => {
    setTimeout(() => {
        hidden.value = true;
    }, 2500)
})

</script>

<template>
    <!-- TODO: Design toast component! -->
    <Transition>
        <div v-show="!hidden" class="toast show my-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">{{ props.name }}</strong>
                <!-- <small class="text-body-secondary">11 mins ago</small> -->
                <button type="button" class="btn-close" @click="close" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ props.message }}
            </div>
        </div>
    </Transition>
</template>

<style scoped>

.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

</style>
