<template>
    <nav
        :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
        class="fixed z-30 w-full min-h-[70px] border-b border-gray-200 bg-white"
    >
        <div class="pe-3 py-3 lg:pe-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button
                        @click="handleToggle"
                        id="toggleSidebarMobile"
                        aria-expanded="true"
                        aria-controls="sidebar"
                        class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                        <svg
                            id="toggleSidebarMobileHamburger"
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <svg
                            id="toggleSidebarMobileClose"
                            class="hidden w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                    <Link :href="route('dashboard')" class="flex ms-2 md:me-24">
                        <img src="../../assets/logo.svg" alt="" class="mr-2" />
                        <!-- <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"
                            >MaAssociation</span
                        > -->
                    </Link>
                </div>
                <div class="flex items-center">
                    <Link :href="route('activities.calender')" class="me-3">
                        <svg
                            fill="none"
                            stroke-width="2.5"
                            stroke="currentColor"
                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <path
                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"
                            ></path>
                            <path d="M16 3v4"></path>
                            <path d="M8 3v4"></path>
                            <path d="M4 11h16"></path>
                            <path d="M11 15h1"></path>
                            <path d="M12 15v3"></path>
                        </svg>
                    </Link>

                    <!-- Languages -->
                    <el-dropdown>
                        <span class="el-dropdown-link">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-apps-filled"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"
                                ></path>
                                <path d="M3.6 9h16.8"></path>
                                <path d="M3.6 15h16.8"></path>
                                <path d="M11.5 3a17 17 0 0 0 0 18"></path>
                                <path d="M12.5 3a17 17 0 0 1 0 18"></path>
                            </svg>
                        </span>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item
                                    @click.native="changeLanguage('fr')"
                                    >{{
                                        $t("navbar.francais")
                                    }}</el-dropdown-item
                                >
                                <el-dropdown-item
                                    @click.native="changeLanguage('ar')"
                                    >{{ $t("navbar.arabe") }}</el-dropdown-item
                                >
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>

                    <span class="me-3"></span>
                    <el-dropdown
                        :align="$i18n.locale === 'ar' ? 'left' : 'right'"
                    >
                        <span class="el-dropdown-link">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-settings-filled"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                ></path>
                                <path
                                    d="M14.647 4.081a.724 .724 0 0 0 1.08 .448c2.439 -1.485 5.23 1.305 3.745 3.744a.724 .724 0 0 0 .447 1.08c2.775 .673 2.775 4.62 0 5.294a.724 .724 0 0 0 -.448 1.08c1.485 2.439 -1.305 5.23 -3.744 3.745a.724 .724 0 0 0 -1.08 .447c-.673 2.775 -4.62 2.775 -5.294 0a.724 .724 0 0 0 -1.08 -.448c-2.439 1.485 -5.23 -1.305 -3.745 -3.744a.724 .724 0 0 0 -.447 -1.08c-2.775 -.673 -2.775 -4.62 0 -5.294a.724 .724 0 0 0 .448 -1.08c-1.485 -2.439 1.305 -5.23 3.744 -3.745a.722 .722 0 0 0 1.08 -.447c.673 -2.775 4.62 -2.775 5.294 0zm-2.647 4.919a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z"
                                    stroke-width="0"
                                    fill="currentColor"
                                ></path>
                            </svg>
                        </span>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item
                                    @click="
                                        router.visit(
                                            route('activity-types.index'),
                                        )
                                    "
                                >
                                    <div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-accessible w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"
                                            ></path>
                                            <path d="M16 3l0 4"></path>
                                            <path d="M8 3l0 4"></path>
                                            <path d="M4 11l16 0"></path>
                                            <path d="M8 15h2v2h-2z"></path>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                            >{{
                                                $t("navbar.type_activite")
                                            }}</span
                                        >
                                    </div>
                                </el-dropdown-item>
                                <el-dropdown-item
                                    @click="
                                        router.visit(
                                            route('reunion-types.index'),
                                        )
                                    "
                                >
                                    <div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-accessible mr-1 w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"
                                            ></path>
                                            <path
                                                d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                            ></path>
                                            <path
                                                d="M16 3.13a4 4 0 0 1 0 7.75"
                                            ></path>
                                            <path
                                                d="M21 21v-2a4 4 0 0 0 -3 -3.85"
                                            ></path>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                        >
                                            {{
                                                $t("navbar.type_reunion")
                                            }}</span
                                        >
                                    </div>
                                </el-dropdown-item>
                                <!-- stock types -->
                                <!-- <el-dropdown-item
                                    @click="
                                        router.visit(route('stock-types.index'))
                                    "
                                >
                                    <div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-package mr-1 w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"
                                            ></path>
                                            <path d="M12 12l8 -4.5"></path>
                                            <path d="M12 12l0 9"></path>
                                            <path d="M12 12l-8 -4.5"></path>
                                            <path d="M16 5.25l-8 4.5"></path>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                        >
                                            {{ $t("navbar.type_bien") }}</span
                                        >
                                    </div>
                                </el-dropdown-item> -->

                                <el-dropdown-item
                                    @click="
                                        router.visit(route('statuts.index'))
                                    "
                                >
                                    <div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-package mr-1 w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"
                                            ></path>
                                            <path
                                                d="M6 21v-2a4 4 0 0 1 4 -4h4"
                                            ></path>
                                            <path d="M15 19l2 2l4 -4"></path>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                        >
                                            {{ $t("navbar.statut") }}</span
                                        >
                                    </div>
                                </el-dropdown-item>
                                <el-dropdown-item
                                    @click="
                                        router.visit(
                                            route('revenue-types.index'),
                                        )
                                    "
                                >
                                    <div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-upload mr-1 w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"
                                            ></path>
                                            <path d="M7 11l5 5l5 -5"></path>
                                            <path d="M12 4l0 12"></path>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                        >
                                            {{
                                                $t("navbar.type_revenue")
                                            }}</span
                                        >
                                    </div>
                                </el-dropdown-item>

                                <el-dropdown-item
                                    @click="
                                        router.visit(
                                            route('depense-types.index'),
                                        )
                                    "
                                    ><div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-download mr-1 w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"
                                            ></path>
                                            <path d="M7 9l5 -5l5 5"></path>
                                            <path d="M12 4l0 12"></path>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                        >
                                            {{
                                                $t("navbar.type_depense")
                                            }}</span
                                        >
                                    </div>
                                </el-dropdown-item>
                                <el-dropdown-item
                                    v-if="
                                        $page.props.auth.user.permissions.includes(
                                            'manage users',
                                        )
                                    "
                                    @click="router.visit(route('users.index'))"
                                    ><div
                                        class="flex"
                                        :class="
                                            $i18n.locale == 'ar'
                                                ? 'flex-row-reverse ml-auto'
                                                : ''
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-coin mr-1 w-6 h-6"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                                fill="none"
                                            ></path>
                                            <path
                                                d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"
                                            ></path>
                                            <path
                                                d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1"
                                            ></path>
                                            <circle
                                                cx="12"
                                                cy="7.5"
                                                r=".5"
                                                fill="currentColor"
                                            ></circle>
                                        </svg>
                                        <span
                                            :class="
                                                $i18n.locale === 'ar'
                                                    ? 'mr-3'
                                                    : 'ml-3'
                                            "
                                        >
                                            {{ $t("navbar.users") }}</span
                                        >
                                    </div>
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>

                    <div class="flex items-center ml-3">
                        <Dropdown
                            :align="$i18n.locale === 'ar' ? 'left' : 'right'"
                        >
                            <template #trigger>
                                <button
                                    v-if="
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                    class="flex text-sm border-transparent rounded-full transition"
                                >
                                    <Avatar
                                        status="online"
                                        status-position="top-right"
                                        rounded
                                        size="md"
                                        :img="
                                            $page.props.auth.user
                                                .profile_photo_url
                                        "
                                    />
                                </button>

                                <span v-else class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-transparent hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                    >
                                        {{ $page.props.auth.user.name }}

                                        <svg
                                            class="ms-2 -ms-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.show')">
                                    {{ $t("navbar.profile") }}
                                </DropdownLink>
                                <div class="border-t border-gray-200" />
                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        {{ $t("navbar.logout") }}
                                    </DropdownLink>
                                </form>
                                <GlobeLight />
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Avatar } from "flowbite-vue";
import { Link, Head, router, usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { useI18n } from "vue-i18n";
import { computed, onMounted } from "vue";
// import GlobeLight from "vue-material-design-icons/GlobeLight.vue";
const { t, availableLocales, locale } = useI18n();

const logout = () => {
    router.post(route("logout"));
};

const changeLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem("language", lang);
};

const emits = defineEmits(["toggle-sidebar"]);

function handleToggle() {
    console.log("toggle");
    emits("toggle-sidebar");
}
</script>
