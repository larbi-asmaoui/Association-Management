
<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
  layout: MainLayout,
};
</script>

<template>
  <div
    class="grid grid-cols-1 px-3 pt-2 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900"
  >
    <!-- Right Content -->
    <div class="col-span-full xl:col-auto">
      <div
        class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
      >
        <div
          class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4"
        >
          <img
            class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0"
            src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fbrandfetch.com%2Flaravel.com&psig=AOvVaw2ouDPWbuL6ySfnaD2xts94&ust=1686672186583000&source=images&cd=vfe&ved=0CBEQjRxqFwoTCOD_g9WNvv8CFQAAAAAdAAAAABAE"
            alt="Jese picture"
          />
          <div>
            <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">
              Profile picture
            </h3>
            <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
              JPG, GIF or PNG. Max size of 800K
            </div>
            <div class="flex items-center space-x-4">
              <button
                type="button"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                <svg
                  class="w-4 h-4 mr-2 -ml-1"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"
                  ></path>
                  <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                </svg>
                Upload picture
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-2">
      <div
        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
      >
        <h3 class="mb-4 text-xl font-semibold dark:text-white">
          Infromations générales
        </h3>
        <form action="#">
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label
                for="first-name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >First Name</label
              >
              <input
                type="text"
                name="first-name"
                id="first-name"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Bonnie"
                required
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label
                for="last-name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Last Name</label
              >
              <input
                type="text"
                name="last-name"
                id="last-name"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Green"
                required
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label
                for="country"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Country</label
              >
              <input
                type="text"
                name="country"
                id="country"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="United States"
                required
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label
                for="city"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >City</label
              >
              <input
                type="text"
                name="city"
                id="city"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="e.g. San Francisco"
                required
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label
                for="address"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Address</label
              >
              <input
                type="text"
                name="address"
                id="address"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="e.g. California"
                required
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Email</label
              >
              <input
                type="email"
                name="email"
                id="email"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="example@company.com"
                required
              />
            </div>

            <div class="col-span-6 sm:col-full">
              <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="submit"
              >
                Save all
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
