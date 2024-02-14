<script setup>

import { Link } from '@inertiajs/vue3'

const props = defineProps({
    pagination: {
        type: Object
    }
})

</script>

<template>
    <nav class="position-relative d-flex justify-content-center">

        <div v-for="link in pagination.links" :key="link.label">

            <Link
                class="d-flex align-items-center justify-content-center px-3 py-2 text-sm text-black"
                as="button" type="button"
                :href="link.url ?? ''"
                v-html="link.label"
                :disabled="!link.url"
                :class="{ 'text-white bg-black': link.active, 'bg-disabled text-secondary-subtle': !link.url }"

                preserve-scroll
            />
        </div>


    </nav>
</template>
