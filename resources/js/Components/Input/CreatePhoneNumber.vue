<script setup>

import { useForm, router } from '@inertiajs/inertia-vue3';
import { ref, watch, reactive } from 'vue';
import countries from 'countries-phone-masks/src/index'
import InputMask from 'primevue/inputmask';

const emits = defineEmits(['submitted'])

const props = defineProps({
    visible: {
        type: Boolean,
        default: false
    },
});

// console.log(props.user);
const phoneNumberForm = useForm({
    countryIso: countries[0].iso,
    number: '',
    mask: countries[0].mask.replaceAll('#', '9'),
})

//TODO: Make it reusable with Mixins
watch(() => props.visible, (newValue, oldValue, options) => {
    if (newValue) {
        resetForm()
    }
})

const setMask = () => {
    let foundMask = countries.find(({ iso }) => iso === phoneNumberForm.countryIso).mask;
    phoneNumberForm.mask = foundMask;
    if (Array.isArray(foundMask)) {
        phoneNumberForm.mask = foundMask[0]
    }
    phoneNumberForm.mask = phoneNumberForm.mask.replaceAll('#', '9');
}

const sendFormData = () => {

    phoneNumberForm.number = phoneNumberForm.number.replace('(', '').replace(')', '').replaceAll('-', '')
    phoneNumberForm.mask = `${countries.find(({ iso }) => iso === phoneNumberForm.countryIso).code} ${phoneNumberForm.mask}`

    console.log(phoneNumberForm);

    // router.post(route('phone-number-add', { user: props.user }), phoneNumberForm);

    emits('submitted', phoneNumberForm);

    // resetForm();
}

const resetForm = () => {
    phoneNumberForm.countryIso = countries[0].iso
    phoneNumberForm.number = '';
    phoneNumberForm.mask = countries[0].mask.replaceAll('#', '9');
}

</script>

<template>

    <form v-if="props.visible" @submit.prevent="sendFormData">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-flex justify-content-start" for="country">{{ __("Select country code") }}</label>
                    <select class="form-select form-select-lg formInputFieldBackground" name="country" id="country" v-model="phoneNumberForm.countryIso" @change="setMask">
                        <option v-for="country in countries" :value="country.iso" >{{ __(country.name) }} ({{ country.code }})</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-flex justify-content-start" for="phone_mask">{{ __("Type phone number") }}</label>
                    <InputMask
                        class="form-control form-control-lg formInputFieldBackground"
                        id="phone_mask"
                        name="phone_mask"
                        v-model="phoneNumberForm.number"
                        :mask="phoneNumberForm.mask"
                        :placeholder="phoneNumberForm.mask"
                    />
                </div>
                <div class="row">
                    <div class="col-12 d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm fw-bold">{{ __('Add phone number') }}</button>
                    </div>
                </div>
            </div>
        </div>



    </form>

</template>
