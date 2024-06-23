<script setup>

import Sidebar from "@/Pages/Admin/Partials/Sidebar.vue";
import Header from "@/Pages/Admin/Partials/Header.vue";
import Main from "@/Pages/Admin/Partials/Main.vue";
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import CustomAlert from "@/Pages/Admin/Partials/CustomAlert.vue";

const showingNavigationDropdown = ref(false);

</script>

<template>

    <!-- Page Content -->
    <main>
        <!--start the project-->
        <div id="main-wrapper" class=" flex">

            <Sidebar/>

            <div class="w-full page-wrapper overflow-hidden">

                <!--  Header Start -->
                <Header/>
                <!--  Header End -->
                <!--  Alert show start -->
                <CustomAlert/>
                <!--  Alert show end -->
                <!-- Main Content -->
                <main class="h-full overflow-y-auto w-full">
                    <div class="container max-w-full text-sm p-5 xl:px-5">
                        <slot/>
                    </div>
                </main>
                <!-- Main Content End -->

            </div>

        </div>
        <!--end of project-->

    </main>
</template>
