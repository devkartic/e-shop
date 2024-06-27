<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {debounce} from "lodash";
import {ref, vShow, watch} from "vue";
import Pagination from "@/Pages/Admin/Partials/Pagination.vue";
import CustomButtonInfo from "@/Components/CustomButtonInfo.vue";
import CustomButton from "@/Components/CustomButton.vue";
import Create from "@/Pages/Admin/Modules/Create.vue";
import Edit from "@/Pages/Admin/Modules/Edit.vue";
import Delete from "@/Pages/Admin/Modules/Delete.vue";

let props = defineProps({
    modules: Object,
    filters: Object,
    can: Object
});

let search = ref(props.filters.search);

watch(search, debounce(value => {
    // console.log('Changed ' + value);
    // console.log('triggered');
    router.get('/modules', {search: value}, {
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
                <input v-model="search" type="text" placeholder="Search..."
                       class="border-gray-200 px-2 rounded-s-lg focus:border-0"/>
                <CustomButton class="bg-gray-200 rounded-e-lg text-gray-700" @click="handleClear">Clear</CustomButton>
            </div>
            <Create/>
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
                                        <div class="text-sm font-bold text-gray-600">Status</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold text-gray-600">Order Number</div>
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
                            <tr v-for="module in props.modules.data" :key="module.id">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" v-text="module.name"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                <span v-if="Boolean(module.status)" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                                                <span v-if="!Boolean(module.status)" class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Active</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"
                                                 v-text="module.order_number"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium flex justify-end gap-1">
                                    <Link :href="`/users/${module.id}/edit`">
                                        <CustomButtonInfo>Show</CustomButtonInfo>
                                    </Link>
                                    <Edit :module="module"/>
                                    <Delete :module="module"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--    Pagination-->
        <Pagination :links="props.modules.links" class="mt-6"/>
    </AuthenticatedLayout>

</template>
