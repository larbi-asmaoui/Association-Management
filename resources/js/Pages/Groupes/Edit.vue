<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    groupe: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: props.groupe.name,
    description: props.groupe.description,
});

const submit = () => {
    form.put(route("groupes.update", props.groupe.id));
};
</script>

<template>
    <div class="mt-4">
        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-lg font-semibold text-gray-700 capitalize">
                Modifier le groupe
            </h2>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <div>
                        <label class="text-gray-700" for="nom_du_groupe"
                            >Nom de groupe</label
                        >
                        <input
                            v-model="form.name"
                            class="w-full mt-2 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                            type="text"
                        />
                    </div>

                    <div></div>

                    <div>
                        <label class="text-gray-700" for="password"
                            >Description</label
                        >
                        <textarea
                            rows="5"
                            v-model="form.description"
                            class="w-full mt-2 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                        ></textarea>
                    </div>

                    <div></div>
                </div>

                <div class="flex justify-end mt-4">
                    <button
                        type="submit"
                        class="px-4 py-2 text-gray-200 bg-gray-800 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700"
                    >
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
