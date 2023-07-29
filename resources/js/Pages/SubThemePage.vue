<script setup>
import {Link, router, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadCrumbs from "@/Components/BreadCrumbs.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    theme: {type: Object}
})

const breadCrumbLinks = [
    {
        text: usePage().props.theme.title,
        href: '/'
    },
]

</script>

<template>

    <AuthenticatedLayout>
        <Head :title="$page.props.theme.title"></Head>

        <template #header>
            <BreadCrumbs
                v-bind:links="breadCrumbLinks"
            ></BreadCrumbs>

        </template>

    </AuthenticatedLayout>

</template>
