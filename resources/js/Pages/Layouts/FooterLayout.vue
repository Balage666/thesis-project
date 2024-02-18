<script setup>

import ContactInfo from '*vue-components/Layout/Footer/ContactInfo.vue';
</script>


<template>
    <footer>
        <ContactInfo/>

        <div class="banner-bg-color text-center">

            <div class="row">

                <div class="col-12">
                    <div>
                        <p> <span class="fw-bold">Created by:</span> Karácsony Balázs (H8HYMB) - <span class="fw-bold">{{ new Date().getFullYear() }}</span> </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</template>
