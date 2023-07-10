<template>
    <button
        @click="isModalOpen = true"
        class="rounded-full fixed bottom-8 z-50 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
        type="button"
        :class="$i18n.locale === 'ar' ? 'left-5' : 'right-5'"
    >
        <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd"
            ></path>
        </svg>
    </button>

    <div class="bg-white pt-6 shadow-md rounded-xl relative mt-5">
        <!-- Start  -->
        <div
            class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
        >
            <h2
                class="text-xl font-semibold text-white"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                {{ $t("adherents.titre") }}
            </h2>
        </div>
        <!-- End -->
        <div
            class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        >
            <div class="px-2 w-full flex items-center mb-4 gap-4 sm:mb-0">
                <button
                    @click="exportToPDF"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button"
                >
                    {{ $t("adherents.export_pdf") }}
                </button>
                <button
                    @click="generateIDCards(adherents)"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button"
                >
                    {{ $t("adherents.print_cards_adhesion") }}
                </button>
                <button
                    @click="checkActive"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button"
                >
                    Check if actve or not
                </button>
                <select
                    id="type"
                    class="bg-gray-50 border mr-auto border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                    <option value="">
                        {{ $t("dashboard.select_year") }}
                    </option>
                    <!-- <option v-for="year in yearsList" :value="year" :key="year">
                        {{ year }}
                    </option> -->
                </select>
            </div>
        </div>
        <Modal size="5xl" v-if="isModalOpen" @close="closeModal">
            <template #header>
                <div
                    class="flex items-center text-lg"
                    :class="
                        $i18n.locale === 'ar' ? 'justify-end' : 'justify-start'
                    "
                >
                    {{ $t("adherents.modal_ajouter") }}
                </div>
            </template>
            <template #body>
                <form
                    class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
                    @submit.prevent="submit"
                >
                    <div>
                        <label
                            for="avatar"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >{{ $t("adherents.input_image") }}
                        </label>
                        <ImageUpload
                            v-model="form.image"
                            :default-src="defaultImg"
                        />
                        <span
                            v-if="form.errors.image"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.image }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="last_name"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_nom")
                                }}<span class="text-red-600">*</span>
                            </label>
                            <input
                                v-model="form.last_name"
                                type="text"
                                name="last_name"
                                id="last_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <span
                                v-if="form.errors.last_name"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.last_name }}
                            </span>
                        </div>

                        <div>
                            <label
                                for="first_name"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_prenom")
                                }}<span class="text-red-600">*</span>
                            </label>
                            <input
                                v-model="form.first_name"
                                type="text"
                                name="first_name"
                                id="first_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <span
                                v-if="form.errors.first_name"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.first_name }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="cin"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_cin") }}</label
                            >
                            <input
                                v-model="form.cin"
                                type="text"
                                name="cin"
                                id="cin"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <span
                                v-if="form.errors.cin"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.cin }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="Sexe"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_sexe")
                                }}<span class="text-red-600">*</span></label
                            >
                            <select
                                v-model="form.sexe"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">اختر الجنس</option>
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                            <span
                                v-if="form.errors.sexe"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.sexe }}
                            </span>
                        </div>

                        <div>
                            <label
                                for="profession"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_profession")
                                }}<span class="text-red-600">*</span></label
                            >
                            <input
                                v-model="form.profession"
                                type="text"
                                name="profession"
                                id="profession"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <span
                                v-if="form.errors.profession"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.profession }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="situation"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_situation_familiale")
                                }}<span class="text-red-600">*</span></label
                            >
                            <select
                                v-model="form.situation_familiale"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">
                                    اختر الحالة العائلية
                                </option>
                                <option value="متزوج">متزوج</option>
                                <option value="عازب">عازب</option>
                                <option value="مطلق">مطلق</option>
                                <option value="أرمل">أرمل</option>
                            </select>
                            <span
                                v-if="form.errors.situation_familiale"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.situation_familiale }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="tel"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_telephone") }}</label
                            >
                            <input
                                v-model="form.tel"
                                type="text"
                                name="tel"
                                id="tel"
                                autocomplete="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <span
                                v-if="form.errors.tel"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.tel }}
                            </span>
                        </div>

                        <div>
                            <label
                                for="email"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_email") }}</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                name="email"
                                id="email"
                                autocomplete="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <span
                                v-if="form.errors.email"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.email }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="date_of_birth"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_date_naissance")
                                }}<span class="text-red-600">*</span>
                            </label>

                            <input
                                v-model="form.date_of_birth"
                                type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                                placeholder="Select date"
                                name="date_of_birth"
                            />
                            <span
                                v-if="form.errors.date_of_birth"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.date_of_birth }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="date_of_membership"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_date_adhesion")
                                }}<span class="text-red-600">*</span>
                            </label>

                            <input
                                v-model="form.date_of_membership"
                                type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                                placeholder="Select date"
                                name="date_of_membership"
                            />
                            <span
                                v-if="form.errors.date_of_membership"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.date_of_membership }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label
                            for="hs-about-hire-us-1"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >{{ $t("adherents.input_addresse")
                            }}<span class="text-red-600">*</span></label
                        >
                        <textarea
                            v-model="form.address"
                            id="address"
                            name="address"
                            rows="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                        ></textarea>
                        <span
                            v-if="form.errors.address"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.address }}
                        </span>
                    </div>

                    <div>
                        <label
                            for="region"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >Statut</label
                        >
                        <select
                            v-model="form.statut_id"
                            id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        >
                            <option disabled value="">
                                Séléctionner statut
                            </option>
                            <option
                                v-for="statut in status"
                                :key="statut.id"
                                :value="statut.id"
                            >
                                {{ statut.name }}
                            </option>
                        </select>
                        <!-- <span
                                    v-if="form.errors.region"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.region }}
                                </span> -->
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="region"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_region")
                                }}<span class="text-red-600">*</span></label
                            >
                            <select
                                v-model="form.region"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">اختر جهة</option>
                                <option
                                    v-for="region in regions"
                                    @change="filterCities"
                                    :key="region.id"
                                    :value="region.name"
                                >
                                    {{ region.name }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.region"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.region }}
                            </span>
                        </div>

                        <div>
                            <label
                                for="city"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_ville")
                                }}<span class="text-red-600">*</span></label
                            >
                            <select
                                v-model="form.city"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">اختر مدينة</option>
                                <option
                                    v-for="city in filteredCities"
                                    :key="city.id"
                                    :value="city"
                                >
                                    {{ city }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.city"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.city }}
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="frais_adhesion"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("adherents.input_montant_adhesion")
                                }}<span class="text-red-600">*</span></label
                            >
                            <input
                                v-model="form.montant"
                                type="number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                                name="frais_adhesion"
                                min="1"
                                step="0.01"
                            />
                            <span
                                v-if="form.errors.montant"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.montant }}
                            </span>
                        </div>
                        <div></div>
                    </div>
                    <div class="flex justify-end gap-x-2 mt-4">
                        <button
                            @click="closeModal"
                            type="button"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm :bg-slate-900 :hover:bg-slate-800 :border-gray-700 :text-gray-400 :hover:text-white :focus:ring-offset-gray-800"
                        >
                            {{ $t("buttons.annuler") }}
                        </button>
                        <button
                            type="submit"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
                        >
                            {{ $t("buttons.enregistrer") }}
                        </button>
                    </div>
                </form>
            </template>
        </Modal>

        <div class="mt-4">
            <vue-good-table
                :columns="columns"
                :rows="rows"
                :pagination-options="{
                    enabled: true,
                    perPage: 5,
                    perPageDropdown: [5, 10, 20],
                }"
                :search-options="{
                    enabled: true,
                    placeholder: $t('adherents.table_search'),
                }"
            >
                <template v-slot:table-row="{ row, column, formattedRow }">
                    <div v-if="column.field === 'actions'" class="flex">
                        <div
                            @click="show(row)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                ></path>
                            </svg>
                        </div>

                        <!-- Delete -->

                        <div
                            @click="destroy(row)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                ></path>
                            </svg>
                        </div>
                        <!--  -->
                        <div
                            @click="generateSingleIDCard(row.id)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-printer"
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
                                    d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"
                                ></path>
                                <path
                                    d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"
                                ></path>
                                <path
                                    d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <div v-if="column.field === 'image'" class="flex">
                        <img
                            class="w-10 h-10 rounded-full"
                            :src="showImage(row)"
                        />
                    </div>
                    <div
                        v-if="column.field === 'is_actif'"
                        class="flex items-center justify-center"
                    >
                        <div
                            v-if="row.is_actif === 1"
                            class="h-2.5 w-2.5 rounded-full bg-green-500"
                        ></div>
                        <div
                            v-else
                            class="h-2.5 w-2.5 rounded-full bg-red-500"
                        ></div>
                    </div>
                    <div v-else>
                        {{ formattedRow[column.field] }}
                    </div>
                </template>
            </vue-good-table>
        </div>
    </div>
    <!-- <div class="w-5 h-5">
        <Cropper
            src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8fDA%3D&w=1000&q=80"
            @change="change"
        />
    </div> -->
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
    methods: {},
};
</script>

