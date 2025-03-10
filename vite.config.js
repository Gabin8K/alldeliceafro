import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from "laravel-vue-i18n/vite";
import Components from 'unplugin-vue-components/vite'
import { UnpluginVueComponentsResolver } from 'maz-ui/resolvers'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
        Components({
            dts: true,
            resolvers: [UnpluginVueComponentsResolver()],
        }),
    ],
});
