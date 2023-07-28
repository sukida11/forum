<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Link} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UserLayout from "@/Layouts/UserLayout.vue";

const props = defineProps({
    authUser: {type: Boolean},
    canLogin: {type: Boolean},
    canRegister: {type: Boolean}
})

console.log(props);

</script>

<template class="light">
    <Head title="Главная" />
    <template v-if="!authUser">
        <UserLayout>
            <div class="text-center mb-4">
               <span class="text-indigo-600 text-lg mt-5">
                    <b>Forum/IT</b>
                </span>
            </div>


        </UserLayout>
    </template>
    <template v-else>
        <AuthenticatedLayout>
            111111 ghahahahahaha qqqq
        </AuthenticatedLayout>
    </template>

</template>
