import './bootstrap';
import 'maz-ui/styles';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue } from "laravel-vue-i18n";
import { installToaster } from 'maz-ui';
import { useDark } from "@vueuse/core";
import clickOutside from "@/Directives/clickOutsideDirective.js";

localStorage.setItem('vueuse-color-scheme', 'light');
useDark();

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const toasterOptions= {
    persistent: false,
    position: 'bottom-right',
    timeout: 4_000,
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18nVue, {
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
            })
            .use(installToaster, toasterOptions)
            .directive('click-outside', clickOutside)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
