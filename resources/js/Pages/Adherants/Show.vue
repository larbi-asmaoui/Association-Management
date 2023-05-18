<template>
    <div class="overflow-hidden bg-white shadow-sm rounded-lg">
        <div class="p-6">
            <div
                class="flex items-center space-x-2 font-semibold text-gray-900 leading-8"
            >
                <span clas="text-green-500">
                    <svg
                        class="h-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        ></path>
                    </svg>
                </span>
                <span class="tracking-wide">Informations d'adherant</span>
            </div>
            <div class="text-gray-700">
                <div class="grid md:grid-cols-2 text-sm">
                    <div class="col-span-full mb-5">
                        <img
                            :src="showImage() + adherant.image"
                            class="object-cover h-40 w-40 rounded-full mx-auto"
                        />
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Prenom</div>
                        <div class="px-4 py-2">{{ adherant.first_name }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Nom</div>
                        <div class="px-4 py-2">{{ adherant.last_name }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Sexe</div>
                        <div class="px-4 py-2">{{ adherant.sexe }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Telephone</div>
                        <div class="px-4 py-2">{{ adherant.tel }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Addresse</div>
                        <div class="px-4 py-2">
                            {{ adherant.address }}
                        </div>
                    </div>
                    <!-- <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Email</div>
                        <div class="px-4 py-2">
                            {{ adherant.email }}
                        </div>
                    </div> -->
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">
                            Date de naissance
                        </div>
                        <div class="px-4 py-2">
                            {{ adherant.date_of_birth }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ___________________________________________________ -->

        <div
            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
        >
            <!-- <div class="mr-3">
                <div class="text-sm text-gray-600" style="display: none">
                    Saved.
                </div>
            </div> -->

            <div class="mr-3">
                <button
                    @click="
                        $inertia.visit(route('adherants.edit', adherant.id))
                    "
                    type="button"
                    class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-edit"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"
                        />
                        <path
                            d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"
                        />
                        <line x1="16" y1="5" x2="19" y2="8" />
                    </svg>
                </button>
            </div>
            <button
                @click="destroy(adherant.id)"
                type="button"
                class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-trash"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="#fff"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="4" y1="7" x2="20" y2="7" />
                    <line x1="10" y1="11" x2="10" y2="17" />
                    <line x1="14" y1="11" x2="14" y2="17" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({});

const props = defineProps({
    adherant: {
        type: Object,
    },
});

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("adherants.destroy", id));
    }
};

const showImage = () => {
    return "/storage/";
};
</script>
