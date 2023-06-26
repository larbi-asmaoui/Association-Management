import { createI18n } from "vue-i18n";
import ar from "../locales/ar.json";
import fr from "../locales/fr.json";

export default createI18n({
    locale: localStorage.getItem("language") || "ar",
    fallbackLocale: "fr", // <--- 2
    globalInjection: true,
    legacy: false,
    messages: { ar, fr },
});
