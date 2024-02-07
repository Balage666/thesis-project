<script setup>

import HeaderLayout from './HeaderLayout.vue';
import FooterLayout from './FooterLayout.vue';

defineOptions({ layout: [HeaderLayout, FooterLayout] });

</script>

<template>
    <HeaderLayout/>
    <main>
        <slot/>
    </main>
    <FooterLayout/>
</template>
