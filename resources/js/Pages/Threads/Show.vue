<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    thread: {type: Object},
    theme: {type: Object}
})

</script>

<template>

    <AuthenticatedLayout>


        <template #header>
            <div class="h-full">
            <Link class="hover:text-gray-300 h-full transition-all ease-in-out" :href="route('theme.show', {theme: $page.props.theme.id})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                &nbsp;
                {{ $page.props.theme.title }}
            </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-b-4">
                        <h1 class="font-bold text-center text-2xl">{{ $page.props.thread.title}}</h1>

                        <p v-html="$page.props.thread.content">
                        </p>

                    </div>

                    <div class="p-6 ">
                        тут остальное
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
