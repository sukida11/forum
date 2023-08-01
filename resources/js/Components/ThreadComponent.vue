<script setup>

import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import {reactive, ref} from "vue";
import {Quill, QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {VueEditor} from "vue3-editor";
import DisabledPrimaryButton from "@/Components/DisabledPrimaryButton.vue";

defineProps({
    theme: {type: Object},
    threads: {}
})

const confirmingCreateThread = ref(null)
const titleInput = ref(null)
const contentInput = ref(null)

function addThread()
{
    form.post(route('thread.store'), {
        onSuccess: () => closeModal(),
        onFinish: () => form.reset()
    })
}

const confirmCreateThread = () => {
    confirmingCreateThread.value = true;
};

const closeModal = () => {
    confirmingCreateThread.value = false;

};

let content = reactive({
    content: null
});

const form = useForm({
    title: "",
    content: "",
    user_id: usePage().props.auth.user !== null ? usePage().props.auth.user.id : null,
    theme_id: usePage().props.parent_theme.id,

})

const isAuth = usePage().props.auth.user !== null && usePage().props.auth.user.role_id === 'admin'

function deleteThread(thread_id, thread_title)
{
    if(!confirm(`Вы уверены что хотите удалить данную тему - ${thread_title}?`)) return 1;
    router.delete(route('theme.destroy', {theme: thread_id}))
}

</script>

<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b-4" >
                    <h1 class="m-3 font-bold text-2xl">Трэды</h1>


                    <DisabledPrimaryButton v-if="$page.props.auth.user === null">
                        Создать трэд
                    </DisabledPrimaryButton>

                    <PrimaryButton @click="confirmCreateThread" v-else>
                        Создать трэд
                    </PrimaryButton>

                </div>
                <template v-if="threads" v-for="thread in threads">
                    <div class="p-6 text-gray-900 border-b-2">
                        <Link class="underline" :href="route('thread.show', {thread: thread.id})">{{ thread.title }}</Link>

                    </div>
                </template>

            </div>
        </div>
    </div>

    <Modal  :show="confirmingCreateThread" @close="closeModal">

        <div class="p-6" v-if="$page.props.auth.user === null">
            <h2 class="text-lg font-medium text-gray-900">
                Для начала вам нужно авторизоваться!
            </h2>
        </div>

        <div class="p-6" v-else>
            <h2 class="text-lg font-medium text-gray-900">
                Создание трэда
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Вы можете создать трэд здесь, для этого просто введите название и содержание!
            </p>


            <div class="mt-6">
                <InputLabel for="title" value="Название" class="sr-only" />

                <TextInput
                    id="title"
                    ref="titleInput"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Название трэда"
                    @keyup.enter="addThread"
                />

                <InputError :message="form.errors.title" class="mt-2" />
            </div>
            <div class="mt-6">
                <InputLabel for="content" value="Текст" class="sr-only" />

                <VueEditor
                    v-model="form.content"
                ></VueEditor>

                <InputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="mt-6">
                <PrimaryButton @click.prevent="addThread">
                    Создать
                </PrimaryButton>
            </div>

        </div>
    </Modal>
</template>
