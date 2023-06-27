<template>
    <!-- Navbar -->
    <Navbar />
    <!-- End Navbar -->

    <!-- Sidebar -->
    <Sidebar />
    <!-- end Sidebar -->

    <div
        :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
        class="relative pt-16 h-screen no-scrollbar lg:ms-64 bg-slate-200 dark:bg-gray-900"
    >
        <main>
            <div class="px-4 py-6">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Avatar } from "flowbite-vue";
import { ref } from "vue";
import { useSidebar } from "../hooks/useSidebar";
import { Link, Head, router } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Sidebar from "../Components/Sidebar.vue";
import Navbar from "../Components/Navbar.vue";
import { useI18n } from "vue-i18n";
const { t, availableLocales, locale } = useI18n();

const { isOpen } = useSidebar();

const logout = () => {
    router.post(route("logout"));
};

const isShowApps = ref(false);

const showApps = () => {
    isShowApps.value = !isShowApps.value;
    console.log(isShowApps.value);
};
</script>
