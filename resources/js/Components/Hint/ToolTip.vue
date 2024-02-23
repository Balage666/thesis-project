<script setup>

import { Tooltip } from 'bootstrap';

import { onMounted } from 'vue';

const props = defineProps({
    hint: {
        type: String,
        default: 'Default PopOver Hint'
    }
})

onMounted(() => {
    new Tooltip(document.body, {
        selector: "[data-bs-toggle='tooltip']",
    })
})

</script>

<template>
    <button
        type="button"
        class="btn btn-lg btn-outline-warning"
        data-bs-toggle="tooltip"
        title="Tooltip title"
        :data-bs-content="props.hint"
    >
        <i class="fa-solid fa-question"></i>
    </button>
</template>

