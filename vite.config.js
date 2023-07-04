import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import VueI18nPlugin from "@intlify/unplugin-vue-i18n/vite";

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
        // VueI18nPlugin({
        //     runtimeOnly: false, // <---
        //     include: resolve(dirname(fileURLToPath(import.meta.url)), './src/i18n/locales/**'),
        //   }),
    ],
});
