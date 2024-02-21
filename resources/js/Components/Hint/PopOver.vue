<template>
    <button
        type="button"
        class="btn btn-lg btn-warning"
        data-bs-toggle="popover"
        title="Popover title"
        :data-bs-content="props.hint"
    >
        Click to toggle popover
    </button>
</template>

<script setup>

const props = defineProps({
    hint: {
        type: String,
        default: 'Default PopOver Hint'
    }
})

</script>
