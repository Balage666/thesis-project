<script setup>

import { usePage, useForm, Link } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';
import { ref, computed, reactive, onMounted } from 'vue';
import { Modal } from 'bootstrap';

import Galleria from 'primevue/galleria';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import TextArea from 'primevue/textarea';

import "primevue/resources/themes/lara-light-cyan/theme.css";

import editProductModeObj from '*js-shared/edit-product-mode-obj';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import RateProduct from '*vue-components/Input/RateProduct.vue';
import ProductImageManagerModal from '*vue-components/Input/ProductImageManagerModal.vue';

const props = defineProps({
    product: {
        type: Object
    },
    productsInSameCategory: {
        type: [Array, Object]
    }
});

const pageProps = ref(usePage().props.value);
const currentUser = ref(pageProps.value.active_session.user);
const permissions = ref(pageProps.value.permissions);

const carouselProducts = computed(() => props.productsInSameCategory.data);
const productShow = computed(() => props.product.data)
const productImages = computed(() => productShow.value.images.map((img) => img.product_picture))
const productComments = computed(() => productShow.value.comments)
const productRatingsCount = computed(() => productShow.value.count_of_ratings);
const averageProductRating = computed(() => productShow.value.avg_of_ratings);

const currentUserRating = computed(() => currentUser.value?.product_ratings.find((r) => r.product_id == productShow.value.id));

const stars = computed(() => Math.round(averageProductRating.value));

console.log(currentUserRating.value || 0);

console.log(productShow.value);

const EditMode = reactive(editProductModeObj);

console.log(Object.entries(EditMode).every(m => m[1] == false));

const toggleEditMode = () => {

    for (const key in EditMode) {
        if (Object.hasOwnProperty.call(EditMode, key)) {
            EditMode[key] = !EditMode[key]
        }
    }

}

const editNameForm = useForm({
    name: productShow.value.name
})

const editDescriptionForm = useForm({
    description: productShow.value.description
})

const changePriceForm = useForm({

    price: productShow.value.price

});

const changeStockValueForm = useForm({

    stock: productShow.value.stock

})

const sendModifiedNameData = () => {

    router.post(route('product-name-change', { product: productShow.value }), editNameForm);

}

const sendModifiedDescriptionData = () => {

    router.post(route('product-description-change', { product: productShow.value }), editDescriptionForm);

}

const sendModifiedPriceData = () => {

    router.post(route('product-price-change', { product: productShow.value }), changePriceForm);

}

const sendModifiedStockData = () => {

    router.post(route('product-stock-change', { product: productShow.value }), changeStockValueForm);

}


const checkAlreadyRated = (user, product) => {
    return user?.product_ratings.some((r) => r.product_id == product.id);
}

const commentForm = useForm({
    comment: ''
});

const sendAddCommentRequest = () => {

    console.log(commentForm.comment);

    router.post(route('comment-add', { product: productShow.value }), commentForm)

}

const sendDeleteCommentRequest = (comment) => {

    console.log(comment);

    router.post(route('comment-destroy', { comment: comment }));

}

const sendProductRatingRequest = (payload) => {

    console.log(payload);


    router.post(route('rate-add', { product: payload.product }), { rating: payload.rating });
}

const sendDeleteRatingRequest = (payload) => {

    console.log(currentUserRating.value);

    const data = {

        rating: currentUserRating.value
    }

    router.post(route('rate-destroy', { product: productShow.value }), data);

}

const sendDeleteProductPictureRequest = (payload) => {

    const data = {

        images: payload
    };

    router.post(route('product-pictures-delete', { product: productShow.value }), data)

}

const sendUploadProductPicturesRequest = (payload) => {

    const data = {
        images: payload.images
    }

    router.post(route('product-pictures-upload', { product: productShow.value }), data);

    console.log(payload);
}

const prouductImageModal = ref(null);

onMounted(() => {
    prouductImageModal.value = new Modal(document.getElementById('productImagesUpload'));
})

const showDialog = () => {

    prouductImageModal.value.show();

}

const closeDialog = () => {

    prouductImageModal.value.hide();
}

const addToFavorites = (user, product) => {

    router.post(route('add-to-favorites', { user: user, product: product }));
}

const removeFromFavorites = (user, product) => {

    router.post(route('remove-from-favorites', { user: user, product: product }))

}

