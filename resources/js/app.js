import './bootstrap';

import '../sass/app.scss'

import '../css/app.css'

import '@formkit/addons/css/multistep';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import { plugin as formkitPlugin, defaultConfig } from '@formkit/vue';
import { createMultiStepPlugin, createAutoAnimatePlugin } from '@formkit/addons'
import { translations } from './Mixins/translations';
import PrimeVue from 'primevue/config';


createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .use(formkitPlugin, defaultConfig({
            config: {
                classes: {
                }
            },
            plugins: [createMultiStepPlugin(), createAutoAnimatePlugin({
                duration: 100
            })]
        }))
        .use(PrimeVue, {
            unstyled: true
        });

        VueApp.mixin(translations);
        VueApp.mount(el);
    },
});
