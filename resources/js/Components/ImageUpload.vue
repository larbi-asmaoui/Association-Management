<template>
    <div>
        <input
            type="file"
            accept="image/*"
            class="hidden"
            ref="fileInputRef"
            @change="change"
        />

        <div class="relative inline-block">
            <img
                :src="src"
                alt="avatar"
                class="h-24 w-24 rounded-full object-cover"
            />
            <div
                class="absolute top-0 h-full w-full rounded-full bg-black bg-opacity-25 flex items-center justify-center"
            >
                <button
                    @click="browse()"
                    class="rounded-full hover:bg-white hover:bg-opacity-25 p-2 focus:outline-none text-white transition duration-200"
                >
                    <div class="h-6 w-6">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-camera"
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
                                d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2"
                            ></path>
                            <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        </svg>
                    </div>
                </button>
                <button
                    v-if="file"
                    @click="remove()"
                    class="rounded-full hover:bg-white hover:bg-opacity-25 p-2 focus:outline-none text-white transition duration-200"
                >
                    <div class="h-6 w-6">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-x"
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
                            <path d="M18 6l-12 12"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, watchEffect, toRefs } from "vue";

export default {
    props: {
        value: File,
        defaultSrc: String,
    },
    setup(props, { emit }) {
        const fileInputRef = ref(null);
        const file = ref(null);
        const src = ref(props.defaultSrc);

        const browse = () => {
            fileInputRef.value.click();
        };

        const change = (e) => {
            file.value = e.target.files[0];
            emit("update:modelValue", file.value);
            let reader = new FileReader();
            reader.readAsDataURL(file.value);
            reader.onload = (e) => {
                src.value = e.target.result;
            };
        };

        const remove = () => {
            file.value = null;
            src.value = props.defaultSrc;
            emit("update:modelValue", file.value);
        };

        watchEffect(() => {
            src.value = props.defaultSrc;
        });

        return {
            ...toRefs(props),
            fileInputRef,
            file,
            src,
            browse,
            change,
            remove,
        };
    },
};
</script>
