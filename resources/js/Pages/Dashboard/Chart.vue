<script setup>

import { translations } from '../../Mixins/translations'

import { reactive, ref, computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

import Chart from 'primevue/chart';

import BodyLayout from '*vue-pages/Layouts/BodyLayout.vue';

const props = defineProps({
    allUsers: {
        type: [Array, Object]
    },
    allCategories: {
        type: [Array, Object]
    },
    allProducts: {
        type: [Array, Object]
    },
});

const pageProps = ref(usePage().props.value);

const currentLocale = pageProps.value.current_locale;

const allUsersShow = ref(props.allUsers.data);
const allProductsShow = ref(props.allProducts.data);
const allCategoriesShow = ref(props.allCategories.data);

const hasOnlyCustomerRole = computed(() => allUsersShow.value.filter(u => u.roles.find(r => r.name == 'Customer') && u.roles.length == 1));

const hasOnlyCustomerAndSellerRole = computed(() => {
    return allUsersShow.value.filter(u => u.roles.find(r => r.name == 'Customer') && u.roles.find(r => r.name == 'Seller') && u.roles.length == 2)
})
const hasOnlyCustomerAndModeratorRole = computed(() => allUsersShow.value.filter(u => u.roles.find(r => r.name == 'Customer') && u.roles.find(r => r.name == 'Moderator') && u.roles.length == 2))

const hasOnlyCustomerAndSellerAndModeratorRole = computed(() => allUsersShow.value.filter(u => u.roles.find(r => r.name == 'Customer') && u.roles.find(r => r.name == 'Seller') && u.roles.find(r => r.name == 'Moderator') && u.roles.length == 3))
const hasEveryRole = computed(() => allUsersShow.value.filter(u => u.roles.length == 4))

const productsNameAndQty = computed(() => allProductsShow.value.map(({name, stock}) => ({name, stock, bg: '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')}) ));

const countOfCategories = computed(() => allCategoriesShow.value.length);

const productsByCategories = computed(() => {
    return  allCategoriesShow.value.map(
        (c) => ({
                    name: c.name,
                    countOfProducts: c.products.length,
                    bg: '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')
                })
        )
})


const globalOptions = reactive({
    locale: currentLocale == 'en' ? 'en-EN' : 'hu-HU',
});

const usersCountBarOptions = reactive({
    ...globalOptions,
    scales: {
        y: {
            title: {
                text: translations.methods.__('Person'),
                display: true
            }
        },
    }
})

const productsCountBarOptions = reactive({
    ...globalOptions,
    scales: {
        y: {
            title: {
                text: translations.methods.__('Count'),
                display: true
            }
        },
    }
})

const productQtyOptions = reactive({
    ...globalOptions,
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            title: {
                text: translations.methods.__('Quantity'),
                display: true
            }
        },
        x: {
            title: {
                text: translations.methods.__('Name'),
                display: true
            }
        }
    }
})

const categoryOptions = reactive({
    ...globalOptions,
    scales: {
        y: {
            title: {
                text: translations.methods.__('Count'),
                display: true
            }
        },
    }
})

const productsByCategoriesOptions =  reactive({
    ...globalOptions,
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            title: {
                text: translations.methods.__('Number of Products'),
                display: true
            },
            min: 0,
            ticks: {
                stepSize: 1
            }
        },
        x: {
            title: {
                text: translations.methods.__('Category Name'),
                display: true
            }
        }
    }

})

const usersCount = ref([
    { label: 'Number of users', count: allUsersShow.value.length }
]);

const usersByRolesCount = ref([
    { label: translations.methods.__('Customer'), count: hasOnlyCustomerRole.value.length },
    { label: translations.methods.__('Customer-Seller'), count: hasOnlyCustomerAndSellerRole.value.length },
    { label: translations.methods.__('Customer-Moderator'), count: hasOnlyCustomerAndModeratorRole.value.length },
    { label: translations.methods.__('Customer-Seller-Moderator'), count: hasOnlyCustomerAndSellerAndModeratorRole.value.length },
    { label: translations.methods.__('Admin'), count: hasEveryRole.value.length }
])

