<template>
    <a-layout
        :style="{
            minHeight: '100vh',
            display: 'flex',
            flexDirection: $i18n.locale === 'ar' ? 'row-reverse' : 'row',
        }"
    >
        <a-layout-sider
            width="250"
            breakpoint="lg"
            collapsed-width="0"
            @collapse="onCollapse"
            @breakpoint="onBreakpoint"
            :collapsed="collapsed"
            :trigger="null"
            :style="{
                overflow: 'auto',
                height: '100vh',
                position: 'fixed',
                top: '0',
                [$i18n.locale === 'ar' ? 'right' : 'left']: '0',
                zIndex: '2',
            }"
        >
            <div class="logo flex justify-center items-center m-8">
                <img src="../../assets/logo.svg" alt="" class="mr-2" />
            </div>
            <a-menu
                theme="dark"
                v-model:selectedKeys="selectedKeys"
                mode="inline"
                style="border: 0 !important; background-color: transparent"
            >
                <a-menu-item key="1" @click="router.visit(route('dashboard'))">
                    <div
                        class="flex gap-2 items-center"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <DashboardOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.dashboard") }}</span>
                    </div>
                </a-menu-item>

                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage info',
                        )
                    "
                    key="2"
                    @click="router.visit(route('association.index'))"
                    ><div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <FlagOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.about") }}</span>
                    </div>
                </a-menu-item>

                <a-sub-menu
                    key="sub2"
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage adherents',
                        ) ||
                        $page.props.auth.user.permissions.includes(
                            'manage supervisors',
                        )
                    "
                >
                    <template #title>
                        <div
                            class="flex gap-2 items-center"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            <UserOutlined :style="{ fontSize: '24px' }" />
                            <span>{{ $t("sidebar.resources_humaines") }}</span>
                        </div>
                    </template>
                    <a-menu-item
                        v-if="
                            $page.props.auth.user.permissions.includes(
                                'manage adherents',
                            )
                        "
                        key="3"
                        @click="router.visit(route('adherents.index'))"
                        ><div
                            class="flex gap-2"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            <span>{{ $t("sidebar.adherents") }}</span>
                        </div>
                    </a-menu-item>
                    <a-menu-item
                        v-if="
                            $page.props.auth.user.permissions.includes(
                                'manage supervisors',
                            )
                        "
                        key="4"
                        @click="router.visit(route('supervisors.index'))"
                        ><div
                            class="flex gap-2"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            <span>{{ $t("sidebar.encadrants") }}</span>
                        </div>
                    </a-menu-item>
                </a-sub-menu>
                <a-sub-menu
                    key="sub3"
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage abonnements',
                        ) ||
                        $page.props.auth.user.permissions.includes(
                            'manage revenus',
                        ) ||
                        $page.props.auth.user.permissions.includes(
                            'manage depenses',
                        )
                    "
                >
                    <template #title>
                        <div
                            class="flex gap-2 items-center"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            <DollarCircleOutlined
                                :style="{ fontSize: '24px' }"
                            />
                            <span>{{ $t("sidebar.finance") }}</span>
                        </div>
                    </template>
                    <a-menu-item
                        v-if="
                            $page.props.auth.user.permissions.includes(
                                'manage abonnements',
                            )
                        "
                        key="5"
                        @click="router.visit(route('abonnements.index'))"
                        ><div
                            class="flex gap-2"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            {{ $t("sidebar.abonnements") }}
                        </div>
                    </a-menu-item>
                    <a-menu-item
                        v-if="
                            $page.props.auth.user.permissions.includes(
                                'manage revenus',
                            )
                        "
                        key="6"
                        @click="router.visit(route('revenues.index'))"
                    >
                        <div
                            class="flex gap-2"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            {{ $t("sidebar.revenus") }}
                        </div></a-menu-item
                    >
                    <a-menu-item
                        v-if="
                            $page.props.auth.user.permissions.includes(
                                'manage depenses',
                            )
                        "
                        key="7"
                        @click="router.visit(route('depenses.index'))"
                    >
                        <div
                            class="flex gap-2"
                            :class="
                                $i18n.locale === 'ar'
                                    ? 'flex-row-reverse'
                                    : 'row'
                            "
                        >
                            {{ $t("sidebar.depenses") }}
                        </div></a-menu-item
                    >
                </a-sub-menu>
                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage classes',
                        )
                    "
                    key="8"
                    @click="router.visit(route('classes.index'))"
                >
                    <div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <InsertRowBelowOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.classes") }}</span>
                    </div>
                </a-menu-item>

                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage groupes',
                        )
                    "
                    key="9"
                    @click="router.visit(route('groupes.index'))"
                >
                    <div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <GroupOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.groupes") }}</span>
                    </div>
                </a-menu-item>

                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage activites',
                        )
                    "
                    key="10"
                    @click="router.visit(route('activities.index'))"
                >
                    <div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <CalendarOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.activites") }}</span>
                    </div>
                </a-menu-item>

                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage reunions',
                        )
                    "
                    key="11"
                    @click="router.visit(route('reunions.index'))"
                >
                    <div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <TableOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.reunions") }}</span>
                    </div>
                </a-menu-item>

                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage stocks',
                        )
                    "
                    key="12"
                    @click="router.visit(route('stocks.index'))"
                >
                    <div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <DatabaseOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.biens") }}</span>
                    </div>
                </a-menu-item>

                <a-menu-item
                    v-if="
                        $page.props.auth.user.permissions.includes(
                            'manage docs',
                        )
                    "
                    key="13"
                    @click="router.visit(route('e-documents.index'))"
                >
                    <div
                        class="flex items-center gap-2"
                        :class="
                            $i18n.locale === 'ar' ? 'flex-row-reverse' : 'row'
                        "
                    >
                        <CopyOutlined :style="{ fontSize: '24px' }" />
                        <span>{{ $t("sidebar.documents") }}</span>
                    </div>
                </a-menu-item>
            </a-menu>
        </a-layout-sider>
        <a-layout :style="mainLayoutStyle">
            <a-layout-header
                :style="{
                    position: 'sticky',
                    top: '0',
                    zIndex: '3',
                    background: '#fff',
                    padding: '16px',
                    display: 'flex',
                    flexDirection:
                        $i18n.locale === 'ar' ? 'row-reverse' : 'row',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    boxShadow: '0px 0px 10px 0px rgba(0,0,0,0.4)',
                }"
            >
                <menu-fold-outlined
                    class="mobile-trigger"
                    @click="() => (collapsed = !collapsed)"
                />
                <!-- buttons icons -->
                <div
                    class="flex justify-center gap-2 items-center"
                    :class="
                        $i18n.locale === 'ar'
                            ? 'me-auto flex-row-reverse'
                            : 'ms-auto row'
                    "
                >
                    <!-- calender -->
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

                    <Dropdown :align="$i18n.locale === 'ar' ? 'left' : 'right'">
                        <template #trigger>
                            <button
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                                class="flex text-sm border-transparent rounded-full transition"
                            >
                                <Avatar
                                    status="online"
                                    status-position="top-right"
                                    rounded
                                    size="md"
                                    :img="
                                        $page.props.auth.user.profile_photo_url
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
            </a-layout-header>

            <a-layout-content
                :style="{
                    minHeight: '280px',
                }"
            >
                <div
                    class="px-4 py-6"
                    :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                >
                    <slot />
                </div>
            </a-layout-content>

            <a-layout-footer
                :style="{
                    position: 'sticky',
                    bottom: '0',
                    zIndex: '3',
                    padding: '18px',
                    background: '#fff',
                    textAlign: 'center',
                    boxShadow: '0px 0px 10px 0px rgba(0,0,0,0.4)',
                }"
            >
                Accesspoint ©{{ new Date().getFullYear() }} All rights
                reserved.
            </a-layout-footer>
        </a-layout>
    </a-layout>
