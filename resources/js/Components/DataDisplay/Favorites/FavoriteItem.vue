<script setup>

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const emits = defineEmits(['onItemDeleteRequest']);

const emitFavoriteDeleteRequest = (product) => {

    emits('onItemDeleteRequest', product);

}

</script>
<template>
    <li>
        <div class="row">
            <div class="col-6 text-start my-4 my-md-2">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-6">
                        <img :src="item.product.preview_image" :alt="item.product.name" width="50px" height="50px">
                    </div>
                    <div class="col-6">
                        <span class="fw-bold">{{ item.product.name }}</span>
                    </div>
                </div>
            </div>
            <div class="col-6 text-end d-flex align-items-center justify-content-evenly">

                <button @click="emitFavoriteDeleteRequest(item.product)" type="button" class="btn btn-danger"> <i class="fa-solid fa-circle-xmark fa-sm"></i> {{ __('Delete') }}</button>

            </div>

        </div>
    </li>
</template>
