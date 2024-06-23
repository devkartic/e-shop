<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="card">
            <div class="card-body">
                <h4 class="text-gray-600 text-lg font-semibold mb-5">Yearly Breakup</h4>
                <div class="flex gap-6 items-center justify-between">
                    <div class="flex flex-col gap-4">
                        <h3 class="text-[21px] font-semibold text-gray-600">$36,358</h3>
                        <div class="flex items-center gap-1">
                                           <span
                                               class="flex items-center justify-center w-5 h-5 rounded-full bg-teal-400">
											<i class="ti ti-arrow-up-left text-teal-500"></i>
										   </span>
                            <p class="text-gray-600 text-sm font-normal ">+9%</p>
                            <p class="text-gray-500 text-sm font-normal text-nowrap">last year</p>
                        </div>
                        <div class="flex">
                            <div class="flex gap-2 items-center">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                <p class="text-gray-500 font-normal text-xs">2023</p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <p class="text-gray-500 font-normal text-xs">2023</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex  items-center">
                        <div id="breakup"></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
