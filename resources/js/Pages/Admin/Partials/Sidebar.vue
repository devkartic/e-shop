<script setup>
import NavLink from "@/Components/NavLink.vue";
import AdminSidebarLink from "@/Components/AdminSidebarLink.vue";
import {router} from "@inertiajs/vue3";


</script>

<template>
    <aside id="application-sidebar-brand"
           class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed top-0 with-vertical h-screen z-[999] flex-shrink-0 border-r-[1px] w-[270px] border-gray-400 bg-white left-sidebar transition-all duration-300">
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="p-5">
            <Link :href="route('dashboard')" class="text-nowrap">
                <img
                    src="/admin/images/logos/dark-logo.svg"
                    alt="Logo-Dark"
                />
            </Link>
        </div>
        <div class="scroll-sidebar" data-simplebar="">
            <div class="px-6 my-3">
                <nav class=" w-full flex flex-col sidebar-nav">
                    <ul id="sidebarnav" class="text-gray-600 text-sm">
                        <li class="text-xs font-bold pb-4">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span>HOME</span>
                        </li>

                        <li class="sidebar-item">
                            <AdminSidebarLink
                                class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-100"
                                :href="route('dashboard')" :active="$page.component === 'Admin/Dashboard'"
                            >
                                <i class="ti ti-layout-dashboard text-xl"></i> <span>Dashboard</span>
                            </AdminSidebarLink>
                        </li>

                        <li class="text-xs font-bold my-4">
                            <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                            <span>ACCESS CONTROL</span>
                        </li>

                        <li class="sidebar-item mb-2">
                            <AdminSidebarLink
                                class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-100"
                                :href="route('roles.index')" :active="$page.component === 'Admin/Roles/Index'"
                            >
                                <i class="fa-brands fa-critical-role text-xl"></i> <span>Roles</span>
                            </AdminSidebarLink>
                        </li>

                        <li class="sidebar-item mb-2">
                            <AdminSidebarLink
                                class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-100"
                                :href="route('users.index')" :active="$page.component === 'Admin/Users/Index'"
                            >
                                <i class="fa-solid fa-users text-xl"></i> <span>Users</span>
                            </AdminSidebarLink>
                        </li>

                        <li class="sidebar-item mb-2">
                            <AdminSidebarLink
                                class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-100"
                                :href="route('modules.index')" :active="$page.component === 'Admin/Modules/Index'"
                            >
                                <i class="fa fa-info-circle text-xl"></i> <span>Modules</span>
                            </AdminSidebarLink>
                        </li>

                        <li class="sidebar-item mb-2">
                            <AdminSidebarLink
                                class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-100"
                                :href="route('links.index')" :active="$page.component === 'Admin/Links/Index'"
                            >
                                <i class="fa-solid fa-link text-xl"></i> <span>Links</span>
                            </AdminSidebarLink>
                        </li>

                        <li class="sidebar-item mb-2">
                            <AdminSidebarLink
                                class="sidebar-link gap-3 py-2 px-3 rounded-md w-full flex items-center hover:text-blue-600 hover:bg-blue-100"
                                :href="route('permissions.index')" :active="$page.component === 'Admin/Permission/Index'"
                            >
                                <i class="fa-solid fa-key text-xl"></i> <span>Permissions</span>
                            </AdminSidebarLink>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
        <!-- </aside> -->
    </aside>
</template>
