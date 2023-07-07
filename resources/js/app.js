import "./bootstrap";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import VueApexCharts from "vue3-apexcharts";
import i18n from "./i18n";
import "../../node_modules/flag-icons/css/flag-icons.min.css";
import "../css/app.css";
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "MaAssociation";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),

    setup({ el, App, props, plugin }) {
        return (
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(i18n)
                .use(ZiggyVue, Ziggy)
                .use(VueApexCharts)
                // .use(VueChartJs)
                .mount(el)
        );
    },
    progress: {
        color: "#4B5563",
    },
});
