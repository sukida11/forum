<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {nextTick, ref} from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const confirmingCreateTheme = ref(false);

const props = defineProps({
    authUser: {type: Boolean},
    canLogin: {type: Boolean},
    canRegister: {type: Boolean},
    themes: {type: Array}
})

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
    title: ""
})

</script>

<template class="light">
    <Head title="Главная" />
        <AuthenticatedLayout>
            <template #header>
                    <h1 class="font-bold text-indigo-400 text-xl text-gray-800 leading-tight">
                        Forum/IT
                    </h1>
            </template>


            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 border-b-4" v-if="$page.props.auth.user !== null && $page.props.auth.user.role_id === 'admin'">
                            <PrimaryButton @click="confirmCreateTheme">
                                Создать тему
                            </PrimaryButton>
                        </div>
                        <template v-if="themes" v-for="theme in themes">
                            <div class="p-6 text-gray-900 border-b-2">
                                <Link class="underline" :href="route('theme.show', {theme: theme.id})">{{ theme.title }}</Link>
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

        </AuthenticatedLayout>


</template>
