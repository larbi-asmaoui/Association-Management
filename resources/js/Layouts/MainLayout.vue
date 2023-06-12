<template>
  <nav class="fixed z-30 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button
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
          <Link :href="route('dashboard')" class="flex ml-2 md:mr-24">
            <img src="../../assets/logo.svg" alt="" class="mr-2" />
            <span
              class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"
              >MaAssociation</span
            >
          </Link>
        </div>
        <div class="flex items-center">
          <Link :href="route('evenements.calender')">
            <svg
              fill="none"
              stroke-width="2.5"
              stroke="currentColor"
              class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
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
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
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
              <DropdownLink :href="route('evenement-types.index')">
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                    <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1"></path>
                    <circle
                      cx="12"
                      cy="7.5"
                      r=".5"
                      fill="currentColor"
                    ></circle>
                  </svg>
                  Type d'événements
                </div>
              </DropdownLink>
              <div class="border-t border-gray-200" />
              <DropdownLink :href="route('stock-types.index')">
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                    <path d="M12 12l8 -4.5"></path>
                    <path d="M12 12l0 9"></path>
                    <path d="M12 12l-8 -4.5"></path>
                    <path d="M16 5.25l-8 4.5"></path>
                  </svg>
                  Type de stock
                </div>
              </DropdownLink>
              <div class="border-t border-gray-200" />
              <DropdownLink :href="route('status.index')">
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                    <path d="M15 19l2 2l4 -4"></path>
                  </svg>

                  Status
                </div>
              </DropdownLink>
              <div class="border-t border-gray-200" />
              <DropdownLink :href="route('revenue-types.index')">
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                    <path d="M7 11l5 5l5 -5"></path>
                    <path d="M12 4l0 12"></path>
                  </svg>
                  Type de revenus
                </div>
              </DropdownLink>
              <div class="border-t border-gray-200" />
              <DropdownLink :href="route('depense-types.index')">
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
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                    <path d="M7 9l5 -5l5 5"></path>
                    <path d="M12 4l0 12"></path>
                  </svg>
                  Type de dépenses
                </div>
              </DropdownLink>
              <!-- <div class="border-t border-gray-200" /> -->
              <!-- <DropdownLink :href="route('profile.show')">
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
                            </DropdownLink> -->
            </template>
          </Dropdown>

          <div class="flex items-center ml-3">
            <Dropdown>
              <template #trigger>
                <button
                  v-if="$page.props.jetstream.managesProfilePhotos"
                  class="flex text-sm border-transparent rounded-full transition"
                >
                  <Avatar
                    status="online"
                    status-position="top-right"
                    rounded
                    size="md"
                    :img="$page.props.auth.user.profile_photo_url"
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
                <DropdownLink :href="route('profile.show')">
                  Profile
                </DropdownLink>
                <div class="border-t border-gray-200" />
                <form @submit.prevent="logout">
                  <DropdownLink as="button"> Déconnexion </DropdownLink>
                </form>
              </template>
            </Dropdown>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->

  <aside
    id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-screen pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar"
  >
    <div
      class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="flex flex-col flex-1 pt-3 pb-4 overflow-y-auto">
        <div
          class="px-5 py-3 mb-3 flex gap-4 justify-start items-center bg-slate-700"
        >
          <Avatar
            status="online"
            status-position="top-right"
            rounded
            size="md"
            :img="$page.props.auth.user.profile_photo_url"
          />
          <h3>{{ $page.props.auth.user.name }}</h3>
        </div>

        <div
          class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
        >
          <ul class="pb-2 space-y-2">
            <li>
              <Link
                :class="[$page.url === '/' ? activeClass : inactiveClass]"
                :href="route('dashboard')"
              >
                <svg
                  aria-hidden="true"
                  class="w-6 h-6 transition duration-75"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                  <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                </svg>
                <span class="ml-3">Tableau de bord</span>
              </Link>
            </li>

            <li>
              <Link
                :class="[
                  $page.url === '/adherents' ? activeClass : inactiveClass,
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
                <span class="flex-1 ml-3 whitespace-nowrap">Adhérants</span>
              </Link>
            </li>

            <li>
              <Link
                :class="[
                  $page.url === '/cotisations' ? activeClass : inactiveClass,
                ]"
                :href="route('cotisations.index')"
              >
                <svg
                  class="flex-shrink-0 w-6 h-6 transition duration-75"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="2.5"
                  stroke="currentColor"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <circle cx="12" cy="12" r="9" />
                  <path
                    d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"
                  />
                  <path d="M12 6v2m0 8v2" />
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">Cotisations</span>
              </Link>
            </li>

            <li>
              <Link
                :class="[
                  $page.url === '/revenues' ? activeClass : inactiveClass,
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
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                  <path d="M7 11l5 5l5 -5"></path>
                  <path d="M12 4l0 12"></path>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">Revenus</span>
              </Link>
            </li>

            <li>
              <Link
                :class="[
                  $page.url === '/depenses' ? activeClass : inactiveClass,
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
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                  <path d="M7 9l5 -5l5 5"></path>
                  <path d="M12 4l0 12"></path>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">Dépenses</span>
              </Link>
            </li>

            <li>
              <Link
                :class="[
                  $page.url === '/groupes' ? activeClass : inactiveClass,
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
                <span class="flex-1 ml-3 whitespace-nowrap">Groupes</span>
              </Link>
            </li>

            <li>
              <Link
                :class="[
                  $page.url === '/evenements' ? activeClass : inactiveClass,
                ]"
                :href="route('evenements.index')"
              >
                <svg
                  class="w-6 h-6 transition duration-75"
                  fill="currentColor"
                  xmlns="http://www.w3.org/2000/svg"
                  stroke-width="1.5"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"
                  />
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">Événements</span>
              </Link>
            </li>

            <!-- <li>

                        </li> -->

            <li>
              <Link
                :class="[$page.url === '/stocks' ? activeClass : inactiveClass]"
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
                <span class="flex-1 ml-3 whitespace-nowrap">Stocks</span>
              </Link>
            </li>
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
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    ></path>
                                    <path
                                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
                                    ></path>
                                    <path
                                        d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"
                                    ></path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap"
                                    >Préférences</span
                                >
                            </Link>
                        </li> -->
          </ul>
        </div>
      </div>
    </div>
  </aside>

  <div class="relative pt-16 h-screen bg-slate-200 lg:ml-64 dark:bg-gray-900">
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
const { isOpen } = useSidebar();

const activeClass = ref(
  "bg-blue-700 text-white flex items-center p-2  rounded-lg group dark:text-gray-200 dark:hover:bg-gray-700"
);
const inactiveClass = ref(
  " text-gray-500 hover:bg-blue-100 flex items-center p-2 text-base rounded-lg group"
);

const logout = () => {
  router.post(route("logout"));
};

const isShowApps = ref(false);

const showApps = () => {
  isShowApps.value = !isShowApps.value;
  console.log(isShowApps.value);
};
</script>
