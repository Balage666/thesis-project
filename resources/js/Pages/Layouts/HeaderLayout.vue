<script setup>
import Navbar from '*vue-components/Layout/Header/Navbar.vue';
import LanguageSwitcher from '*vue-components/Language/LanguageSwitcher.vue';

</script>
<template>
    <header>
        <div class="navbar banner-bg-color">
            <div class="col-12 col-lg-2 col-md-6 px-3">
                <a class="navbar-brand d-lg-block d-md-block d-sm-flex d-flex align-content-center justify-content-center" :href="route('storefront')" type="button">
                    <img
                        class="banner-logo"
                        src="/src/img/logo/BlueVenue_extra_small_transparent.png"
                        alt="Brand"
                        title="BlueVenue"

                    >
                </a>
            </div>
            <div class="col-12 col-lg-2 col-md-6 px-3">
                <LanguageSwitcher/>
            </div>
        </div>
        <Navbar/>
    </header>
</template>
