<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import TreeNode from "@/Components/TreeNode.vue";
import Create from "@/Pages/Admin/General/Categories/Create.vue";


const props = defineProps(
    {
        categories: {
            type: Array,
        },
    }
);

console.log(props.categories);

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-between mb-3">
            <div class="flex justify-around gap-0.5">
                <div class="mb-4 text-xl font-bold text-gray-900 dark:text-white md:text-2xl lg:text-3xl">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Category</span>
                    List
                </div>
            </div>
            <Create/>
        </div>
        <div class="flex flex-col mt-3">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 lg:rounded-lg">
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-12">
                                <ul class="lg:p-5">
                                    <TreeNode :items="categories"/>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