<script setup>
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
import defaultImg from "../../../assets/image.jpeg";
import { ref, nextTick, computed, onMounted } from "vue";
import { watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { Avatar } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import ImageUpload from "../../Components/ImageUpload.vue";
import { Modal } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import printJS from "print-js";

import JsonCSV from "vue-json-csv";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import regionsFile from "../../regions.json";
import { useI18n } from "vue-i18n";
import QRCode from "qrcode";
const { t, availableLocales, locale } = useI18n();

let isModalOpen = ref(false);
const $toast = useToast();
const page = usePage();
const props = defineProps({
    adherents: {
        type: Object,
        default: () => ({}),
    },

    status: {
        type: Object,
        default: () => ({}),
    },
});
const regions = ref(regionsFile);
const columns = ref([
    {
        label: "#",
        field: "image",
    },
    {
        label: t("adherents.table_nom_complete"),
        field: "nom_complet",
    },
    {
        label: t("adherents.table_cin"),
        field: "cin",
    },
    {
        label: t("adherents.table_profession"),
        field: "profession",
    },
    {
        label: t("adherents.table_situation_familiale"),
        field: "situation_familiale",
    },
    {
        label: t("adherents.table_telephone"),
        field: "tel",
    },
    {
        label: t("adherents.table_statut_adhesion"),
        field: "is_actif",
        filterOptions: {
            placeholder: "الكل",
            enabled: true,
            filterDropdownItems: [
                { value: 0, text: "غير نشط" },
                { value: 1, text: "نشط" },
            ], //only trigger on enter not on keyup
        },
    },
    {
        label: t("adherents.table_actions"),
        field: "actions",
    },
]);
const rows = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        id: adherent.id,
        image: adherent.image,
        nom_complet: adherent.first_name + " " + adherent.last_name,
        profession: adherent.profession ?? "غير محدد",
        situation_familiale: adherent.situation_familiale,
        cin: adherent.cin ?? "-",
        tel: adherent.tel,
        is_actif: adherent.is_actif,
    }))
);

