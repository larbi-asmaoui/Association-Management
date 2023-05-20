<script setup>
import { Link, Head, router } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="z-50 max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:bg-gray-700 dark:divide-gray-600"
    >
        <div
            class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
            Apps
        </div>
        <div class="grid grid-cols-3 gap-4 p-4">
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Types de revenues
                </div>
            </a>
            <Link
                :href="route('stock-types.index')"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    stroke-width="3"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Type de stock
                </div>
            </Link>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Inbox
                </div>
            </a>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Profile
                </div>
            </a>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Settings
                </div>
            </a>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                    <path
                        fill-rule="evenodd"
                        d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Products
                </div>
            </a>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"
                    ></path>
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Pricing
                </div>
            </a>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Billing
                </div>
            </a>
            <a
                href="#"
                class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <svg
                    class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                    ></path>
                </svg>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    Logout
                </div>
            </a>
        </div>
    </div>
</template>
