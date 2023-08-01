<script setup>

import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";


defineProps({
    themes: {type: Array},
    parent_theme: {type: [Boolean, Object]}
})

const confirmingCreateTheme = ref(null)

function addTheme()
{
    form.post(route('theme.store'), {
        onSuccess: () => closeModal(),
        onFinish: () => form.reset()
    })
}

const confirmCreateTheme = () => {
    confirmingCreateTheme.value = true;
};

const closeModal = () => {
    confirmingCreateTheme.value = false;

};

const form = useForm({
    title: "",
    parent_id: usePage().props.parent_theme ? usePage().props.parent_theme.id : null
})

const isAdmin = usePage().props.auth.user !== null && usePage().props.auth.user.role_id === 'admin'

function deleteTheme(theme_id, theme_title)
{
    if(!confirm(`Вы уверены что хотите удалить данную тему - ${theme_title}?`)) return 1;
    router.delete(route('theme.destroy', {theme: theme_id}))
}


</script>

<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b-4" v-if="isAdmin">
                    <PrimaryButton @click="confirmCreateTheme">
                        Создать тему
                    </PrimaryButton>
                </div>
                <template v-if="themes" v-for="theme in themes">
                    <div class="p-6 text-gray-900 border-b-2">
                        <Link class="underline" :href="route('theme.show', {theme: theme.id})">{{ theme.title }}</Link>
                        <div v-if="isAdmin" class="flex">
                            <Link :href="route('theme.edit', {theme: theme.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </Link>
                            <Link href="#" class="ml-3" @click.prevent="deleteTheme(theme.id, theme.title)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>

    <Modal :show="confirmingCreateTheme" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Создание темы
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Вы можете создать тему здесь, для этого просто введите название для неё!
            </p>


            <div class="mt-6">
                <InputLabel for="password" value="Password" class="sr-only" />

                <TextInput
                    id="title"
                    ref="titleInput"
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Название темы"
                    @keyup.enter="addTheme"
                />

                <InputError :message="form.errors.title" class="mt-2" />
            </div>

            <div class="mt-6">
                <PrimaryButton @click.prevent="addTheme">
                    Создать
                </PrimaryButton>
            </div>

        </div>
    </Modal>
</template>

<style scoped>

</style>
