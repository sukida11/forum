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
import ThemeComponent from "@/Components/ThemeComponent.vue";


const props = defineProps({
    authUser: {type: [Boolean, Object]},
    canLogin: {type: Boolean},
    canRegister: {type: Boolean},
    themes: {type: Array}
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


            <ThemeComponent v-bind:themes="$page.props.themes"></ThemeComponent>

        </AuthenticatedLayout>


</template>
