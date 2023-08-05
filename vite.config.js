import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import VueI18nPlugin from "@intlify/unplugin-vue-i18n/vite";
import Components from 'unplugin-vue-components/vite';
import { AntDesignVueResolver } from 'unplugin-vue-components/resolvers';

export default defineConfig({
    define: {
        "process.env": {},
    },
    plugins: [
        laravel({
            input: "resources/js/app.js",
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
        Components({
            resolvers: [
              AntDesignVueResolver({
                importStyle: false, // css in js
              }),
            ],
          }),
        // VueI18nPlugin({
        //     runtimeOnly: false, // <---
        //     include: resolve(dirname(fileURLToPath(import.meta.url)), './src/i18n/locales/**'),
        //   }),
    ],
});
