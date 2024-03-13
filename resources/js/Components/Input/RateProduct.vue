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
});

const rating = ref(0);

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
        />
    </div>
</template>
