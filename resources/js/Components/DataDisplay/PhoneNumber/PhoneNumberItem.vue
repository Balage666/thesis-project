<script setup>

import { reactive } from 'vue';
import InputMask from 'primevue/inputmask';
import { useForm } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const emits = defineEmits(['itemChanged'])

const phoneNumberItem = reactive({ ...props.item, editModeVisible: false })

// console.log(phoneNumberItem);

const phoneNumberItemForm = useForm({
    number: phoneNumberItem.formatted_number,
    mask: phoneNumberItem.mask
})

const toggleEditModeForItem = () => {
    if (phoneNumberItem.editModeVisible) {
        resetForm()
    }
    phoneNumberItem.editModeVisible = !phoneNumberItem.editModeVisible;
}

const resetForm = () => {
    phoneNumberItemForm.number = phoneNumberItem.formatted_number,
    phoneNumberItemForm.mask = phoneNumberItem.mask
}

const sendEditedPhoneNumberData = () => {

    phoneNumberItemForm.number = phoneNumberItemForm.number.slice(4).replace(/[()-]/g, '');

    emits('itemChanged', [phoneNumberItemForm, props.item]);

}

const sendDeletePhoneNumberRequest = () => {

    router.post(route('phone-number-delete', { phone: props.item }));

}

</script>

<template>
    <li>
        <div class="row">
            <div class="col-6 text-start my-4 my-md-2">
                <span class="fw-bold" v-if="!phoneNumberItem.editModeVisible">
                    {{ phoneNumberItem.formatted_number }}
                </span>
                <form v-if="phoneNumberItem.editModeVisible" @submit.prevent="sendEditedPhoneNumberData">
                    <InputMask id="phone_number" name="phone_number" v-model="phoneNumberItemForm.number" :mask="phoneNumberItemForm.mask" :placeholder="phoneNumberItemForm.mask"/>
                    <input type="submit" class="btn btn-sm btn-primary border-0 rounded-start-0 fw-bold" :value="__('Modify')">
                </form>
            </div>
            <div class="col-6 text-end">
                <div class="d-grid d-md-flex align-items-md-end justify-content-md-end gap-2">
                    <button type="button" class="btn btn-primary" @click="toggleEditModeForItem">{{ phoneNumberItem.editModeVisible ? 'Cancel' : 'Edit' }}</button>

                    <button @click="sendDeletePhoneNumberRequest" type="button" class="btn btn-danger" v-if="!phoneNumberItem.editModeVisible">{{ __('Delete') }}</button>
                </div>
            </div>
        </div>
    </li>
</template>

