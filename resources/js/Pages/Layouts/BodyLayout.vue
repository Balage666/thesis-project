<script setup>

import HeaderLayout from './HeaderLayout.vue';
import FooterLayout from './FooterLayout.vue';
import ToastStack from '*vue-components/Notification/ToastStack.vue';

defineOptions({ layout: [HeaderLayout, FooterLayout] });

</script>

<template>
    <HeaderLayout/>
    <main>
        <ToastStack />
        <slot/>
    </main>
    <FooterLayout/>
</template>
