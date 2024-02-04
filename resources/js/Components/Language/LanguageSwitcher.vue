<template>
    <select @change="switchLanguage" class="form-select form-select-lg" name="language_switcher" id="language_switcher">
        <option v-for="(lang, idx) in languages" :value="idx">{{ __(lang) }}</option>
    </select>
</template>

<script setup>

import { reactive, computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

const page = usePage();

const languages = computed(() => page.props.value.locales);

// console.log(languages.value);

const switchLanguage = ($event) => console.log($event.value)

</script>