const form = useForm({
    image: null,
    first_name: null,
    last_name: null,
    date_of_birth: null,
    date_of_membership: null,
    sexe: null,
    cin: null,
    profession: null,
    situation_familiale: null,
    address: null,
    region: null,
    city: null,
    tel: null,
    statut_id: null,
    montant: null,
});

const generateSingleIDCard = (id) => {
    const adherents = props.adherents.filter((adherent) => adherent.id === id);
    generateIDCards(adherents);
};

const generateIDCards = async (adherents = props.adherents) => {
    // filter the same array is_adherent === 1
    adherents = adherents.filter((adherent) => adherent.is_actif === 1);

    if (adherents.length === 0) {
        alert("لا يوجد أعضاء للطباعة");
        return;
    }

    const doc = new jsPDF();

    // Step 1: Load the Arabic font file
    const arabicFontFile = "/fonts/Amiri-Regular.ttf";
    const arabicFontName = "Amiri";

    doc.addFont(arabicFontFile, "Amiri", "normal");

    // const adherents = props.adherents;
    for (let i = 0; i < adherents.length; i += 8) {
        if (i !== 0) {
            doc.addPage(); // Add a new page for each set of four adherents except the first set
        }

        const remainingAdherents = adherents.slice(i);
        const cardsToPrint =
            remainingAdherents.length >= 2
                ? remainingAdherents.slice(0, 8)
                : remainingAdherents;

        for (let j = 0; j < cardsToPrint.length; j++) {
            const adherent = cardsToPrint[j];

            const cardText = `${adherent.id}\nالاسم والنسب : ${adherent.first_name} ${adherent.last_name}\n${adherent.date_of_birth} :  تاريخ الميلاد\n${adherent.date_of_membership} :  تاريخ الإنخراط\nالمهنة : ${adherent.profession}`;

            const qrCode = await QRCode.toDataURL(cardText);

            const x = j % 2 ? 110 : 10;
            const y = Math.floor(j / 2) * 60 + 10;

            doc.setDrawColor(0);
            doc.setLineWidth(0.5);
            doc.rect(x, y, 80, 50, "S"); // Adjust the coordinates and size of the rectangle for the ID card
            doc.setFont(arabicFontName);
            doc.setFontSize(10);
            doc.text(cardText, x + 76, y + 28, { align: "right" });

            const qrImg = new Image();
            qrImg.src = qrCode;
            doc.addImage(qrImg, "PNG", x + 2, y + 34, 14, 14);

            const profileImg = new Image();
            profileImg.src = "/storage/" + adherent.image;
            const profileImgX = x + 63;
            const profileImgY = y + 4;
            const profileImgSize = 13;

            // Clip the image to a circle
            doc.setLineWidth(0.2);
            doc.setDrawColor(0);
            doc.circle(
                profileImgX + profileImgSize / 2,
                profileImgY + profileImgSize / 2,
                profileImgSize / 2,
                "S"
            );
            doc.clip(); // Apply the clipping path

            // Add the rounded profile image
            doc.addImage(
                profileImg,
                "PNG",
                profileImgX,
                profileImgY,
                profileImgSize,
                profileImgSize
            );

            doc.rect(
                profileImgX,
                profileImgY,
                profileImgSize,
                profileImgSize,
                "S"
            );
            // Reset the clipping path

            const logoPath = page.props.auth.user.association.image;
            if (logoPath !== null) {
                const logoImg = new Image();
                logoImg.src = "/storage/" + logoPath;
                const logoImgX = x + 2;
                const logoImgY = y + 4;
                const logoImgSize = 15;
                // Create a rounded clipping path for logo image
                doc.setLineWidth(0.1);
                doc.setDrawColor(0);
                doc.circle(
                    logoImgX + logoImgSize / 2,
                    logoImgY + logoImgSize / 2,
                    logoImgSize / 2,
                    "S"
                );

                doc.clip();
                doc.addImage(
                    logoImg,
                    "PNG",
                    logoImgX,
                    logoImgY,
                    logoImgSize,
                    logoImgSize
                );
                doc.rect(logoImgX, logoImgY, logoImgSize, logoImgSize, "S");
            }

            // doc.addImage(logoImg, "PNG", x + 5, y + 4, 15, 15);
        }
    }
    console.log(import.meta.env.VITE_APP_URL);
    doc.save("ID_Cards.pdf");
};

