<script setup>

import { usePage, useForm, Link } from '@inertiajs/inertia-vue3';
import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

import Galleria from 'primevue/galleria';
import "primevue/resources/themes/lara-light-cyan/theme.css";

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';
import RateProduct from '*vue-components/Input/RateProduct.vue';

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

const currentUserRating = computed(() => currentUser.value.product_ratings.find((r) => r.product_id == productShow.value.id)?.rating);

const stars = computed(() => Math.round(averageProductRating.value));

console.log(currentUserRating.value || 0);



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

</script>

<template>

    <Head>
        <title>{{ __('Show product') }}</title>
    </Head>

    <BodyLayout>

        <pre>{{ permissions }}</pre>

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
                    <h1>{{ productShow.name }}</h1>

                    <div>
                        <div>
                            <span v-if="productRatingsCount == 0" v-for="(s,i) in 5" class="fa-regular fa-star"></span>
                            <span v-else v-for="s in stars" class="fa-solid fa-star"></span>
                        </div>
                        <span class="text-muted">{{ productRatingsCount }} ratings</span>
                        <RateProduct
                            :alreadyRated="checkAlreadyRated(currentUser, productShow)"
                            @onRated="sendProductRatingRequest"
                            :product="productShow"
                            :ratedAs="currentUserRating || 0">
                            <template #onicon>
                                <span class="fa-solid fa-star"></span>
                            </template>
                            <template #officon>
                                <span class="fa-regular fa-star"></span>
                            </template>
                        </RateProduct>
                    </div>

                    <p class="lead">{{ productShow.description }}</p>

                    <div class="row">

                        <div class="col-6">

                            <Link :href="route('add-to-basket', { product: productShow })" method="post" as="button" type="button" class="btn btn-lg btn-secondary"> <i class="fa-solid fa-basket-shopping"></i> Add to Basket</Link>

                        </div>

                        <div class="col-6">

                            <!--TODO: Implement Add to favorite button-->
                            <Link href="#" method="post" as="button" type="button" class="btn btn-lg btn-outline-danger"> <i class="fa-regular fa-heart"></i> Mark as favorite</Link>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <h3>Comments</h3>
            </div>

            <hr>

            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="card border">
                        <div class="card-body p-4">
                            <div v-if="productComments.length == 0">
                                <h3>There are no comments!</h3>
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
                                                <i class="fa-solid fa-x"></i> Delete
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-outline mb-4">
                                <div class="form-floating">
                                    <textarea v-model="commentForm.comment" class="form-control" placeholder="Leave a comment here" id="commentInput" style="height: 120px"></textarea>
                                    <label for="commentInput">{{ __('New comment') }}</label>
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
