<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="flex items-center justify-center flex-wrap">
        <template v-for="(link, key) in links">
            <div
                v-if="link.url === null"
                :key="`${key}-${link.url}`"
                class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray-400"
                :class="{ 'ml-auto': link.label === 'Next' }"
                v-html="link.label"
            ></div>

            <Link
                v-else
                :key="key"
                class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                :class="{
                    'bg-indigo-500 text-white': link.active,
                    'ml-auto': link.label === 'Next',
                }"
                :href="link.url"
                v-html="link.label"
            >
            </Link>
        </template>
    </div>
</template>
