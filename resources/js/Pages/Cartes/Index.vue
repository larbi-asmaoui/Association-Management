<template>
    <a-config-provider :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
        <div class="px-2 pt-2">
            <h2
                class="text-xl font-semibold text-black-600 mb-4"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                <!-- {{ $t("documents.titre") }} -->
                Print Cartes
            </h2>
        </div>
    </a-config-provider>
</template>

<script setup>
import { useI18n } from "vue-i18n";
const { t, availableLocales, locale } = useI18n();
</script>

<script>
import RootLayout from "@/Layouts/RootLayout.vue";
export default {
    layout: RootLayout,
};
</script>
<style></style>
