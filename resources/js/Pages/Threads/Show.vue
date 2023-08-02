<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

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


const answerForm = useForm({
    content: '',
    thread_id: usePage().props.thread.id,
    user_id: usePage().props.auth.user !== null ? usePage().props.auth.user.id : null
})

function addAnswer()
{
    answerForm.post(route('answer.store'), {
        onSuccess: () => answerForm.reset()
    })
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

                    <div class="p-6 " v-if="$page.props.auth.user !== null">
                        <textarea
                            class="rounded-lg w-full h-60"
                            placeholder="Ответ"
                            name="content"
                            v-model="answerForm.content"
                            @keyup.enter="addAnswer"
                        >
                        </textarea>
                        <InputError>{{ answerForm.errors.content }}</InputError>
                        <PrimaryButton @click.prevent="addAnswer">Отправить</PrimaryButton>
                    </div>

                    <div class="p-6 border-t-2 border-indigo-600" v-if="$page.props.answers">

                        <div v-for="answer in $page.props.answers">
                            <p>
                                {{ answer.content }}
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
