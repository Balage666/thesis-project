<script setup>

import { FormKit } from '@formkit/vue';
import { useForm, router } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';
import { useForSelect } from '*vue-composables/ForSelectComposable';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    categories: {
        type: [Array, Object]
    }
});

const { selectOptions } = useForSelect(props.categories.data)

const createProductForm = useForm({
    categoryId: '',
    name: '',
    description: '',
    price: 50.00,
    stock: 1,
    images: []
})

const sendFormData = () => {

    createProductForm.post(route('product-store'));
}

</script>

<style scoped>

</style>

<template>

    <Head>
        <title>{{ __('Create Product') }}</title>
    </Head>

    <BodyLayout>

        <div class="my-5 py-5">
            <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

                <FormKit type="multi-step" tab-style="progress" :hide-progress-labels="true" :allow-incomplete="false" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center mb-5">

                    <FormKit type="step" :name="__('productCategory')">

                        <h3 class="mb-3 mx-5 text-center"> {{ __("Choose a category for your product!") }} </h3>
                        <FormKit
                            id="category"
                            type="select"
                            name="category"
                            v-model="createProductForm.categoryId"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :options="selectOptions"
                            :label="__('Product category')"
                            :validation="[['required']]"
                            validation-visibility="live"
                            :placeholder="__('--Select category--')"
                            :validation-messages="{
                                required: __('Product category is required')
                            }"
                        />


                        <template #stepNext="{ handlers, node }">

                            <FormKit
                                type="button"
                                @click="handlers.incrementStep(1)()"
                                :label="__('Continue')"
                                data-next="true"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-success shadow-sm fw-bold"
                            />

                        </template>
                    </FormKit>

                    <FormKit type="step" :name="__('productDetails')">
                        <h3 class="mb-2 mx-auto text-center"> {{ __("Create a product with filling the form below!") }} </h3>

                        <FormKit
                            id="name"
                            type="text"
                            name="name"
                            v-model="createProductForm.name"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__('Product name')"
                            :validation="[['required']]"
                            validation-visibility="live"
                            :validation-messages="{
                                required: __('Product name is required')
                            }"

                        />


                        <FormKit
                            id="description"
                            type="textarea"
                            name="description"
                            v-model="createProductForm.description"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__('Product description')"
                        />

                        <FormKit type="group">
                            <FormKit
                                id="price"
                                type="number"
                                step="any"
                                name="price"
                                v-model="createProductForm.price"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4"
                                input-class="form-control form-control-lg"
                                :label="__('Product price')"
                                :validation="[['required'], ['min', 5.00], ['max', 100.00]]"
                                validaton-visibility="live"
                                number="float"
                                :validation-messages="{
                                    required: __('Product price is required'),
                                    min: __('Product price must be at least 5.'),
                                    max: __('Product price must be no more than 100.')
                                }"
                            />

                            <FormKit
                                id="stock"
                                type="number"
                                name="stock"
                                v-model="createProductForm.stock"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4"
                                input-class="form-control form-control-lg"
                                :label="__('Product stock')"
                                :validation="[['required'], ['min', 1], ['max', 999]]"
                                validaton-visibility="live"
                                number="integer"
                                :validation-messages="{
                                    required: __('Product stock is required'),
                                    min: __('Product stock must be at least 1.'),
                                    max: __('Product stock must be no more than 999.')
                                }"
                            />
                        </FormKit>

                        <template #stepPrevious="{ handlers, node }">

                            <FormKit
                                type="button"
                                @click="handlers.incrementStep(-1)()"
                                :label="__('Back')"
                                data-next="true"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                            />

                        </template>

                        <template #stepNext="{ handlers, node }">

                            <FormKit
                                type="button"
                                @click="handlers.incrementStep(1)()"
                                :label="__('Continue')"
                                data-next="true"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-success shadow-sm fw-bold"
                            />

                        </template>
                    </FormKit>

                    <FormKit type="step" :name="__('productImages')">

                        <h3 class="mb-2 text-center"> {{ __("Add images for product!") }} </h3>

                        <FormKit
                            id="images"
                            name="images[]"
                            type="file"
                            v-model="createProductForm.images"
                            :label="__('Product images')"
                            multiple="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            file-remove-class="btn btn-danger"
                            accept=".png,.jpg"
                            :help="__('Select as many images as you would like.')"
                        />

                        <template #stepPrevious="{ handlers, node }">

                            <FormKit
                                type="button"
                                @click="handlers.incrementStep(-1)()"
                                :label="__('Back')"
                                data-next="true"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                            />


                            <FormKit type="submit"
                                tabindex="0"
                                :label="__('Create')"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                            />

                        </template>

                    </FormKit>

                </FormKit>

            </FormKit>
        </div>

    </BodyLayout>
</template>
