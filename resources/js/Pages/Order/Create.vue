<script setup>

import { useForm, Link, usePage } from '@inertiajs/inertia-vue3';
import { ref, computed } from 'vue';

import { Country, State } from 'country-state-city'

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    cart: {
        type: [Array, Object],
        required: true
    }
})

const pageProps = ref(usePage().props.value);
const permissions = ref(pageProps.value.permissions);
const currentUser = ref(pageProps.value.active_session.user);

const cartShow = ref(props.cart);
const cartItems = ref(cartShow.value.cart_items)

const totalPrice = computed(() => cartItems.value.reduce((acc, curr) => parseFloat(acc) + parseFloat(curr.price), 0).toFixed(2));

const listOfCountries = Country.getAllCountries().map(({ flag, name, isoCode }) => ({ flag, name, isoCode }));
const listOfStatesByCountryIso = ref([])

const getCountryNameByIso = (isoCodeParam) => {

    return listOfCountries.find(({ isoCode }) => isoCode == isoCodeParam).name
}

const getStateNameByIsoCodeAndCountryIsoCode = (stateIsoCode, countryIsoCode) => {

    return State.getStateByCodeAndCountry(stateIsoCode, countryIsoCode).name;

}

const getStatesByCountryIso = (countryIsoCode) => {

    listOfStatesByCountryIso.value = State.getStatesOfCountry(countryIsoCode);
}

const createOrderForm = useForm({

    firstName: currentUser.value?.name.split(' ')[0] || '',
    lastName: currentUser.value?.name.split(' ')[1] || '',
    email:  currentUser.value?.email || '',
    phoneNumber: '',
    fullAddress: -1,
    address: '',
    country: -1,
    stateOrRegion: -1,
    zipOrPostalCode: '',

})

const setHiddenFields = () => {

    let addressValues = currentUser.value.addresses.find((address) => address.id == createOrderForm.fullAddress);

    createOrderForm.address = addressValues?.address_text || ''
    createOrderForm.country = addressValues?.country || -1
    createOrderForm.stateOrRegion = addressValues?.state_or_region || -1
    createOrderForm.zipOrPostalCode = addressValues?.postal_or_zip_code || ''

}

const createOrder = () => {

    router.post(route('order-store', { cart: cartShow.value }), createOrderForm);
}

</script>
<template>

    <Head>
        <title>{{ __('Create order') }}</title>
    </Head>

    <BodyLayout>
        <div class="container-fluid bg-info-subtle p-5">

            <div class="row g-5">
                <div class="col-md-5 col-lg-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-info fw-bold">{{ __('Your basket') }}</span>
                        <span class="badge bg-info rounded-pill">{{ `${cartItems.length}x` }}</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm" v-for="item in cartItems">
                            <div>
                                <h6 class="my-0">{{ item.product_item.name }}</h6>
                                <small class="text-muted">{{ item.product_item.category.name }}</small>
                            </div>
                            <span class="text-muted">{{ `€ ${item.price}` }}</span>
                            <span class="text-muted fw-bold">{{ `${item.amount}x` }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">{{ __('Total') }}</span>
                            <strong>{{ `€ ${totalPrice}` }}</strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">{{ __('Create order') }}</h4>
                    <form @submit.prevent="createOrder">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">{{ __('First name') }}</label>
                                <input v-model="createOrderForm.firstName" type="text" class="form-control formInputFieldBackground" id="firstName" :placeholder="__('Give your first name here')" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">{{ __('Last name') }}</label>
                                <input v-model="createOrderForm.lastName" type="text" class="form-control formInputFieldBackground" id="lastName" :placeholder="__('Give your last name here')" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input v-model="createOrderForm.email" type="email" class="form-control formInputFieldBackground" id="email" :placeholder="__('Enter your email')" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="phone" class="form-label">{{ __('Phone number') }}</label>
                                <select v-model="createOrderForm.phoneNumber" v-if="permissions.authenticated && currentUser.phone_numbers.length > 0" class="form-select formInputFieldBackground" id="phone" required>
                                    <option :value="''">{{ __('--Select your phone number--') }}</option>
                                    <option v-for="phone in currentUser.phone_numbers" :value="phone.number">{{ phone.number }}</option>
                                </select>
                                <input v-else v-model="createOrderForm.phoneNumber" type="tel" class="form-control formInputFieldBackground" id="phone" :placeholder="__('Enter your phone number')" required>
                            </div>


                            <div class="col-12" v-if="permissions.authenticated && currentUser.addresses.length > 0">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <select @change="setHiddenFields" v-model="createOrderForm.fullAddress" class="form-select formInputFieldBackground" id="address" required>
                                    <option :value="-1">{{ __('--Select your address--') }}</option>
                                    <option v-for="address in currentUser.addresses" :value="address.id">{{ `${getCountryNameByIso(address.country)}, ${getStateNameByIsoCodeAndCountryIsoCode(address.state_or_region, address.country)}, ${address.postal_or_zip_code}, ${address.address_text}` }}</option>
                                </select>
                            </div>

                            <div class="row no-padding g-3" v-else>
                                <div class="col-12">
                                    <label for="address" class="form-label">{{ __('Address') }}</label>
                                    <input v-model="createOrderForm.address" type="text" class="form-control formInputFieldBackground" id="address" :placeholder="__('Enter your address text')" required>
                                </div>

                                <div class="col-md-5">
                                    <label for="country" class="form-label">{{ __('Country') }}</label>
                                    <select v-model="createOrderForm.country" @change="getStatesByCountryIso(createOrderForm.country)" class="form-select formInputFieldBackground" id="country" required>
                                        <option :value="-1">{{ __('--Select country--') }}</option>
                                        <option
                                            v-for="country in listOfCountries"
                                            :value="country.isoCode"
                                        >{{ __(country.name) }}</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="state" class="form-label">{{ __('State or region') }}</label>
                                    <select
                                        class="form-select formInputFieldBackground"
                                        id="state"
                                        :required="listOfStatesByCountryIso.length != 0"
                                        :disabled="listOfStatesByCountryIso.length == 0"
                                        v-model="createOrderForm.stateOrRegion"
                                    >
                                        <option :value="-1">{{ __('--Select state or region or country--') }}</option>
                                        <option
                                            v-for="state in listOfStatesByCountryIso"
                                            :value="state.isoCode"
                                        >{{ __(state.name) }}</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="zip" class="form-label">{{ __('Zip or Postal code') }}</label>
                                    <input v-model="createOrderForm.zipOrPostalCode" type="text" class="form-control formInputFieldBackground" id="zip" :placeholder="__('Type your zip or postal code')" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="col-12 mb-3">
                            <div class="row text-center">

                                <div class="col-6">
                                    <Link :href="route('basket-list')" as="button" type="button" class="btn btn-warning btn-lg">{{ __('Back to basket') }}</Link>
                                </div>

                                <div class="col-6">
                                    <button class="btn btn-primary btn-lg" type="submit">{{ __('Proceed') }}</button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </BodyLayout>
</template>
