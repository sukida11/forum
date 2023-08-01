<script setup>
import {usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadCrumbs from "@/Components/BreadCrumbs.vue";
import {Head} from "@inertiajs/vue3";
import ThemeComponent from "@/Components/ThemeComponent.vue";
import ThreadComponent from "@/Components/ThreadComponent.vue";

const props = defineProps({
    themes: {type: [Object, Array]},
    parent_theme: {type: Object},
    parent_themes: {type: [Boolean, Array]},
    threads: {type: [Array, Object]}
})

const breadCrumbLinks = []

usePage().props.parent_themes.forEach(function (value) {
    breadCrumbLinks.push({text: value.title, href: route('theme.show', {theme: value.id})})
})

breadCrumbLinks.push({ text: usePage().props.parent_theme.title, href: route('theme.show', {theme: usePage().props.parent_theme.id}) })

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

        <div class="my-10 text-emerald-600 border-2 border-indigo-700"></div>

        <ThreadComponent :theme="parent_theme" v-bind:threads="usePage().props.threads"></ThreadComponent>

    </AuthenticatedLayout>

</template>
