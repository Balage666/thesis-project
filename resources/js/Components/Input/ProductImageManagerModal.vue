<script setup>

import FileUpload from 'primevue/fileupload'
import Button from 'primevue/button'

import { ref, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';

import "primevue/resources/themes/aura-light-teal/theme.css";

const props = defineProps({
    id: {
        type: String,
        required: true
    },
    product: {
        type: Object,
        required: true
    },
    images: {
        type: [Array, Object],
        required: true
    }
})
const emits = defineEmits(['onModalClose', 'onItemsDelete', 'onUpload'])

const imageList = computed(() => {

    let list = props.images;

    list.forEach((element) => element.selected = false);
    return list;
})


const selectedCount = computed(() => {

    let count = 0;

    imageList.value.forEach((e) => {

        if (e.selected) {
            count++;
        }

    });

    return count;

})

const fileUpload = ref(null);

const sendCloseEmit = () => {

    resetFileUploadInputComponent();
    emits('onModalClose');

}

const sendUploadEmit = ($event) => {
    const { files } = $event

    const data = {
        images: files
    }

    sendCloseEmit()

    emits('onUpload', data);
}

const sendDeleteEmit = () => {

    const selectedItems = ref(imageList.value.filter(e => e.selected));

    selectedItems.value.forEach((element) => {
        delete element['selected'];
    })

    emits('onItemsDelete', selectedItems.value);
    emits('onModalClose');
}

const resetFileUploadInputComponent = () => {
    fileUpload.value.clear();
    fileUpload.value.uploadedFileCount = 0;
}

</script>
<template>
    <div class="modal fade" :id="props.id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('Upload pictures for this product!') }}</h1>
                    <button type="button" class="btn-close" @click="sendCloseEmit" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <FileUpload
                            ref="fileUpload"
                            name="image"
                            accept="image/*"
                            :maxFileSize="1000000"
                            :url="route('product-pictures-upload', { product: props.product })"
                            @upload="sendUploadEmit($event)"
                            :multiple="true"
                            :fileLimit="5"
                            :chooseLabel="__('Choose')"
                            :uploadLabel="__('Upload')"
                            :cancelLabel="__('Cancel')"
                        >
                            <template #chooseicon>
                                <i class="fa-solid fa-plus"></i>
                            </template>

                            <template #empty>
                                <p>{{ __('Drag and drop files here to upload.') }}</p>
                            </template>
                    </FileUpload>

                    <div class="container-fluid bg-light mt-2 border-0 rounded-1 p-3 overflow-y-scroll" style="height: 300px">

                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="mt-1">
                                <h4>{{ __('Uploaded images') }}</h4>
                            </div>

                            <div>
                                <button v-if="imageList.length != 0" :disabled="selectedCount == 0" @click="sendDeleteEmit" type="button" class="btn btn-danger">{{  __('Delete selected items') }} : {{ selectedCount }}</button>
                            </div>
                        </div>
                        <h5 v-if="imageList.length == 0" class="text-center">{{ __('This product has not got any images') }}</h5>
                        <div v-else class="row my-1" v-for="image in imageList">
                            <div class="col-1 mt-3">
                                <input v-model="image.selected" type="checkbox" :id="'selected' + image.id">
                            </div>
                            <div class="col-3">
                                <label :for="'selected' + image.id">
                                    <img :src="image.product_picture" style="width: 50px; height: 50px">
                                </label>
                            </div>
                            <div class="col-8">
                                <span>{{ image.product_picture }}</span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

