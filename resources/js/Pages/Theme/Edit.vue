<script setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    theme: {type:Object}
})

const form = useForm({
    title: usePage().props.theme.title,
    parent_id: null
})

</script>

<template>
<AuthenticatedLayout>
    <Head title="Редактирование темы"></Head>
    <template #header>
        Edit theme - {{theme.title}}
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <InputLabel class="mb-4" for="title" value="Название"></InputLabel>
                    <TextInput v-model="form.title" @keyup.enter="form.patch(route('theme.update', {theme: theme.id}))"></TextInput>
                    <InputError :message="form.errors.title"></InputError>
                </div>
                <div class="p-6 text-gray-900">
                    <PrimaryButton @click.prevent="form.patch(route('theme.update', {theme: theme.id}))">Сохранить</PrimaryButton>
                </div>
            </div>
        </div>
    </div>

</AuthenticatedLayout>
</template>
