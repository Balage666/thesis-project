<script setup>
import { ref } from "vue";

import "primevue/resources/themes/aura-light-teal/theme.css";

import Rating from "primevue/rating";

const props = defineProps({
    alreadyRated: {
        type: Boolean,
        default: false,
    },
    product: {
        type: Object,
        required: true,
    },
    ratedAs: {
        type: Number,
        default: 0
    }
});

const rating = ref(props.ratedAs);

const emits = defineEmits(["onRated"]);

const sendRatedProductData = () => {
    const data = {
        product: props.product,
        rating: rating.value,
    };

    emits("onRated", data);
};
</script>
<template>
    <div>
        <Rating
            v-model="rating"
            :stars="5"
            :readonly="props.alreadyRated"
            :cancel="props.alreadyRated"
            @update:modelValue="sendRatedProductData"
        >
            <template #onicon>
                <slot name="onicon"/>
            </template>

            <template #officon>
                <slot name="officon"/>
            </template>
        </Rating>
    </div>
</template>
