<script setup>

import { computed } from 'vue';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    products: {
        type: Object
    }
})

const productList = computed(() => props.products.data);
const ObjectProperties = computed(() => Object.getOwnPropertyNames(productList.value[0]).filter(p => p !== 'description').slice(1, 5))
console.log(ObjectProperties.value);

</script>

<style scoped>

</style>

<template>

    <Head>
        <title>{{ __('List products (design in development)') }}</title>
    </Head>
    <!-- <pre>{{ productList }}</pre> -->
    <BodyLayout>
        <!-- <h1>List products (design in development)</h1> -->


        <!--TODO: Make it scrollable and redesign it-->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" v-for="property in ObjectProperties">{{ property }}</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr v-for="product in productList">
                    <!-- <th scope="row">{{ product.id }}</th> -->
                    <th>{{ product.name }}</th>
                    <td>{{ product.shortened_description }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.stock }}</td>
                </tr>
            </tbody>
        </table>
    </BodyLayout>
</template>
