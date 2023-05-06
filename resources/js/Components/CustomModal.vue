<template>
    <div>
        <button
            @click="open = true"
            class="px-6 py-3 font-medium tracking-wide text-white bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none"
        >
            {{ title }}
        </button>

        <div
            :class="`modal ${
                !open && 'opacity-0 pointer-events-none'
            } z-50 fixed w-full h-full top-0 left-0 flex items-center justify-center`"
        >
            <div
                @click="open = false"
                class="absolute w-full h-full bg-gray-900 opacity-50 modal-overlay"
            ></div>

            <div
                class="z-50 w-11/12 mx-auto overflow-y-auto bg-white rounded shadow-lg md:max-w-md"
            >
                <div class="px-6 py-4 text-left overflow-y-auto modal-content">
                    <div class="flex items-center justify-between pb-3 mb-4">
                        <p class="text-2xl font-bold">{{ title }}</p>
                        <div
                            class="z-50 cursor-pointer modal-close"
                            @click="open = false"
                        >
                            <svg
                                class="text-black fill-current"
                                xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 18 18"
                            >
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                                />
                            </svg>
                        </div>
                    </div>

                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";

const emit = defineEmits(["close"]);
// const open = ref(false);

defineProps({
    open: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    content: {
        type: String,
        required: true,
    },
    actionText: {
        type: String,
        required: true,
    },
    action: {
        type: Function,
        required: true,
    },
});
</script>
<style>
.modal {
    transition: opacity 0.25s ease;
}

.modal-overlay {
    z-index: -1;
}
</style>
