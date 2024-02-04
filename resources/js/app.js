import './bootstrap';

import '../sass/app.scss'

import '../css/app.css'


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import { translations } from './Mixins/translations';


createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy);

        VueApp.mixin(translations);
        VueApp.mount(el);
    },
});
