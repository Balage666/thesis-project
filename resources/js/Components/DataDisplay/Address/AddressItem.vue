<script setup>

import countries from 'countries-phone-masks';

import { State } from 'country-state-city';

const props = defineProps({
    item: {
        type: Object,
        required: true
    }
});

const gatherCorrectFlag = (countryIso) => {

    return countries.find(({ iso }) => iso === countryIso)?.flag;

}


const gatherNameOfRegion = (countryIso, regionIso) => {

    return State.getStateByCodeAndCountry(regionIso, countryIso)?.name;

}

</script>

<template>

    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-end">
                                <i class="fa-solid fa-circle-xmark text-danger fw-bold fs-5"></i>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6 my-lg-2 my-0 text-center text-lg-start">
                                <img :src="gatherCorrectFlag(item.country)" style="width: 50px; height: 50px;" :alt="item.country" :title="item.country">
                            </div>
                            <div class="col-12 col-lg-6 text-center text-lg-end">
                                <div class="col-12 ms-0">
                                    {{ gatherNameOfRegion(item.country, item.region) ?? '-' }}
                                </div>
                                <div class="col-12">
                                    <p class="fw-bold">
                                        <span class="badge bg-info">
                                            {{ item.postal_zip_code }}
                                        </span>,
                                        {{ item.address_text }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

