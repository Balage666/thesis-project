<script setup>
import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/vue3';
import { onUnmounted, onBeforeUnmount, onMounted } from 'vue'

const props = defineProps({
    statusCode: Number,
    title: String,
    description: String
})

onMounted(() => {
    setTimeout(() => {
        router.get(route('storefront'))
    }, 2500)
})

</script>



<template>
    <Head>
        <title>{{ __(props.title) }}</title>
    </Head>
    <div class="container vh-100 d-flex flex-grow-1 justify-content-center align-items-center">
        <div class="card bg-light-subtle vw-100" style="height: 24rem">
            <div class="d-flex align-items-center justify-content-center vh-100">
                <div class="text-center">
                    <h1 class="display-1 fw-bold">{{ __(props.statusCode) }}</h1>
                    <p class="fs-3"> {{ __(props.title) }}</p>
                    <p class="lead">
                        {{ __(props.description) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
