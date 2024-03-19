<script setup>

import { reactive, ref } from 'vue';

import Chart from 'primevue/chart';

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

const allUsersShow = ref(props.allUsers.data);
const allProductsShow = ref(props.allProducts.data);
const allCategoriesShow = ref(props.allCategories.data);

const data = ref([
    { label: 'User', count: allUsersShow.value.length }
]);

const chartData = reactive({
    labels: '1',
    datasets: [
        { label: 'Number of users', data: data.value.map(row => row.count) }
    ]
})

// const data = ref([
//     { year: 2010, count: 10 },
//     { year: 2011, count: 20 },
//     { year: 2012, count: 15 },
//     { year: 2013, count: 25 },
//     { year: 2014, count: 22 },
//     { year: 2015, count: 30 },
//     { year: 2016, count: 28 },
// ]);

// const chartData = reactive({
//     labels: data.value.map(row => row.year),
//     datasets: [
//         { label: 'Acquisitions by year',  data: data.value.map(row => row.count) }
//     ]
// })

</script>


<template>
    <h1>
        Charts
    </h1>

    <div class="container-fluid bg-info-subtle">
        <div class="row">
            <div class="col-6">
                <Chart type="bar" :data="chartData"/>
            </div>
        </div>

    </div>

    <!-- <pre>{{ allUsersShow }}</pre> -->
</template>