const productsCount = ref([
    { label: translations.methods.__('Number of Products'), count: allProductsShow.value.length }
])

const productsNameAndQtyRef = ref([
    ...productsNameAndQty.value
])

const countOfCategoriesRef = ref([
    { label: translations.methods.__('Number of Categories'), count: countOfCategories.value }
])

const productsByCategoriesRef = ref([
    ...productsByCategories.value
])

const usersCountChartData = reactive({
    labels: [''],
    datasets: [
        { label: translations.methods.__(usersCount.value.map(row => row.label)), data: usersCount.value.map(row => row.count), backgroundColor: '#0dcaf0' }
    ]
})

const usersByRolesCountChartData = reactive({
    labels: usersByRolesCount.value.map(row => row.label),
    datasets: [
        { label: translations.methods.__('Number of users'), data: usersByRolesCount.value.map(row => row.count) }
    ],
    hoverOffset: 4
})

const productsCountChartData = reactive({
    labels: [''],
    datasets: [
        { label: translations.methods.__(productsCount.value.map(row => row.label)), data: productsCount.value.map(row => row.count), backgroundColor: "#eba865" }
    ]
})

const productsNameAndQtyChartData = reactive({
    labels: productsNameAndQtyRef.value.map(p => p.name),
    datasets: [
        { label: translations.methods.__('In Stock'), data: productsNameAndQtyRef.value.map(p => p.stock), backgroundColor: productsNameAndQtyRef.value.map(p => p.bg) }
    ]
})

const countOfCategoriesChartData = reactive({
    labels: [''],
    datasets: [
        { label: translations.methods.__(countOfCategoriesRef.value.map(row => row.label)), data: countOfCategoriesRef.value.map(row => row.count), backgroundColor: '#198754' }
    ]
})

const productsByCategoriesChartData = reactive({
    labels: productsByCategoriesRef.value.map(pc => pc.name),
    datasets: [
        { label: '', data: productsByCategoriesRef.value.map(pc => pc.countOfProducts), backgroundColor: productsByCategoriesRef.value.map(pc => pc.bg) }
    ]
})


</script>


<template>

    <Head>
        <title>{{ __('Charts') }}</title>
    </Head>

    <BodyLayout>
        <div class="container-fluid bg-info-subtle">
            <div class="row pt-3">
                <h2 class="text-center">{{ __('User related charts') }}</h2>
                <div class="col-12 col-md-6">
                    <h4 class="text-center">{{ __('Number of users') }}</h4>
                    <Chart type="bar" :data="usersCountChartData" :options="usersCountBarOptions"/>
                </div>

                <div class="col-12 col-md-6">
                    <h4 class="text-center">{{ __('Number of users grouped by role') }}</h4>
                    <Chart type="doughnut" :data="usersByRolesCountChartData" :options="globalOptions"/>
                </div>
            </div>

            <div class="row pt-3">
                <h2 class="text-center">{{ __('Product related charts') }}</h2>
                <div class="col-12 col-md-6">
                    <h4 class="text-center">{{ __('Number of products') }}</h4>
                    <Chart type="bar" :data="productsCountChartData" :options="productsCountBarOptions"/>
                </div>

                <div class="col-12 col-md-6">
                    <h4 class="text-center">{{ __('Products in stock') }}</h4>
                    <Chart type="bar" :data="productsNameAndQtyChartData" :options="productQtyOptions"/>
                </div>
            </div>

            <div class="row pt-3">
                <h2 class="text-center">{{ __('Category related charts') }}</h2>
                <div class="col-12 col-md-6">
                    <h4 class="text-center">{{ __('Number of categories') }}</h4>
                    <Chart type="bar" :data="countOfCategoriesChartData" :options="categoryOptions"/>
                </div>

                <div class="col-12 col-md-6">
                    <h4 class="text-center">{{ __('Number of products by categories') }}</h4>
                    <Chart type="bar" :data="productsByCategoriesChartData" :options="productsByCategoriesOptions"/>
                </div>
            </div>

        </div>
    </BodyLayout>
</template>
