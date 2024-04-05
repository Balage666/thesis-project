<script setup>

import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue';

import { Modal } from 'bootstrap';


import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import Pagination from '*vue-components/DataDisplay/Pagination.vue';
import AddNewCategoryModal from '*vue-components/Input/AddNewCategoryModal.vue';

const props = defineProps({
    categories: {
        type: [Array, Object]
    }
});

const newCategoryModal = ref(null);
const confirmationModal = ref(null)

const currentUser = ref(usePage().props.value.active_session.user);

onMounted(() => {

    newCategoryModal.value = new Modal(document.getElementById('addCategory'));
});


const sendDeleteRequest = (category) => {

    router.post(route('category-delete', { category: category }));

}

const sendStoreRequest = (payload) => {

    router.post(route('category-store'), payload);
}

const openNewCategoryModal = () => {

    newCategoryModal.value.show();

}

const closeNewCategoryModal = () => {

    newCategoryModal.value.hide();

}

</script>
<template>
    <Head>
        <title>{{ __('Category List') }}</title>
    </Head>

    <BodyLayout>

        <AddNewCategoryModal
            :id="'addCategory'"
            @onModalClose="closeNewCategoryModal"
            @categoryAdded="sendStoreRequest"
        />

        <div class="container-fluid p-5 bg-info-subtle border-0">

            <div v-if="props.categories.data.length == 0">
                <div class="row text-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <h3 class="mt-2">{{ __('There are no categories added!') }}</h3>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <button @click="openNewCategoryModal" class="btn btn-lg btn-primary"><i class="fa-solid fa-layer-group"></i>{{ __('Add new Category') }}</button>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="row m-3 d-flex text-center">

                    <div class="col-12 col-md-6 col-lg-6 mt-md-0 mt-lg-0 mb-3">
                        <button @click="openNewCategoryModal" class="btn btn-lg btn-primary"><i class="fa-solid fa-layer-group"></i>{{ __('Add new Category') }}</button>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6">
                        <Pagination :pagination="props.categories.meta"/>
                    </div>


                </div>

                <div class="row m-3">
                    <div class="col-12">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item authFormCardBackground bg-gradient" v-for="category in props.categories.data" :key="category.id">

                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed bg-info bg-gradient" type="button" data-bs-toggle="collapse" :data-bs-target="'#open' + category.id" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="col-12 col-md-6 col-lg-9 mt-1">
                                            <span class="fw-bold">{{ category.name }}</span>
                                        </div>
                                    </button>
                                </h2>

                                <div :id="'open' + category.id" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="container-fluid accordion-body">

                                        <div class="row">
                                            <div class="col-md-12 p-md-5 col-lg-12">
                                                <div class="card border-0 rounded-5">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-column text-center">
                                                            <div class="row">
                                                                <div class="col-12 col-xs-12 col-md-4 col-lg-3 mt-md-2">
                                                                    <span>{{ __('Created by: ') }}</span>
                                                                    <h4>{{ category.user.name }}</h4>
                                                                </div>
                                                                <div class="col-12 col-xs-12 col-md-4 col-lg-6 mt-0 mt-md-3">
                                                                    <h4 class="fw-bold">{{ category.name }}</h4>
                                                                </div>
                                                                <div class="col-12 col-xs-12 col-md-4 col-lg-3 mt-md-2">
                                                                    <button v-if="category.user.id === currentUser.id || currentUser.roles.some(({name}) => name === 'Admin')" class="btn btn-danger" @click="sendDeleteRequest(category)"><i class="fa-solid fa-x"></i></button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-12 p-md-5 col-lg-12">

                                                <div class="my-2 my-lg-0">
                                                    <h2 class="text-center mb-5">{{ __('Products in this category') }}</h2>
                                                    <div v-if="category.products.length == 0">
                                                        <h4 class="text-center">{{ __('Such emptiness!') }}</h4>
                                                    </div>
                                                    <div v-else>
                                                        <ul class="list-group border-0 rounded-5">
                                                            <li class="list-group-item p-3 text-center" v-for="product in category.products">
                                                                <div class="row mt-3">
                                                                    <div class="col-12 col-md-6 col-lg-3">
                                                                        <img :src="product.preview_image" class="border-0 rounded-3" style="width: 25%">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 col-lg-9 mt-2">
                                                                        <span class="fw-bold">
                                                                            {{ __(product.name) }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </BodyLayout>
</template>
