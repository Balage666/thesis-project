<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue'

import { Country, State, City } from 'country-state-city'

const emits = defineEmits(['submitted']);

const props = defineProps({
    visible: {
        type: Boolean,
        default: false
    },
});

const listOfCountries = Country.getAllCountries().map(({ flag, name, isoCode }) => ({ flag, name, isoCode }));
const listOfStatesByCountryIso = ref([])

const addressForm = useForm({
    countryIso: -1,
    regionIso : -1,
    postalZipCode: '',
    addressText: ''
});

watch(() => props.visible, (newValue, oldValue, options) => {
    if (newValue) {
        resetForm();
    }
});

const resetForm = () => {
    addressForm.countryIso = -1;
    addressForm.regionIso = -1;
    addressForm.postalZipCode = '';
    addressForm.addressText = ''
}

const getStatesByCountryIso = () => {
    listOfStatesByCountryIso.value = State.getStatesOfCountry(addressForm.countryIso);
    // console.log(listOfStatesByCountryIso);
}

const check = () => {
    console.log(addressForm.regionIso);
}

const sendFormData = () => {


    if (addressForm.regionIso == -1) {
        addressForm.regionIso = '-';
    }

    // console.log(addressForm);

    emits('submitted', addressForm);
}

</script>

<template>

    <form v-if="props.visible" @submit.prevent="sendFormData">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-flex justify-content-start" for="country">{{ __('Select country') }}</label>
                    <select
                        class="form-select form-select-lg formInputFieldBackground"
                        name="country"
                        id="country"
                        @change="getStatesByCountryIso"
                        v-model="addressForm.countryIso"
                    >
                        <option :value="-1">{{ __('--Select country--') }}</option>
                        <option
                            v-for="country in listOfCountries"
                            :value="country.isoCode"
                        >{{ __(country.name) }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-flex justify-content-start" for="region">{{ __("Select your state or region") }}</label>
                    <select
                        :disabled="listOfStatesByCountryIso.length == 0"
                        :required="listOfStatesByCountryIso.length != 0"
                        class="form-select form-select-lg formInputFieldBackground"
                        name="region"
                        id="region"
                        @change="check"
                        v-model="addressForm.regionIso"
                    >
                        <option :value="-1">{{ __('--Select state or region or country--') }}</option>
                        <option
                            v-for="state in listOfStatesByCountryIso"
                            :value="state.isoCode"
                        >{{ __(state.name) }}</option>
                    </select>

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-flex justify-content-start" for="postal_zip_code">{{ __("Type your zip or postal code") }}</label>
                    <input class="form-control form-control-lg formInputFieldBackground" type="text" name="postal_zip_code" id="postal_zip_code" v-model="addressForm.postalZipCode">
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <label class="form-label d-flex justify-content-start" for="address_text">{{ __("Type your address here") }}</label>
                    <input class="form-control form-control-lg formInputFieldBackground" type="text" name="address_text" id="address_text" v-model="addressForm.addressText">
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-grid gap-2 mt-4">
                    <button data-cy="add-address" type="submit" class="btn btn-primary shadow-sm fw-bold">{{ __('Add address') }}</button>
                </div>
            </div>
        </div>
    </form>
</template>

