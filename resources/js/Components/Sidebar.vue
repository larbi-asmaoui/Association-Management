<template>
  <aside
    id="sidebar"
    class="fixed no-scrollbar top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-screen pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar"
  >
    <div
      class="relative no-scrollbar flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="flex flex-col flex-1 pb-2 overflow-y-auto">
        <div
          class="px-5 py-1 mt-2 mb-2 flex flex-col gap-2 justify-start items-center border-b border-gray-200"
        >
          <Avatar
            square
            size="lg"
            :img="/storage/ + $page.props.auth.user.association.image"
          />
          <h2 class="text-md text-slate-400">
            {{ $page.props.auth.user.association.name }}
          </h2>
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
                  $page.url === '/association' ? activeClass : inactiveClass,
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
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path
                    d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"
                  ></path>
                  <path d="M12 16v.01"></path>
                  <path
                    d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483"
                  ></path>
                </svg>

                <span class="ml-3">À propos</span>
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

            <!-- <li>
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
            </li> -->

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
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path
                    d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"
                  ></path>
                  <path d="M16 3l0 4"></path>
                  <path d="M8 3l0 4"></path>
                  <path d="M4 11l16 0"></path>
                  <path d="M8 15h2v2h-2z"></path>
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
            <li>
              <Link
                :class="[
                  $page.url === '/e-documents' ? activeClass : inactiveClass,
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
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M15 3v4a1 1 0 0 0 1 1h4"></path>
                  <path
                    d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z"
                  ></path>
                  <path
                    d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2"
                  ></path>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">E-documents</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { Avatar } from "flowbite-vue";
import { Link, Head, router } from "@inertiajs/vue3";
import { ref } from "vue";
const activeClass = ref(
  "bg-blue-700 text-white flex items-center p-2  rounded-lg group dark:text-gray-200 dark:hover:bg-gray-700"
);
const inactiveClass = ref(
  " text-gray-500 hover:bg-blue-100 flex items-center p-2 text-base rounded-lg group"
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