const exportToPDF = () => {
    // Create a new jsPDF instance
    const doc = new jsPDF();
    const pageWidth = doc.internal.pageSize.getWidth();
    // Add the image to the PDF
    const img = doc.addImage(
        `/storage/${page.props.auth.user.association.image}`,
        "JPEG",
        (pageWidth - 30) / 2,
        2,
        30,
        30
    );

    doc.setFontSize(10);
    const title = `${page.props.auth.user.association.name}`;
    const titleWidth = doc.getTextWidth(title);

    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 32);
    doc.setFontSize(9);
    doc.text("Liste de membres", 10, 43);
    doc.line(0, 45, 400, 45);
    // Define the table headers and data
    const headers = [
        "ID",
        "Nom",
        "Prenom",
        "CIN",
        "Telephone",
        "Date d'adhesion",
        " ",
        //
    ];

    const data = props.adherents.map((adherent) => [
        adherent.id,
        adherent.last_name,
        adherent.first_name,
        adherent.cin,
        adherent.tel,
        adherent.date_of_membership,
        "  ",
    ]);

    // Add the table to the PDF
    doc.autoTable({
        margin: { top: 50 },
        head: [headers],
        body: data,
    });

    // Save the PDF
    doc.save("membres_list.pdf");
};

const csvFields = ref({
    separator: ",",
    labels: {
        first_name: "First Name",
        last_name: "Last Name",
        is_actif: "Active Status",
        cin: "CIN",
        sexe: "Gender",
        date_of_birth: "Date of Birth",
        date_of_membership: "Date of Membership",
        address: "Address",
        tel: "Phone Number",
        email: "Email Address",
    },
});

const filteredCities = computed(() => {
    if (form.region) {
        const regionData = regions.value.find(
            (region) => region.name === form.region
        );
        if (regionData) {
            return regionData.cities_list;
        }
    }
    return [];
});

const filterCities = () => {
    form.city = "";
};

const showImage = (adherent) => {
    return "/storage/" + adherent.image;
};

const show = (id) => {
    router.get(route("adherents.show", id));
};

const destroy = (id) => {
    if (confirm("Are you sure to delete?")) {
        router.delete(route("adherents.destroy", id), {
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la suppression d'adhérent",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onSuccess: () => {
                $toast.open({
                    message: "adhérent est supprimé avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

const checkActive = () => {
    router.post(route("adherents.desactivate"), {
        onSuccess: () => {
            $toast.open({
                message: "تم تعطيل العضو بنجاح",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            $toast.open({
                message: "حدث  خطأ أثناء تعطيل العضو",
                type: "error",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

const submit = () => {
    form.post(route("adherents.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "adhérent est ajouté avec succès",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            $toast.open({
                message: "Erreur lors de l'ajout d'adhérent",
                type: "error",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};
</script>

<style scoped>
#my-doc {
    font: 33rem;
}

/* #id-card {
    border: 1px solid #000;
    padding: 10px;
    margin-bottom: 20px;
} */

.card-info {
    font-size: 14px;
}

.card-info strong {
    font-weight: bold;
}

/* #qr-code {
    width: 10px;
    height: 10px;
    margin-top: 10px;
} */
</style>
