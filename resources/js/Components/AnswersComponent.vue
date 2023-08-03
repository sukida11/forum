<script setup>

import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {ref} from "vue";

defineProps({
    thread: {type: Object},
    answers: {type: Array}
})

const editAnswerForm = useForm({
    content: '',
})

const answerForm = useForm({
    content: '',
    thread_id: usePage().props.thread.id,
    user_id: usePage().props.auth.user !== null ? usePage().props.auth.user.id : null
})

const confirmingEditAnswer = ref(null)

let editAnswerId = null;

const user = usePage().props.auth.user
const thread = usePage().props.thread

const confirmEditAnswer = (answer_id) => {
    editAnswerId = answer_id;

    const answers = usePage().props.answers;
    answers.forEach(function ($item) {
        if ($item.id === answer_id) editAnswerForm.content = $item.content;
    });

    confirmingEditAnswer.value = true;
}

const closeModal = () => {
    confirmingEditAnswer.value = false;
}

function addAnswer() {
    answerForm.post(route('answer.store'), {
        preserveScroll: true,
        onSuccess: () => answerForm.reset()
    })
}

function editAnswer() {
    editAnswerForm.patch(route('answer.update', {answer: editAnswerId}), {
        onSuccess: () => {
            confirmingEditAnswer.value = false;
            editAnswerForm.reset();
        }
    })
}

function deleteAnswer(answer_id) {
    if (confirm("Вы точно хотите удалить этот ответ?")) {
        router.delete(route('answer.destroy', {answer: answer_id}), {
            preserveScroll: true
        })
    }
}

const answerActionCondition = (user !== null && (user.role_id === 'admin' || thread.user_id === user.id || answer.user.id === user.id));
</script>

<template>


    <div class="p-6 " v-if="$page.props.auth.user !== null">
        <textarea
            class="rounded-lg w-full h-60"
            placeholder="Ответ"
            name="content"
            v-model="answerForm.content"
            @keyup.enter="addAnswer"
        >
        </textarea>
        <InputError :message="answerForm.errors.content"></InputError>
        <PrimaryButton @click.prevent="addAnswer">Отправить</PrimaryButton>
    </div>

    <div class="p-6 border-t-2 border-indigo-600" v-if="$page.props.answers">

        <div v-for="answer in $page.props.answers" class="mb-4 border-b-2 border-indigo-500">
            <p class="text-sm text-right">
                {{ answer.user.nickname }}
            </p>
            <p>
                {{ answer.content }}
            </p>
            <p class="text-sm text-right">
                {{ answer.created_at }}
            </p>
            <hr>
            <div class="flex justify-space space-x-8">
                <p
                    class="cursor-pointer"
                    v-if="answerActionCondition"
                    @click.prevent="confirmEditAnswer(answer.id)"
                >
                    Редактировать
                </p>
                <p
                    class="cursor-pointer"
                    v-if="answerActionCondition"
                    @click.prevent="deleteAnswer(answer.id)"
                >
                    Удалить
                </p>

                <p
                    class="cursor-pointer"
                    v-if="answerActionCondition"
                    @click.prevent="deleteAnswer(answer.id)"
                >
                    Ответить
                </p>
            </div>
            <Modal :show="confirmingEditAnswer" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        Редактирование ответа
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Вы можете отредактировать ваш ответ здесь!
                    </p>


                    <div class="mt-6">
                        <InputLabel for="password" value="Password" class="sr-only"/>

                        <textarea
                            class="mt-1 block w-3/4 rounded-lg h-60"
                            placeholder="Ответ"
                            name="content"
                            id="title"
                            ref="titleInput"
                            type="text"
                            v-model="editAnswerForm.content"
                            @keyup.enter="editAnswer"
                        />

                        <InputError :message="editAnswerForm.errors.content" class="mt-2"/>
                    </div>

                    <div class="mt-6">
                        <PrimaryButton @click.prevent="editAnswer">
                            Сохранить
                        </PrimaryButton>
                    </div>

                </div>
            </Modal>

        </div>

    </div>
</template>
