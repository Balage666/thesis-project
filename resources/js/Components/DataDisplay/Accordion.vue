<template>
    <div class="accordion" :id="'accordion' + cleanTitle">

        <div class="accordion-item authFormCardBackground bg-gradient">
            <h2 class="accordion-header" :id="'heading' + cleanTitle">
                <button class="accordion-button py-3 px-5 bg-info bg-gradient" :class="props.startsCollapsed ? 'collapsed' : ''" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse'+ cleanTitle" aria-expanded="false" :aria-controls="'collapse' + cleanTitle">
                    <h1 class="text-black">{{ __(props.title) }}</h1>
                </button>
            </h2>
            <div :id="'collapse'+ cleanTitle" class="accordion-collapse collapse" :class="!props.startsCollapsed ? 'show' : ''" :aria-labelledby="'heading' + props.title" :data-bs-parent="'#accordion' + cleanTitle">
                <div class="accordion-body">

                    <slot/>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    startsCollapsed: {
        type: Boolean,
        default: false
    }
})

const cleanTitle = props.title.replace(' ', '');

</script>
