<script setup>

import { FormKit } from '@formkit/vue';
import { useForm, router } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    categories: {
        type: [Array, Object]
    }
});

const categoryList = computed(() => {
    let list = [];
    props.categories.data.forEach(element => {
        list.push({ label: element.name, value: element.id })
    });
    return list;
});

// console.log(categoryList.value)

const createProductForm = useForm({
    categoryId: '',
    name: '',
    description: '',
    price: 500.00,
    stock: 1,
    images: []
})

const sendFormData = () => {

    console.log(createProductForm);
    createProductForm.post(route('product-store'));
}

</script>

<style scoped>

</style>

<template>
    <BodyLayout>

        <!-- <h1>Create Product</h1> -->

        <div class="my-5 py-5">
            <FormKit type="form" :actions="false" #default="{ disabled }" @submit="sendFormData()">

                <FormKit type="multi-step" tab-style="progress" :hide-progress-labels="true" :allow-incomplete="false" steps-class="authFormCardBackground" outer-class="d-flex justify-content-center mb-5">

                    <FormKit type="step" name="productCategory">

                        <div class="alert alert-success" v-if="$page.props.flash.message">{{ __($page.props.flash.message) }}</div>

                        <h3 class="mb-3 mx-5 text-center"> {{ __("Choose a category for your product!") }} </h3>
                        <FormKit
                            id="category"
                            type="select"
                            name="category"
                            v-model="createProductForm.categoryId"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            :options="categoryList"
                            label="Product category"
                            :validation="[['required']]"
                            validation-visibility="live"
                            placeholder="--Select category--"
                        />


                        <template #stepNext="{ handlers, node }">

                            <FormKit
                                type="button"
                                @click="handlers.incrementStep(1)()"
                                label="Continue"
                                data-next="true"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-success shadow-sm fw-bold"
                            />

                        </template>
                    </FormKit>

                    <FormKit type="step" name="productDetails">
                        <h3 class="mb-2 mx-auto text-center"> {{ __("Create a product with filling the form below!") }} </h3>

                        <div class="alert alert-danger" v-if="$page.props.errors" v-for="error in $page.props.errors">{{ __(error) }}</div>

                        <FormKit
                            id="name"
                            type="text"
                            name="name"
                            v-model="createProductForm.name"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            label="Product name"
                            :validation="[['required']]"
                            validation-visibility="live"

                        />


                        <FormKit
                            id="description"
                            type="textarea"
                            name="description"
                            v-model="createProductForm.description"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            label="Product description"
                        />

                        <FormKit type="group">
                            <FormKit
                                id="price"
                                type="number"
                                name="price"
                                v-model="createProductForm.price"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4"
                                input-class="form-control form-control-lg"
                                label="Product price"
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
                                v-model="createProductForm.stock"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4"
                                input-class="form-control form-control-lg"
                                label="Product stock"
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
                                label="Back"
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
                                label="Continue"
                                data-next="true"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-success shadow-sm fw-bold"
                            />

                        </template>
                    </FormKit>

                    <FormKit type="step" name="productImages">

                        <h3 class="mb-2 text-center"> {{ __("Add images for product!") }} </h3>

                        <FormKit
                            id="images"
                            name="images[]"
                            type="file"
                            v-model="createProductForm.images"
                            label="Product images"
                            multiple="true"
                            label-class="form-label d-flex justify-content-start fw-bold"
                            outer-class="form-outline mb-4"
                            input-class="form-control form-control-lg"
                            file-remove-class="btn btn-danger"
                            accept=".png,.jpg"
                            help="Select as many images as you would like."
                        />

                        <template #stepPrevious="{ handlers, node }">

                            <FormKit
                                type="button"
                                @click="handlers.incrementStep(-1)()"
                                label="Back"
                                data-next="true"
                                label-class="form-label d-flex justify-content-start fw-bold"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-secondary shadow-sm fw-bold"
                            />


                            <FormKit type="submit"
                                tabindex="0"
                                label="Create"
                                outer-class="form-outline mb-4 ms-auto me-auto"
                                input-class="btn btn-lg btn-primary shadow-sm fw-bold"
                            />

                        </template>

                    </FormKit>

                </FormKit>

            </FormKit>
        </div>


        <!-- <form @submit.prevent="">

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input v-model="createProductForm.name" type="text" class="form-control formInputFieldBackground" id="exampleFormControlInput1">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea v-model="createProductForm.description" class="form-control formInputFieldBackground" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Price</label>
                <input v-model="createProductForm.price" type="number" class="form-control formInputFieldBackground" id="exampleFormControlInput2">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Stock</label>
                <input v-model="createProductForm.stock" type="number" class="form-control formInputFieldBackground" id="exampleFormControlInput3">
            </div>

            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Product Images</label>
                <input @change="handleImages" class="form-control formInputFieldBackground" type="file" id="formFileMultiple" multiple>
            </div>

            <div class="mb-3 d-flex gap-2">
                <button type="button" class="btn btn-secondary">Back</button>
                <button type="submit" class="btn btn-info">Create</button>
            </div>

        </form> -->

    </BodyLayout>
</template>
