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

const emits = defineEmits(["onRated", "onRatingDelete"]);

const sendRatedProductData = () => {
    const data = {
        product: props.product,
        rating: rating.value,
    };

    emits("onRated", data);
};

const sendDeleteRatingData = () => {

    // emits('onRatingDelete', )
}

</script>
<template>
    <div class="d-flex align-items-center">
        <div>
            <Rating
                v-model="rating"
                :stars="5"
                :readonly="props.alreadyRated"
                :cancel="false"
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
        <div>
            <button @click="emits('onRatingDelete')" class="btn" v-show="props.alreadyRated">
                <i class="fa-solid fa-ban" style="color: #ff0000;"></i>
            </button>
        </div>
    </div>
</template>
