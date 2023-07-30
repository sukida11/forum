<script setup>
import {Link, usePage} from "@inertiajs/vue3";

defineProps({
    links: {type: Array},
    title: {type: String}
})

</script>

<template>
    <ul class="flex text-indigo-400">
        <li class="flex items-center">
            <Link class="inline" :href="route('main.index')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            </Link>

        </li>

        <template v-if="links" v-for="link in links">
            <li class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <Link :href="link.href">{{ link.text }}</Link>
            </li>

        </template>
    </ul>
</template>

<style scoped>

</style>
