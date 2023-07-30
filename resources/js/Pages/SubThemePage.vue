<script setup>
import {Link, router, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadCrumbs from "@/Components/BreadCrumbs.vue";
import {Head} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import ThemeComponent from "@/Components/ThemeComponent.vue";

const props = defineProps({
    themes: {type: [Object, Array]},
    parent_theme: {type: Object},
    parent_themes: {type: [Boolean, Array]}
})

const breadCrumbLinks = []

console.log(usePage().props.parent_themes);
breadCrumbLinks.push({ text: usePage().props.parent_theme.title, href: route('theme.show', {theme: usePage().props.parent_theme.id}) })
usePage().props.parent_themes.forEach(function (value) {
    breadCrumbLinks.push({text: value.title, href: route('theme.show', {theme: value.id})})
})

</script>

<template>

    <AuthenticatedLayout>
        <Head :title="$page.props.parent_theme.title"></Head>
        <template #header class="flex items-center">
            <BreadCrumbs class="inline-flex"
                v-bind:links="breadCrumbLinks"
                :title="$page.props.parent_theme.title"
            ></BreadCrumbs>


        </template>

       <ThemeComponent
           v-bind:themes="$page.props.themes"
           v-bind:parent_theme="$page.props.parent_theme"
       >

       </ThemeComponent>

    </AuthenticatedLayout>

</template>
