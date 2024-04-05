<script setup>

import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

import { Country, State } from 'country-state-city'

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    order: {
        type: [Object, Array],
        required: true
    }
})

const orderShow = ref(props.order.data);

const totalPrice = computed(() => orderShow.value.order_items.reduce((acc, curr) => parseFloat(acc) + parseFloat(curr.price), 0).toFixed(2))

const getCountryName = (isoCode) => {

    return Country.getCountryByCode(isoCode).name

}

const getStateName = (isoCode) => {

    return State.getStateByCode(isoCode).name;
}

const sendDeleteRequest = (order) => {

    router.post(route('order-destroy', { order: order }));

}

</script>
<template>

    <Head>
        <title>{{ __('Order details') }}</title>
    </Head>

    <BodyLayout>
        <div class="container-fluid bg-info-subtle p-5">
            <div class="row g-5">

                <div class="col-md-7 col-lg-8">

                    <h2 class="mb-3 text-center">{{ __('Order details') }}</h2>

                    <div class="row g-3">

                        <div class="col-md-6 col-sm-12">
                            <h4>{{ __('Full name:') }}</h4>
                            <p class="lead fw-bold">{{ orderShow.full_name }}</p>

                        </div>

                        <div class="col-md-6 col-sm-12">
                            <h4>{{ __('Email:') }}</h4>
                            <p class="lead fw-bold">{{ orderShow.email }}</p>

                        </div>

                    </div>

                    <hr>

                    <div class="row g-3">

                        <div class="col-md-5">
                            <h4>{{ __('Country:') }}</h4>
                            <p class="lead fw-bold">{{ getCountryName(orderShow.country) }}</p>
                        </div>

                        <div class="col-md-4">
                            <h4>{{ __('State or region:') }}</h4>
                            <p class="lead fw-bold">{{ getStateName(orderShow.state_or_region) }}</p>
                        </div>

                        <div class="col-md-3">
                            <h4>{{ __('Zip or Postal code:') }}</h4>
                            <p class="lead fw-bold">{{ orderShow.postal_or_zip_code }}</p>
                        </div>

                    </div>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <h4>{{ __('Phone number:') }}</h4>
                            <p class="lead fw-bold">{{ orderShow.phone_number }}</p>
                        </div>

                        <div class="col-md-6">
                            <h4>{{ __('Status:') }}</h4>
                            <p class="lead fw-bold">{{ __(orderShow.status) }}</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="col-6 text-start ">
                                    <h4>{{ `${ __('Ordered at:')} ${orderShow.created_at_human_readable}` }}</h4>
                                </div>

                                <div class="col-6 text-end">
                                    <button @click="sendDeleteRequest(orderShow)" type="button" class="btn btn-danger">{{ __('Delete') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm p-3" v-for="item in orderShow.order_items">
                            <div>
                                <h6 class="my-0">{{ item.product_item.name }}</h6>
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


            </div>
        </div>
    </BodyLayout>

</template>