</template>
<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, Head, router, usePage } from "@inertiajs/vue3";
import { ref, computed, defineProps } from "vue";
import { useI18n } from "vue-i18n";
const { t, availableLocales, locale } = useI18n();
import {
    MenuFoldOutlined,
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
const selectedKeys = ref(["1"]);
const collapsed = ref(false);
const onCollapse = (collapsed) => {
    collapsed.value = collapsed;
};

const onBreakpoint = (broken) => {
    collapsed.value = broken;
};

const mainLayoutStyle = computed(() => {
    let marginValue = collapsed.value ? "0px" : "250px";

    if (locale.value === "ar") {
        return { "margin-right": marginValue };
    } else {
        return { "margin-left": marginValue };
    }
});

const onMenuItemClick = () => {
    collapsed.value = true;
};

const changeLanguage = (lang) => {
    locale.value = lang;
    localStorage.setItem("language", lang);
};
const logout = () => {
    router.post(route("logout"));
};
</script>
<style scoped>
#components-layout-demo-responsive .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}

.site-layout-sub-header-background {
    background: #fff;
}

.site-layout-background {
    background: #fff;
}

[data-theme="dark"] .site-layout .site-layout-background {
    background: #141414;
}
.mobile-trigger {
    cursor: pointer;
    padding: 10px;
    display: none;
}

/* Show the trigger on mobile devices */
@media (max-width: 992px) {
    /* Assuming lg breakpoint is 992px */
    .mobile-trigger {
        display: block;
    }
}
</style>
