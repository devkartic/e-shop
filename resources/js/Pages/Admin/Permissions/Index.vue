<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Edit from "@/Pages/Admin/Permissions/Edit.vue";
import PermissionLockOpen from "@/Components/PermissionLockOpen.vue";

let props = defineProps({
    roles: Object,
    filters: Object
});

const form = useForm({
    role_id: props.filters.role.id,
});

const onchangeHandler = () => {
    router.get('/permissions', {role_id: form.role_id}, {
        preserveState: false,
        replace: true,
    });
};


</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-between mb-6">
            <form class="w-full" @change.prevent="onchangeHandler">
                <!-- Module -->
                <div class="mb-4">
                    <InputLabel for="role_id" value="Role" class="block text-sm font-bold mb-2 text-gray-600"/>
                    <select v-model="form.role_id"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0">
                        <option value="">Select One</option>
                        <option v-for="role in props.roles" :value="role.id">{{ role.name }}</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="flex flex-col mt-3">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div v-if="props.filters.data" class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 lg:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold text-gray-600">Link</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <div class="text-sm font-bold text-gray-600">Show</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <div class="text-sm font-bold text-gray-600">Create</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <div class="text-sm font-bold text-gray-600">Update</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <div class="text-sm font-bold text-gray-600">Delete</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <div class="text-sm font-bold text-gray-600">Action</div>
                                    </div>
                                </td>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="link in props.filters.data" :key="link.id">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" v-text="link.name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <PermissionLockOpen :permission="link.index"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <PermissionLockOpen :permission="link.create"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <PermissionLockOpen :permission="link.edit"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <PermissionLockOpen :permission="link.destroy"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex justify-center items-center">
                                        <Edit :link="link" :role="props.filters.role"/>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--    Pagination-->
        <!--        <Pagination :links="props.links.links" class="mt-6"/>-->
    </AuthenticatedLayout>

</template>
