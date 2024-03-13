<script setup>

import { onMounted, onUpdated,  ref } from 'vue';

const props = defineProps({
    index: {
        type: Number,
        default: 0
    },
    message: {
        type: String,
        default: 'Alert message.'
    },
    toastType: {
        type: String,
        default: 'alert'
    },
    title: {
        type: String,
        default: 'Alert'
    }
})

const hidden = ref(false);

const close = () => {
    hidden.value = true
}

console.log(props.message);

onMounted(() => {

    setTimeout(() => {
        close()
    }, 2500)
})

</script>

<template>
    <!-- TODO: Design toast component! -->
    <Transition>
        <div v-show="!hidden" class="toast show my-2" :class="{ 'error-toast-bg-color text-white' : props.toastType === 'alert', 'bg-primary-subtle' : props.toastType !== 'alert' }" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" :class="{ 'error-toast-bg-color text-white' : props.toastType === 'alert', 'bg-primary-subtle' : props.toastType !== 'alert' }">
                <strong class="me-auto">{{ props.title + ' ' + props.idx }}</strong>
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
