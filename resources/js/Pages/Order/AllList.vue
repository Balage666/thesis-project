<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';

import { Country, State } from 'country-state-city'

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import ListAccordion from '*vue-components/DataDisplay/ListAccordion.vue';
import ListAccordionItem from '*vue-components/DataDisplay/ListAccordionItem.vue';

const props = defineProps({
    orders: {
        type: [Array, Object],
        required: true
    }
})
const orderListShow = ref(
    props.orders.data
);

const searchForm = useForm({
    search: route().params.search || ''
})

const sendSearch = () => {
    router.get(route(route().current()), { search: searchForm.search })
}

const sendCleanSearch = () => {

    if (searchForm.search === '') {
        router.get(route(route().current()));
    }

}

const getCountryName = (isoCode) => {

    return Country.getCountryByCode(isoCode).name

}

const getStateName = (isoCode) => {

    return State.getStateByCode(isoCode).name;
}

const getTotalPrice = (array) => {


    return array.reduce((acc, curr) => parseFloat(acc) + parseFloat(curr.price), 0);

}

const sendDeleteRequest = (order) => {

    router.post(route('order-destroy', { order: order }));

}

console.log(orderListShow.value);

</script>
<template>
    <Head>
        <title>{{ __('All orders list') }}</title>
    </Head>

    <BodyLayout>
        <div class="container-fluid p-5 bg-info-subtle border-0">
            <div v-if="orderListShow.length == 0">
                <h3 class="p-5 text-center fw-bold fs-1" >{{ __('No orders found!') }}</h3>
            </div>

            <div v-else>

                <div class="row m-3 d-md-flex">

                    <div class="col-lg-6 col-md-6 col-12 mt-md-3 mt-0">

                        <form @submit.prevent="sendSearch" class="d-flex align-content-center justify-content-center" role="search">
                            <input @input="sendCleanSearch" v-model="searchForm.search" class="form-control border-0 rounded-end-0" type="search" :placeholder="__('Search')" aria-label="Search">
                            <button class="btn btn-primary border-2 rounded-start-0" type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                        </form>

                    </div>

                </div>

                <div class="row overflow-y-scroll" style="height: 650px;">
                    <div class="col-12">
                        <ListAccordion>
                            <ListAccordionItem v-for="order in orderListShow" :item="order">
                                <template v-slot:accordion-header>
                                    <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + order.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="col-12 col-md-6 col-lg-9 mt-1">
                                            <span class="fw-bold">{{ `${__('Order #')}${order.id}` }}</span>
                                        </div>
                                    </button>
                                </template>


                                <template v-slot:accordion-body>
                                    <div class="col-md-12 p-md-5 col-lg-12">
                                        <div class="card border-0 rounded-5">
                                            <div class="card-body">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="row">
                                                        <div class="col-12 col-xs-12 col-md-4 col-lg-3 mt-md-2">
                                                            <span>{{ __('Ordered by: ') }}</span>
                                                            <h4>{{ order.customer?.name || 'Guest' }}</h4>
                                                        </div>
                                                        <div class="col-12 col-xs-12 col-md-4 col-lg-6 mt-0 mt-md-3">
                                                            <span>{{ __('Ordered at: ') }}</span>
                                                            <h4 class="fw-bold">{{ order.created_at_human_readable }}</h4>
                                                        </div>
                                                        <div class="col-12 col-xs-12 col-md-4 col-lg-3 mt-md-3">
                                                            <button class="btn btn-danger" @click="sendDeleteRequest(order)"><i class="fa-solid fa-x"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 p-md-5 mt-3 mt-md-0 mt-lg-0">

                                        <div class="card mb-3">
                                            <div class="row g-0" style="height: 800px;">

                                                <div class="col-md-7 col-lg-8 p-3">

                                                    <h2 class="mb-3 text-center">{{ __(`Details of the order`) }}</h2>

                                                    <div class="row g-3">

                                                        <div class="col-12">
                                                            <h4>{{ __('Full name:') }}</h4>
                                                            <p class="lead fw-bold">{{ order.full_name }}</p>

                                                        </div>

                                                        <div class="col-12">
                                                            <h4>{{ __('Email:') }}</h4>
                                                            <p class="lead fw-bold">{{ order.email }}</p>

                                                        </div>

                                                    </div>

                                                    <hr class="">

                                                    <div class="row g-3">

                                                        <div class="col-12">
                                                            <h4>{{ __('Country:') }}</h4>
                                                            <p class="lead fw-bold">{{ getCountryName(order.country) }}</p>
                                                        </div>

                                                        <div class="col-12">
                                                            <h4>{{ __('State or region:') }}</h4>
                                                            <p class="lead fw-bold">{{ getStateName(order.state_or_region) }}</p>
                                                        </div>

                                                        <div class="col-12">
                                                            <h4>{{ __('Zip or Postal code:') }}</h4>
                                                            <p class="lead fw-bold">{{ order.postal_or_zip_code }}</p>
                                                        </div>

                                                    </div>

                                                    <hr>

                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <h4>{{ __('Phone number:') }}</h4>
                                                            <p class="lead fw-bold">{{ order.phone_number }}</p>
                                                        </div>

                                                        <div class="col-12">
                                                            <h4>{{ __('Status:') }}</h4>
                                                            <p class="lead fw-bold">{{ __(order.status) }}</p>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-5 col-lg-4 p-3 overflow-y-scroll" style="max-height: 800px;">

                                                    <h2 class="mb-3 text-center">{{ __(`Items of the order`) }}</h2>

                                                    <ul class="list-group mb-3">
                                                        <li class="list-group-item d-flex justify-content-between lh-sm p-3 bg-info" v-for="item in order.order_items">
                                                            <div>
                                                                <h6 class="my-0">{{ item.product_item.name }}</h6>
                                                            </div>
                                                            <span class="text-muted">{{ `€ ${item.price}` }}</span>
                                                            <span class="text-muted fw-bold">{{ `${item.amount}x` }}</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between bg-primary-subtle">
                                                            <span class="fw-bold">{{ __('Total') }}</span>
                                                            <strong>{{ `€ ${getTotalPrice(order.order_items).toFixed(2)}` }}</strong>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 col-md-6 p-md-5 mt-3 mt-md-0 mt-lg-0 col-lg-6">

                                        <div class="card mb-3 border-0">
                                            <div class="row g-0">
                                                <div class="d-grid gap-2">
                                                    <!-- <Link :href="route('product-show', { product: product })"  method="get" as="button" type="button" class="btn btn-lg btn-info shadow-sm fw-bold">{{ __('View Product') }}</Link> -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </template>
                            </ListAccordionItem>
                        </ListAccordion>
                    </div>
                </div>

            </div>
        </div>
    </BodyLayout>
</template>

