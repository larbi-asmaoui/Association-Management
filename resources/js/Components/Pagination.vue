<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <div
        v-if="data.links.length > 3"
        class="flex justify-center mt-4 space-x-4"
    >
        <Link
            v-for="(link, k) in data.links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 text-gray-500 hover:text-blue-600 hover:rounded-full"
            :class="{
                ' bg-blue-600 rounded-full text-white hover:text-white':
                    link.active,
            }"
            :href="link.url"
            v-html="link.label"
        />
    </div>
</template>
