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
    user_id: usePage().props.auth.user !== null ? usePage().props.auth.user.id : null,
    answer_to: null
})

const confirmingEditAnswer = ref(null)
const contentAnswerInput = ref("");

const tmpAnswerId = {value: null};

let editAnswerId = null;

const user = usePage().props.auth.user
const thread = usePage().props.thread

const confirmEditAnswer = (answer_id) => {
    editAnswerId = answer_id;

    const answer = findAnswer(answer_id);

    editAnswerForm.content = answer.content ?? "";

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
    cancelCreateChildAnswer()
    if (confirm("Вы точно хотите удалить этот ответ?")) {
        router.delete(route('answer.destroy', {answer: answer_id}), {
            preserveScroll: true
        })
    }
}

function findAnswer(id)
{
    let result = null;
    usePage().props.answers.forEach(function (item) {
        if (item.id === id) result = item;
    })
    return result;
}

function cancelCreateChildAnswer()
{
    answerForm.content = "";
    answerForm.answer_to = null;
    tmpAnswerId.value = null;
}

function makeChildAnswer(answer_id, answer)
{
    cancelCreateChildAnswer();
    tmpAnswerId.value = answer.id;
    answerForm.content = `@${answer.user.nickname} `;
    contentAnswerInput.value.focus();
    answerForm.answer_to = answer_id;
}

function answerActionCondition(answer_id)
{

    const answer = findAnswer(answer_id);
    return (user !== null && (user.role_id === 'admin' || thread.user_id === user.id || answer.user.id === user.id));
}

</script>

<template>

    <h1>
        {{tmpAnswerId.value}}
    </h1>
    <div class="p-6 " v-if="$page.props.auth.user !== null">
        <div v-if="answerForm.answer_to !== null" class="flex justify-between">

            <p>
                {{ findAnswer(tmpAnswerId.value).user.nickname }}:<br><br>
                {{ findAnswer(tmpAnswerId.value).content }}
            </p>
            <p class="cursor-pointer" @click.prevent="cancelCreateChildAnswer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </p>
        </div>
        <textarea
            class="rounded-lg w-full h-60"
            placeholder="Ответ"
            name="content"
            v-model="answerForm.content"
            ref="contentAnswerInput"
            @keyup.enter="addAnswer"
        >
        </textarea>
        <InputError :message="answerForm.errors.content"></InputError>
        <PrimaryButton @click.prevent="addAnswer">Отправить</PrimaryButton>
    </div>

    <div class="p-6 border-t-2 border-indigo-600" v-if="$page.props.answers">

        <div v-for="answer in $page.props.answers" class="">
            <template v-if="answer.answer_to === null" class="mb-4 border-b-2 border-indigo-500">
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
                        v-if="answerActionCondition(answer.id)"
                        @click.prevent="confirmEditAnswer(answer.id)"
                    >
                        Редактировать
                    </p>
                    <p
                        class="cursor-pointer"
                        v-if="answerActionCondition(answer.id)"
                        @click.prevent="deleteAnswer(answer.id)"
                    >
                        Удалить
                    </p>

                    <p
                        class="cursor-pointer"
                        @click.prevent="makeChildAnswer(answer.id, answer)"
                    >
                        Ответить
                    </p>
                </div>
                <div v-if="answer.childAnswers !== null" v-for="childAnswer in answer.childAnswers" class="ml-20 mb-4 border-b-2 border-indigo-500">
                    <p class="text-sm text-right">
                        {{ childAnswer.user.nickname }}
                    </p>
                    <p>
                        {{ childAnswer.content }}
                    </p>
                    <p class="text-sm text-right">
                        {{ childAnswer.created_at }}
                    </p>
                    <hr>
                    <div class="flex justify-space space-x-8">
                        <p
                            class="cursor-pointer"
                            v-if="answerActionCondition(childAnswer.id)"
                            @click.prevent="confirmEditAnswer(childAnswer.id)"
                        >
                            Редактировать
                        </p>
                        <p
                            class="cursor-pointer"
                            v-if="answerActionCondition(childAnswer.id)"
                            @click.prevent="deleteAnswer(childAnswer.id)"
                        >
                            Удалить
                        </p>

                        <p
                            class="cursor-pointer"
                            @click.prevent="makeChildAnswer(answer.id, childAnswer)"
                        >
                            Ответить
                        </p>
                    </div>
                </div>

            </template>
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
