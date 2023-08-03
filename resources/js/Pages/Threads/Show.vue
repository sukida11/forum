<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, usePage} from "@inertiajs/vue3";
import {router} from "@inertiajs/vue3";
import AnswersComponent from "@/Components/AnswersComponent.vue";

defineProps({
    thread: {type: Object},
    theme: {type: Object},
    answers: {type: [Array, Object]}
})

const user = usePage().props.auth.user
const thread = usePage().props.thread

function deleteThread() {
    if (!confirm("Вы точно хотите удалить этот вопрос?")) return 1;
    router.delete(route('thread.destroy', {thread: usePage().props.thread.id}))
}


</script>

<template>

    <AuthenticatedLayout>


        <template #header>
            <div class="h-full">
                <Link class="hover:text-gray-300 h-full transition-all ease-in-out"
                      :href="route('theme.show', {theme: $page.props.theme.id})">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="inline w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    &nbsp;
                    {{ $page.props.theme.title }}
                </Link>
            </div>
        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-b-2 border-indigo-400">
                        <h1 class="font-bold text-center text-2xl">{{ $page.props.thread.title }}</h1>
                        <p class="text-right">{{ $page.props.thread.created_at }}</p>

                        <p v-html="$page.props.thread.content" style="word-wrap: break-word;">
                        </p>
                    </div>

                    <div class="p-6 border-l-2 border-r-2 border-b-2 border-indigo-400 flex"
                         v-if="user !== null && (user.id === thread.user_id || user.role_id === 'admin')">
                        <Link :href="route('thread.edit', {thread: thread.id})"
                              class="hover:bg-indigo-600 bg-indigo-500 p-4 rounded-xl mr-10">Редактировать
                        </Link>
                        <Link href="#" @click.prevent="deleteThread" class="bg-red-500 hover:bg-red-600 p-4 rounded-xl">
                            Удалить
                        </Link>
                    </div>

                    <AnswersComponent v-bind:answers="$page.props.answers"></AnswersComponent>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
