<script setup>

const props = defineProps({
    item: {
        type: [Object],
        required: true
    }
})

</script>
<template>
    <div class="accordion-item authFormCardBackground bg-gradient" :id="props.item.id" :key="props.item.id">
        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
            <slot name="accordion-header"/>
        </h2>

        <div :id="'open' + props.item.id" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
            <div class="container-fluid accordion-body">
                <div class="row">
                    <slot name="accordion-body"/>
                </div>
            </div>
        </div>
    </div>
</template>