</script>

<template>

    <Head>
        <title>{{ __('Show product - :name', productShow) }}</title>
    </Head>

    <BodyLayout>

        <ProductImageManagerModal
            :id="'productImagesUpload'"
            :images="productShow.images"
            :product="productShow"
            @onModalClose="closeDialog"
            @onItemsDelete="sendDeleteProductPictureRequest"
            @onUpload="sendUploadProductPicturesRequest"
        />

        <div class="card p-5 container-fluid bg-info-subtle border-0">

            <div class="row g-5 d-flex align-items-md-center justify-content-md-center align-items-lg-center justify-content-lg-center">
                <div class="col-12 col-md-6 col-lg-5">

                    <Galleria :value="productImages" :numVisible="5" containerStyle="max-width: 35rem; border-style:solid; border-width: 5px; border-color: white"
                        :showThumbnails="false" :showIndicators="true" :changeItemOnIndicatorHover="true">
                        <template #item="slotProps">
                            <img :src="slotProps.item" :alt="productShow.name" style="width: 100%; display: block;" />
                        </template>
                    </Galleria>
                </div>

                <div class="col-12 col-md-6 col-lg-7">

                    <div class="d-flex gap-3" v-if="permissions.has_admin_role || (permissions.has_seller_role && productShow.distributor.id == currentUser.id)">

                        <div>
                            <button @click="toggleEditMode" class="btn btn-lg btn-info mb-2"> <i class="fa-solid fa-screwdriver-wrench fa-sm"></i> {{ Object.entries(EditMode).every(m => m[1] == true) ? __('Cancel') : __('Edit Mode') }}</button>
                        </div>

                        <div>
                            <Link :href="route('product-edit', { product: productShow })" class="btn btn-lg btn-info" as="button" type="button"> <i class="fa-solid fa-wrench"></i> {{ __("Legacy Editor") }}</Link>
                        </div>

                        <div v-show="EditMode.changePicturesButtonVisible">
                            <button @click="showDialog" class="btn btn-lg btn-info mb-2"> <i class="fa-regular fa-images"></i> {{ __('Change Pictures') }}</button>
                        </div>

                    </div>

                    <h1 v-show="!EditMode.editNameFormVisible">{{ productShow.name }}</h1>
                    <div class="mt-3 mb-3">
                        <form @submit.prevent="sendModifiedNameData" v-show="EditMode.editNameFormVisible">
                            <div class="d-flex gap-2">
                                <FloatLabel>
                                    <InputText id="name-input" v-model="editNameForm.name"/>
                                    <label for="name-input">{{ __('Name') }}</label>
                                </FloatLabel>

                                <button :disabled="!editNameForm.isDirty" type="submit" class="btn btn-primary btn-sm">{{ __('Modify') }}</button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <div>
                            <span v-if="productRatingsCount == 0" v-for="(s,i) in 5" class="fa-regular fa-star"></span>
                            <span v-else v-for="s in stars" class="fa-solid fa-star"></span>
                        </div>
                        <span class="text-muted">{{ productRatingsCount }} {{ __('ratings') }}</span>
                        <RateProduct
                            v-if="permissions.authenticated && productShow.distributor.id != currentUser?.id"
                            :alreadyRated="checkAlreadyRated(currentUser, productShow)"
                            @onRated="sendProductRatingRequest"
                            @onRatingDelete="sendDeleteRatingRequest"
                            :product="productShow"
                            :ratedAs="currentUserRating?.rating || 0">
                            <template #onicon>
                                <span class="fa-solid fa-star"></span>
                            </template>
                            <template #officon>
                                <span class="fa-regular fa-star"></span>
                            </template>
                        </RateProduct>
                    </div>

                    <p v-show="!EditMode.editDescriptionFormVisible" class="lead">{{ productShow.description }}</p>
                    <div class="mt-3 mb-3">
                        <form @submit.prevent="sendModifiedDescriptionData" v-show="EditMode.editDescriptionFormVisible">

                            <div class="d-flex gap-2">
                                <FloatLabel>
                                    <TextArea id="desc-input" v-model="editDescriptionForm.description" rows="2" cols="50" />
                                    <label for="desc-input">{{ __('Description') }}</label>
                                </FloatLabel>

                                <button :disabled="!editDescriptionForm.isDirty" type="submit" class="btn btn-primary btn-sm">{{ __('Modify') }}</button>
                            </div>
                        </form>
                    </div>


                    <h3 class="mb-3" v-show="Object.entries(EditMode).every(m => m[1] == false)">
                        <span class="text-muted">{{ __('Price') }}: </span> {{ `€ ${productShow.price}` }}
                        <span class="text-black-50"> • </span>
                        <span class="text-muted">{{ __('In Stock:') }}</span> {{ productShow.stock }}
                    </h3>

                    <div v-show="EditMode.changePriceFormVisible && EditMode.changeStockFormVisible">

                        <div class="mb-4">
                            <form @submit.prevent="sendModifiedPriceData">
                                <div class="d-flex gap-2">

                                    <FloatLabel>
                                        <InputNumber id="price-input" v-model="changePriceForm.price" variant="filled" :minFractionDigits="2" :max="600000" />
                                        <label for="price-input">{{ __('Price') }}</label>
                                    </FloatLabel>

                                    <button :disabled="!changePriceForm.isDirty" type="submit" class="btn btn-primary btn-sm">{{ __('Modify') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="mb-3">

                            <form @submit.prevent="sendModifiedStockData">
                                <div class="d-flex gap-2">
                                    <FloatLabel>
                                        <InputNumber id="stock-input" v-model="changeStockValueForm.stock" :max="9999" />
                                        <label for="stock-input">{{ __('Stock') }}</label>
                                    </FloatLabel>

                                    <button :disabled="!changeStockValueForm.isDirty" type="submit" class="btn btn-sm btn-primary">{{ __('Modify') }}</button>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="d-flex gap-3 text-center" v-if="currentUser?.id != productShow.distributor.id">

                        <div>

                            <Link :href="route('add-to-basket', { product: productShow })" method="post" as="button" type="button" class="btn btn-lg btn-info"> <i class="fa-solid fa-basket-shopping"></i> Add to Basket</Link>

                        </div>

                        <div>

                            <button v-if="permissions.authenticated && !currentUser?.favorites.find(f => f.product_id == productShow.id)" @click="addToFavorites(currentUser, productShow)" class="btn btn-lg btn-outline-danger"> <i class="fa-regular fa-heart"></i> Mark as favorite</button>
                            <button v-if="permissions.authenticated && currentUser?.favorites.find(f => f.product_id == productShow.id)" @click="removeFromFavorites(currentUser, productShow)" class="btn btn-lg btn-danger"> <i class="fa-solid fa-heart"></i> Remove from favorites</button>
                        </div>
                    </div>

                    <h3 class="mt-2 mb-3" v-show="permissions.has_admin_role">
                        <span class="text-muted">{{ __('Created by: ') }}</span> {{ productShow.distributor.name }}
                    </h3>
                </div>
            </div>

            <div class="row mt-3">
                <h3>{{ __('Comments') }}</h3>
            </div>

            <hr>

            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="card border">
                        <div class="card-body p-4">
                            <div v-if="productComments.length == 0">
                                <h3>{{ __('There are no comments!') }}</h3>
                            </div>
                            <div v-else class="card mb-4" v-for="comment in productComments">
                                <div class="card-body">
                                    <p class="lead">{{ comment.comment }}</p>

                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            <img class="rounded-circle" :src="comment.commenter.profile_picture" :title="comment.commenter.name" :alt="comment.commenter.name" width="50"
                                            height="50" />
                                            <p class="fs-6 mb-0 ms-2">{{ comment.commenter.name }}</p>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <button @click="sendDeleteCommentRequest(comment)" v-if="permissions.has_admin_role || currentUser?.id === comment.commenter.id" class="btn btn-lg btn-danger">
                                                <i class="fa-solid fa-x"></i> {{ __('Delete') }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-outline mb-4">
                                <div class="form-floating">
                                    <textarea v-model="commentForm.comment" class="form-control" placeholder="Leave a comment here" id="commentInput" style="height: 120px"></textarea>
                                    <label for="commentInput" class="text-muted">{{ __('New comment') }}</label>
                                </div>
                            </div>
                            <div class="form-outline text-end">
                                <button @click="sendAddCommentRequest" type="submit" class="btn btn-lg btn-secondary">
                                    <i class="fa-solid fa-right-to-bracket"></i> {{ __('Send') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </BodyLayout>
</template>
