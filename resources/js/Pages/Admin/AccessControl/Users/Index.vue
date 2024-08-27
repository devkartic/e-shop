<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {debounce} from "lodash";
import {ref, watch} from "vue";
import Pagination from "@/Pages/Admin/Partials/Pagination.vue";
import CustomButtonInfo from "@/Components/CustomButtonInfo.vue";
import CustomButton from "@/Components/CustomButton.vue";
import Create from "@/Pages/Admin/AccessControl/Users/Create.vue";
import Edit from "@/Pages/Admin/AccessControl/Users/Edit.vue";
import Delete from "@/Pages/Admin/AccessControl/Users/Delete.vue";

let props = defineProps({
    users: Object,
    filters: Object,
    can: Object,
    roles: Object
});

let search = ref(props.filters.search);

watch(search, debounce(value => {
    // console.log('Changed ' + value);
    // console.log('triggered');
    router.get('/users', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));
const handleClear = () => search.value = '';

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-between mb-6">
            <div class="flex justify-around gap-0.5">
                <input v-model="search" type="text" placeholder="Search..." class="border-gray-200 px-2 rounded-s-lg focus:border-0"/>
                <CustomButton class="bg-gray-200 rounded-e-lg text-gray-700" @click="handleClear">Clear</CustomButton>
            </div>
            <Create :roles="props.roles"/>
        </div>
        <div class="flex flex-col mt-3">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 lg:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold text-gray-600">Name</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold text-gray-600">Email</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold text-gray-600">Role</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-end">
                                        <div class="text-sm font-bold text-right text-gray-600">Action</div>
                                    </div>
                                </td>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in props.users.data" :key="user.id">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" v-text="user.name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" v-text="user.email"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" v-text="user.role"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium flex justify-end gap-1">
                                    <Link :href="`/users/${user.id}/edit`">
                                        <CustomButtonInfo>Show</CustomButtonInfo>
                                    </Link>
                                    <Edit :user="user" :roles="props.roles"/>
                                    <Delete :user="user"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--    Pagination-->
        <Pagination :links="props.users.links" class="mt-6"/>
    </AuthenticatedLayout>

</template>
