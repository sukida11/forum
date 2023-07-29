<script setup>
import {Link, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadCrumbs from "@/Components/BreadCrumbs.vue";
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    theme: {type: Object}
})

</script>

<template>

    <AuthenticatedLayout>
        <Head :title="$page.props.theme.title"></Head>

        <template #header>
            <BreadCrumbs
                v-bind:links="[
                    {
                        text: $page.props.theme.title,
                        href: '/'
                    }
                ]"
            ></BreadCrumbs>

        </template>

    </AuthenticatedLayout>

</template>
