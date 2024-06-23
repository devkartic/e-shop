<script setup>
import Header from "@/Pages/Admin/Partials/Header.vue";
</script>

<template>
    <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <slot name="header" />
        </div>
    </header>

    <!-- Page Content -->
    <main>
        <!--start the project-->
        <div id="main-wrapper" class=" flex">
            <div class="flex flex-col w-full  overflow-hidden relative min-h-screen radial-gradient items-center justify-center g-0 px-4">
                <div class="justify-center items-center w-full card lg:flex max-w-md ">
                    <div class=" w-full card-body">
                        <a href="../" class="py-4 block"><img src="/admin/images/logos/dark-logo.svg" alt="" class="mx-auto"/></a>
                        <p class="mb-4 text-gray-500 text-sm text-center">Your Social Campaigns</p>
                        <!-- Main Content -->
                        <slot/>
                        <!-- Main Content End -->
                    </div>
                </div>
            </div>

        </div>
        <!--end of project-->

    </main>
</template>
