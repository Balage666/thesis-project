<template>
    <!--DUCKTAPED: Displays incorrect language sometimes-->
    <select v-model="languageToSwitch" @change="switchLanguage" class="form-select form-select-lg" name="language_switcher" id="language_switcher">
        <option v-for="(lang) in locales" :value="lang.code">{{ __(lang.value) }}</option>
    </select>
</template>

<script setup>

import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { router } from '@inertiajs/vue3';

const page = usePage();

const locales = ref(page.props.value.locales);

const languageToSwitch = ref(page.props.value.current_locale);

console.log(`Current Locale: ${page.props.value.current_locale}`);


const switchLanguage = () => {
    console.log(`Current Locale: ${page.props.value.current_locale}, Lang to switch: ${languageToSwitch.value}`);
    router.get(route('switch-language', { language: languageToSwitch.value }));
}

</script>
