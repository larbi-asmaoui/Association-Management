<template>
    <div
        v-if="showAlert"
        class="fixed bottom-3 right-2 flex items-center justify-center"
    >
        <div class="bg-white border border-gray-300 rounded-md p-4 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg
                        class="h-6 w-6 text-green-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        {{ alertMessage }}
                    </p>
                </div>
                <button
                    @click="closeAlert"
                    class="ml-auto flex-shrink-0 focus:outline-none"
                >
                    <svg
                        class="h-5 w-5 text-gray-400 hover:text-gray-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps } from "vue";

const props = defineProps({
    showAlert: Boolean,
    alertMessage: String,
});

const closeAlert = () => {
    emit("close");
};
</script>
