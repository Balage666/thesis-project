<script setup>

import { FormKit } from '@formkit/vue';
import { computed } from 'vue';
import { useForSelect } from '*vue-composables/ForSelectComposable';
import { useForm } from '@inertiajs/inertia-vue3';


import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    productToEdit: {
        type: [Array, Object]
    },
    categories: {
        type: [Array, Object]
    }
})

const { selectOptions: categoryList } = useForSelect(props.categories.data);

const productValues = computed(() => props.productToEdit.data);

const editProductForm = useForm({
    categoryId: productValues.value.category_id,
    name: productValues.value.name,
    description: productValues.value.description,
    price: productValues.value.price,
    stock: productValues.value.stock,
});

const sendFormData = () => {

    editProductForm.post(route('product-update', { id: productValues.value.id }))

}

</script>

<style scoped>

</style>

<template>

    <Head>
        <title>{{ __('Legacy Edit - Product') }}</title>
    </Head>

    <BodyLayout>

        <div class="my-5 py-5">
            <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

                <FormKit type="multi-step" tab-style="progress" :hide-progress-labels="true" :allow-incomplete="false" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center mb-5">

                    <FormKit type="step" :name="__('productCategory')">

                        <div class="alert alert-success" v-if="$page.props.flash.message">{{ __($page.props.flash.message) }}</div>

                        <h3 class="mb-3 mx-5 text-center"> {{ __("Modify the category for your product! (optional)") }} </h3>

                        <FormKit
                            id="category"
                            type="select"
                            name="category"
                            v-model="editProductForm.categoryId"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :options="categoryList"
                            :label="__('Product category')"
                            :validation="[['required']]"
                            validation-visibility="live"
                            :placeholder="__('--Select category--')"
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
                        <h3 class="mb-2 mx-auto text-center"> {{ __("Update product with changing one of the values") }} </h3>

                        <FormKit
                            id="name"
                            type="text"
                            name="name"
                            v-model="editProductForm.name"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__('Product name')"
                            :validation="[['required']]"
                            validation-visibility="live"

                        />


                        <FormKit
                            id="description"
                            type="textarea"
                            name="description"
                            v-model="editProductForm.description"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :label="__('Product description')"
                        />

                        <FormKit type="group">
                            <FormKit
                                id="price"
                                type="number"
                                name="price"
                                v-model="editProductForm.price"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4"
                                input-class="form-control form-control-lg"
                                :label="__('Product price')"
                                :validation="[['required']]"
                                validaton-visibility="live"
                                number="float"
                                min="500.00"
                                max="600000"
                            />

                            <FormKit
                                id="stock"
                                type="number"
                                name="stock"
                                v-model="editProductForm.stock"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4"
                                input-class="form-control form-control-lg"
                                :label="__('Product stock')"
                                :validation="[['required']]"
                                validaton-visibility="live"
                                number="integer"
                                min="1"
                                max="999"
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

                            <FormKit type="submit"
                                tabindex="0"
                                label="Update"
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
