<template>
    <aside
        id="sidebar"
        class="fixed top-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-screen pt-16 font-normal duration-75 lg:flex transition-width"
        :class="$i18n.locale === 'ar' ? 'right-0' : 'left-0'"
        aria-label="Sidebar"
        :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
    >
        <div
            class="relative no-scrollbar flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        >
            <div class="flex flex-col flex-1 pb-2 overflow-y-auto">
                <!-- <div
                    class="px-5 py-1 mt-2 mb-2 flex flex-col gap-2 justify-start items-center border-b border-gray-200"
                >
                    <Avatar
                        square
                        size="lg"
                        :img="
                            /storage/ + $page.props.auth.user.association.image
                        "
                    />

                    <h2 class="text-md text-slate-400">
                        {{ $page.props.auth.user.association.name }}
                    </h2>
                </div> -->

                <div class="flex-1 px-3 pt-5 space-y-1">
                    <a-menu
                        v-model:selectedKeys="selectedKeys"
                        mode="inline"
                        style="
                            border: 0 !important;
                            background-color: transparent;
                        "
                    >
                        <a-menu-item
                            key="1"
                            @click="router.visit(route('dashboard'))"
                        >
                            <DashboardOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.dashboard") }}</span>
                        </a-menu-item>

                        <a-menu-item
                            key="2"
                            @click="router.visit(route('association.index'))"
                        >
                            <FlagOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.about") }}</span>
                        </a-menu-item>

                        <a-sub-menu key="sub2">
                            <template #title>
                                <span>
                                    <UserOutlined
                                        :style="{ fontSize: '24px' }"
                                    />
                                    <span>{{
                                        $t("sidebar.resources_humaines")
                                    }}</span>
                                </span>
                            </template>
                            <a-menu-item
                                key="3"
                                @click="router.visit(route('adherents.index'))"
                            >
                                <span>{{ $t("sidebar.adherents") }}</span>
                            </a-menu-item>
                            <a-menu-item
                                key="4"
                                @click="
                                    router.visit(route('supervisors.index'))
                                "
                            >
                                <span>{{ $t("sidebar.encadrants") }}</span>
                            </a-menu-item>
                        </a-sub-menu>
                        <a-sub-menu key="sub3">
                            <template #title>
                                <span>
                                    <DollarCircleOutlined
                                        :style="{ fontSize: '24px' }"
                                    />
                                    <span>{{ $t("sidebar.finance") }}</span>
                                </span>
                            </template>
                            <a-menu-item
                                key="5"
                                @click="
                                    router.visit(route('abonnements.index'))
                                "
                                >{{ $t("sidebar.abonnements") }}</a-menu-item
                            >
                            <a-menu-item
                                key="6"
                                @click="router.visit(route('revenues.index'))"
                                >{{ $t("sidebar.revenus") }}</a-menu-item
                            >
                            <a-menu-item
                                key="7"
                                @click="router.visit(route('depenses.index'))"
                                >{{ $t("sidebar.depenses") }}</a-menu-item
                            >
                        </a-sub-menu>
                        <a-menu-item
                            key="8"
                            @click="router.visit(route('classes.index'))"
                        >
                            <InsertRowBelowOutlined
                                :style="{ fontSize: '24px' }"
                            />
                            <span>{{ $t("sidebar.classes") }}</span>
                        </a-menu-item>

                        <a-menu-item
                            key="9"
                            @click="router.visit(route('groupes.index'))"
                        >
                            <GroupOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.groupes") }}</span>
                        </a-menu-item>

                        <a-menu-item
                            key="10"
                            @click="router.visit(route('activities.index'))"
                        >
                            <CalendarOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.activites") }}</span>
                        </a-menu-item>

                        <a-menu-item
                            key="11"
                            @click="router.visit(route('reunions.index'))"
                        >
                            <TableOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.reunions") }}</span>
                        </a-menu-item>

                        <a-menu-item
                            key="12"
                            @click="router.visit(route('stocks.index'))"
                        >
                            <DatabaseOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.biens") }}</span>
                        </a-menu-item>

                        <a-menu-item
                            key="13"
                            @click="router.visit(route('e-documents.index'))"
                        >
                            <CopyOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.documents") }}</span>
                        </a-menu-item>
                    </a-menu>

                    <!-- <ul class="pb-2 space-y-2"> -->
                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('dashboard')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-6 h-6 transition duration-75"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"
                                    ></path>
                                    <path
                                        d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"
                                    ></path>
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.dashboard") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/association'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('association.index')"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-help-hexagon"
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
                                        d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"
                                    ></path>
                                    <path d="M12 16v.01"></path>
                                    <path
                                        d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483"
                                    ></path>
                                </svg>

                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.about") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/adherents'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('adherents.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.adherents") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- Supervisor -->
                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/supervisors'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('supervisors.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.encadrants") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- Classes -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/classes'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('classes.index')"
                            >
                                <svg
                                    fill="currentColor"
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        clip-rule="evenodd"
                                        fill-rule="evenodd"
                                        d="M 22,5L 22,7L 17.0089,7L 13.5326,12L 16,12L 16,14L 14.4632,14L 18.1691,22L 15.965,22L 15.0385,20L 6.38418,20L 5.35074,22L 3.09952,22L 7.23328,14L 7,14C 6.55086,14 6.17087,13.7039 6.04461,13.2962L 2.86808,3.83882L 3.81604,3.52042C 4.33958,3.34458 4.90655,3.62644 5.08239,4.14998L 7.71903,12L 12.0967,12L 15.573,7L 12,7L 12,5L 22,5 Z M 9.4845,14L 7.41762,18L 14.112,18L 12.2591,14L 9.4845,14 Z "
                                    ></path>
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.classes") }}</span
                                >
                            </Link>
                        </li> -->
                    <!--  -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/abonnements'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('abonnements.index')"
                            >
                                <svg
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <circle cx="12" cy="12" r="9" />
                                    <path
                                        d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"
                                    />
                                    <path d="M12 6v2m0 8v2" />
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.abonnements") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/groupes'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('groupes.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"
                                    />
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.groupes") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/reunions'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('reunions.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    stroke-width="1.5"
                                    stroke="currentColor"
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
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <path
                                        d="M21 21v-2a4 4 0 0 0 -3 -3.85"
                                    ></path>
                                </svg>

                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.reunions") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/revenues'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('revenues.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    stroke-width="2"
                                    stroke="currentColor"
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
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.revenus") }}</span
                                >
                            </Link>
                        </li>

                        <li>
                            <Link
                                :class="[
                                    $page.url === '/depenses'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('depenses.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 ttransition duration-75"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    stroke-width="2"
                                    stroke="currentColor"
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
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.depenses") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/activities'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('activities.index')"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-calendar-event"
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
                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"
                                    ></path>
                                    <path d="M16 3l0 4"></path>
                                    <path d="M8 3l0 4"></path>
                                    <path d="M4 11l16 0"></path>
                                    <path d="M8 15h2v2h-2z"></path>
                                </svg>

                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.activites") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>

                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/stocks'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('stocks.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-6 h-6 transition duration-75"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"
                                    />
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.biens") }}</span
                                >
                            </Link>
                        </li> -->

                    <!-- <li>
                            <Link
                                :class="[
                                    $page.url === '/e-documents'
                                        ? activeClass
                                        : inactiveClass,
                                ]"
                                :href="route('e-documents.index')"
                            >
                                <svg
                                    aria-hidden="true"
                                    class="w-6 h-6 transition duration-75"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    ></path>
                                    <path d="M15 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path
                                        d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z"
                                    ></path>
                                    <path
                                        d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2"
                                    ></path>
                                </svg>
                                <span
                                    :class="
                                        $i18n.locale === 'ar' ? 'mr-3' : 'ml-3'
                                    "
                                    >{{ $t("sidebar.documents") }}</span
                                >
                            </Link>
                        </li> -->
                    <!-- </ul> -->
                </div>
            </div>
        </div>
        <!-- {{ permissions }} -->
    </aside>
</template>

<script setup>
import { Link, Head, router, usePage } from "@inertiajs/vue3";
import { ref, computed, defineProps } from "vue";
import { useI18n } from "vue-i18n";
import {
    CalendarOutlined,
    TableOutlined,
    CopyOutlined,
    DatabaseOutlined,
    DashboardOutlined,
    DollarCircleOutlined,
    InsertRowBelowOutlined,
    FlagOutlined,
    UserOutlined,
    GroupOutlined,
} from "@ant-design/icons-vue";

const props = defineProps(["isSidebarOpen"]);
const { t } = useI18n();

const selectedKeys = ref(["1"]);
const collapsed = ref(false);

const activeClass = ref(
    "bg-blue-700 text-white flex items-center p-2  rounded-lg group dark:text-gray-200 dark:hover:bg-gray-700",
);
const inactiveClass = ref(
    " text-gray-500 hover:bg-blue-100 flex items-center p-2 text-base rounded-lg group",
);
</script>
<script>
export default {
    data() {
        return {
            dropdownVisible: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.dropdownVisible = !this.dropdownVisible;
        },
    },
};
</script>
