<script setup>

import { Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed } from 'vue';
//TODO: Design lang switcher tommorrow
import LanguageSwitcher from '*vue-components/Language/LanguageSwitcher.vue';
import ProductCarousel from '*vue-components/DataDisplay/Product/ProductCarousel.vue';
import Tiptap from '*vue-components/Input/TipTap.vue'
import ToastStack from '*vue-components/Notification/ToastStack.vue';


const props = defineProps({
    products: {
        type: [Array, Object]
    }
})


const randomProduct = computed(() => {
    const random = Math.floor(Math.random() * props.products.data.length)
    return props.products.data[random];
})


const carouselProducts = ref(props.products.data);

</script>


<template>
    <div>
        <h1>New Feature test</h1>

        <ToastStack :notifications="$page.props.errors"/>

        <pre>{{ $page.props }}</pre>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{ props.products.data[0].name }}</h5>
                <p class="card-text">{{ props.products.data[0].shortened_description }}</p>
                <p class="card-text">{{ props.products.data[0].price }}</p>
                <Link :href="route('add-to-basket', { product: props.products.data[0] })" method="post" as="button" type="button" class="btn btn-primary">Add to Basket</Link>
                <Link :href="route('remove-from-basket', { product: props.products.data[0] })" method="post" as="button" type="button" class="btn btn-danger">Remove from Basket</Link>
            </div>
        </div>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{ props.products.data[2].name }}</h5>
                <p class="card-text">{{ props.products.data[2].shortened_description }}</p>
                <p class="card-text">{{ props.products.data[2].price }}</p>
                <Link :href="route('add-to-basket', { product: props.products.data[2] })" method="post" as="button" type="button" class="btn btn-primary">Add to Basket</Link>
                <Link :href="route('remove-from-basket', { product: props.products.data[2] })" method="post" as="button" type="button" class="btn btn-danger">Remove from Basket</Link>
            </div>
        </div>

        <!-- <div>
            <ProductCarousel class="d-none d-md-none d-lg-flex" :carouselId="'large'" :products="carouselProducts" :visiblePerSlide="3"/>
        </div>

        <div>
            <ProductCarousel class="d-none d-md-flex d-sm-none d-lg-none" :carouselId="'mid'" :products="carouselProducts" :visiblePerSlide="2"/>
        </div>

        <div>
            <ProductCarousel class="d-flex d-md-none d-sm-flex d-lg-none" :carouesleId="'small'" :products="carouselProducts" :visiblePerSlide="1"/>
        </div> -->

        <!-- <div class="alert alert-danger" v-if="$page.props.errors" v-for="error in $page.props.errors">{{ __(error) }}</div> -->


        <!-- <LanguageSwitcher/> -->

        <!-- <button type="button" class="btn btn-primary" @click="showDialog">
            Launch static backdrop modal
        </button> -->

        <!-- <FileUploadDialog :id="'fileUpload'" @onModalClose="closeDialog" /> -->

        <!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FileUpload
                            name="demo"
                            accept="image/*"
                            :maxFileSize="1000000"
                        >
                            <template #chooseicon>
                                <i class="fa-solid fa-plus"></i>
                            </template>

                            <template #uploadicon>
                                <i class="fa-solid fa-upload"></i>
                            </template>

                            <template #cancelicon>
                                <i class="fa-solid fa-xmark"></i>
                            </template>

                            <template #empty>
                                <p>Drag and drop files to here to upload.</p>
                            </template>
                        </FileUpload>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> -->


    </div>



</template>

<style scoped>


</style>

