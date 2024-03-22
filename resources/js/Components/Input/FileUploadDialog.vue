<script setup>

import FileUpload from 'primevue/fileupload'
import Button from 'primevue/button'

import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

import "primevue/resources/themes/aura-light-teal/theme.css";

const props = defineProps({
    id: {
        type: String,
        required: true
    },
    user: {
        type: Object,
        required: true
    }
});

const fileUpload = ref(null);

const emits = defineEmits(['onModalClose', 'pictureModified']);

const check = ($event) => {

    const { files } = $event

    const [ file ] = files;

    const form = useForm({
        image: file
    });

    sendCloseEmit();

    emits('pictureModified', form);
    // router.post(route('user-change-profile-picture'), form);

}

const sendCloseEmit = () => {

    resetFileUploadInputComponent();
    emits('onModalClose');

}

const resetFileUploadInputComponent = () => {
    fileUpload.value.clear();
    fileUpload.value.uploadedFileCount = 0;
}

</script>

<style scoped>

</style>

<template>
    <div class="modal fade" :id="props.id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('Upload new profile picture') }}</h1>
                        <button type="button" class="btn-close" @click="sendCloseEmit" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FileUpload
                            ref="fileUpload"
                            :url="route('user-change-profile-picture', { user: props.user })"
                            name="image"
                            accept="image/*"
                            :fileLimit="1"
                            :maxFileSize="1000000"
                            @upload="check($event)"
                        >
                            <template #chooseicon>
                                <i class="fa-solid fa-plus"></i>
                            </template>

                            <template #empty>
                                <p>{{ __('Drag and drop files here to upload.') }}</p>
                            </template>
                        </FileUpload>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="sendCloseEmit">Close</button>
                    </div>
                </div>
            </div>
        </div>
</template>
