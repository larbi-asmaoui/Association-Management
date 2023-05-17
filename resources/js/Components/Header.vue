<script setup>
import { ref } from "vue";
import { useSidebar } from "../hooks/useSidebar";
import { Link, Head, router } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
const { isOpen } = useSidebar();

const logout = () => {
    router.post(route("logout"));
};
</script>
<template>
    <header
        class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-blue-600"
    >
        <div class="flex items-center">
            <button
                @click="isOpen = true"
                class="text-gray-500 focus:outline-none lg:hidden"
            >
                <svg
                    class="w-6 h-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M4 6H20M4 12H20M4 18H11"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>

        <div class="flex items-center">
            <!-- other -->
            <Dropdown>
                <template #trigger>
                    <button class="flex mx-4 text-gray-600 focus:outline-none">
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
                                d="M9 3h-4a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2z"
                                stroke-width="0"
                                fill="currentColor"
                            ></path>
                            <path
                                d="M9 13h-4a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2z"
                                stroke-width="0"
                                fill="currentColor"
                            ></path>
                            <path
                                d="M19 13h-4a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2z"
                                stroke-width="0"
                                fill="currentColor"
                            ></path>
                            <path
                                d="M17 3a1 1 0 0 1 .993 .883l.007 .117v2h2a1 1 0 0 1 .117 1.993l-.117 .007h-2v2a1 1 0 0 1 -1.993 .117l-.007 -.117v-2h-2a1 1 0 0 1 -.117 -1.993l.117 -.007h2v-2a1 1 0 0 1 1 -1z"
                                stroke-width="0"
                                fill="currentColor"
                            ></path>
                        </svg>
                    </button>
                </template>
                <template #content>
                    <DropdownLink :href="route('profile.show')">
                        <div class="flex justify-start items-end">
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
                            Missions
                        </div>
                    </DropdownLink>
                    <div class="border-t border-gray-200" />
                    <DropdownLink :href="route('profile.show')">
                        <div class="flex justify-start items-end">
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
                            Type de stock
                        </div>
                    </DropdownLink>
                    <div class="border-t border-gray-200" />
                    <DropdownLink :href="route('profile.show')">
                        <div class="flex justify-start items-end">
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
                            Type de revenues
                        </div>
                    </DropdownLink>
                    <div class="border-t border-gray-200" />
                    <DropdownLink :href="route('profile.show')">
                        <div class="flex justify-start items-end">
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
                            Type de dépenses
                        </div>
                    </DropdownLink>
                    <div class="border-t border-gray-200" />
                    <DropdownLink :href="route('profile.show')">
                        <div class="flex justify-start items-end">
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
                                    d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1"
                                ></path>
                                <path d="M12 7v10"></path>
                            </svg>
                            Type de cotisation
                        </div>
                    </DropdownLink>
                </template>
            </Dropdown>

            <!-- Dropdown -->
            <Dropdown>
                <template #trigger>
                    <!-- class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none" -->
                    <button
                        v-if="$page.props.jetstream.managesProfilePhotos"
                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                    >
                        <img
                            class="h-8 w-8 rounded-full object-cover"
                            :src="$page.props.auth.user.profile_photo_url"
                            :alt="$page.props.auth.user.name"
                        />
                    </button>

                    <span v-else class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                        >
                            {{ $page.props.auth.user.name }}

                            <svg
                                class="ml-2 -mr-0.5 h-4 w-4"
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
                    <!-- Account Management -->
                    <!-- <div class="block px-4 py-2 text-xs text-gray-400">
                        Manage Account
                    </div> -->
                    <DropdownLink :href="route('profile.show')">
                        Profile
                    </DropdownLink>
                    <div class="border-t border-gray-200" />
                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                        <DropdownLink as="button"> Déconnexion </DropdownLink>
                    </form>
                </template>
            </Dropdown>
            <!-- class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white" -->
        </div>
    </header>
</template>
