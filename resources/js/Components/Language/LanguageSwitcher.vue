<template>
    <!--TODO: Create a not minimal design for this-->
    <select v-model="languageToSwitch" @change="switchLanguage" class="form-select form-select-lg" name="language_switcher" id="language_switcher">
        <option v-for="(lang) in locales" :value="lang.code">{{ __(lang.value) }}</option>
    </select>
</template>

<script setup>

import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

const page = usePage();

const locales = ref(page.props.value.locales);

// console.log(locales.value)

const languageToSwitch = ref(page.props.value.current_locale);

// console.log(`Current Locale: ${page.props.value.current_locale}`);

// const languageToSwitch = ref(page.props.value.current_locale);

const switchLanguage = () => {
    console.log(`Switching language to: ${languageToSwitch.value}`)
    console.log(`Current locale: ${page.props.value.current_locale}`)
}

</script>
