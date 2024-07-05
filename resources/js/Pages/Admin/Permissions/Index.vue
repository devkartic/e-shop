<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

let props = defineProps({
    roles: Object,
});

const formRole = useForm({
    role_id: ''
});

const roleChangeHandler = () => {
    router.get('/permissions', {role_id: formRole.role_id}, {
        preserveState: true,
        replace: true
    });
};

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-between mb-6">
            <form class="w-full" @change.prevent="roleChangeHandler">
                <!-- Module -->
                <div class="mb-4">
                    <InputLabel for="role_id" value="Role" class="block text-sm font-bold mb-2 text-gray-600" />
                    <select v-model="formRole.role_id" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select One</option>
                        <option v-for="role in props.roles" :value="role.id">{{ role.name }}</option>
                    </select>
                    <InputError class="mt-2" :message="formRole.errors.role_id" />
                </div>
            </form>
        </div>
        <div class="mt-6">

        </div>
        <div class="flex flex-col mt-3">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 lg:rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
