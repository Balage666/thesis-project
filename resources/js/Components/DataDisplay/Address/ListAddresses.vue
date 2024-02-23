<script setup>

import AddressItem from '*vue-components/DataDisplay/Address/AddressItem.vue';

const props = defineProps({
    list: {
        type: Array,
        required: true
    }
})

</script>

<template>
    <div class="container">

        <div v-if="props.list.length > 0">

            <AddressItem v-for="address in props.list" :item="address"/>
            <!-- <div class="row my-2" v-for="address in props.list">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-6 my-lg-2 my-0 text-center text-lg-start">
                                        Flag
                                    </div>
                                    <div class="col-12 col-lg-6 text-center text-lg-end">
                                        <div class="col-12 ms-0">
                                            Region
                                        </div>
                                        <div class="col-12">
                                            Address
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <h3 v-else class="text-center">There are no addresses!</h3>
    </div>
</template>

