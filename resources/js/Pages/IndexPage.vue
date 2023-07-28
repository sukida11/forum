<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Link} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    authUser: {type: Boolean},
    canLogin: {type: Boolean},
    canRegister: {type: Boolean}
})

</script>

<template class="light">
    <Head title="Главная" />
        <AuthenticatedLayout>
            <div class="text-center mb-4">
               <span class="text-indigo-600 text-lg mt-5">
                    <b>Forum/IT</b>
                </span>
            </div>


        </AuthenticatedLayout>


</template>
