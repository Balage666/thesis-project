<script setup>

import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';

import "primevue/resources/themes/aura-light-teal/theme.css";

const emits = defineEmits(['categoryAdded', 'onModalClose'])

const props = defineProps({
    id: {
        type: String,
        required: true
    }
});

const invalid = ref(false);

const categoryForm = useForm({
    name: ''
});

const sendCategoryData = () => {

    if (categoryForm.name == '') {
        invalid.value = true;
    }
    emits('categoryAdded', categoryForm);

}

const sendCloseEmit = () => {

    clearInput()
    emits('onModalClose');

}

const clearInput = () => {
    invalid.value = false
}

</script>
<template>
    <div class="modal fade" :id="props.id" tabindex="-1" aria-labelledby="categoryAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryAddModalLabel">{{ __('Add new category') }}</h1>
                <button type="button" class="btn-close" @click="sendCloseEmit" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <div class="d-flex align-items-center justify-content-center">
                    <FloatLabel>
                        <InputText id="category" v-model="categoryForm.name" :invalid="invalid"/>
                        <label for="category">{{ __('New Category') }}</label>
                    </FloatLabel>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="sendCloseEmit" class="btn btn-secondary">{{ __('Close') }}</button>
                <button type="button" :disabled="categoryForm.name == ''" @click="sendCategoryData" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
            </div>
        </div>
    </div>
</template>
