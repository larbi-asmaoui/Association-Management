import "./bootstrap";

import { createApp, h } from "vue";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import VueApexCharts from "vue3-apexcharts";
import i18n from "./i18n";
import ElementPlus from 'element-plus'
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import "../../node_modules/flag-icons/css/flag-icons.min.css";

import '../../node_modules/ant-design-vue/dist/reset.css';
import "../css/app.css";
import '../../node_modules/element-plus/dist/index.css';
import '../../node_modules/dropzone/dist/dropzone.css';

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "MaAssociation";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),

    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ElementPlus)
            .use(ZiggyVue, Ziggy)
            .use(VueApexCharts)
            .use(VueSweetalert2)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
