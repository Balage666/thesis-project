<script setup>

import { useForm } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
import countries from 'countries-phone-masks/src/index'
import InputMask from 'primevue/inputmask';

const props = defineProps({
    visible: {
        type: Boolean,
        default: false
    }
});
const countryIso = ref(countries[0].iso);
const countryCode = ref(countries[0].code);

const phoneNumberForm = useForm({
    number: '',
    mask: countries[0].mask.replaceAll('#', '9'),
})

console.log(countries.filter(({ code, mask }) => code === '+1').map( c => c.mask ));

const setMask = () => {
    let foundMask = countries.find(({ iso }) => iso === countryIso.value).mask;
    phoneNumberForm.mask = foundMask;
    if (Array.isArray(foundMask)) {
        phoneNumberForm.mask = foundMask[0]
    }
    phoneNumberForm.mask = phoneNumberForm.mask.replaceAll('#', '9');
}

const sendFormData = () => {

    phoneNumberForm.number = phoneNumberForm.number.replace('(', '').replace(')', '').replaceAll('-', '')
    phoneNumberForm.mask = `${countries.find(({ iso }) => iso === countryIso.value).code} ${phoneNumberForm.mask}`

    // console.log(phoneNumberForm.number, phoneNumberForm.mask);

    resetForm();
}

const resetForm = () => {
    phoneNumberForm.countryIso = countries[0].iso
    phoneNumberForm.number = '';
    phoneNumberForm.mask = countries[0].mask.replaceAll('#', '9');
}


</script>

<template>

    <form v-if="props.visible" @submit.prevent="sendFormData">

        <label class="form-label d-flex justify-content-start" for="country">{{ __("Select country code") }}</label>
        <select class="form-select form-select-lg formInputFieldBackground" name="country" id="country" v-model="countryIso" @change="setMask">
            <option v-for="country in countries" :value="country.iso" >{{ __(country.name) }} ({{ country.code }})</option>
        </select>

        <label class="form-label d-flex justify-content-start mt-2" for="phone_mask">{{ __("Type your phone number here") }}</label>
        <InputMask
            class="form-control form-control-lg formInputFieldBackground"
            id="phone_mask"
            name="phone_mask"
            v-model="phoneNumberForm.number"
            :mask="phoneNumberForm.mask"
            :placeholder="phoneNumberForm.mask"
        />

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary shadow-sm fw-bold">{{ __('Add phone number') }}</button>
        </div>

    </form>

</template>
