<script setup>
</script>
<template>
    <div v-if="$page.props.flash.message" class="w-full px-5">
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex gap-1">
                <p><i class="fa-regular fa-circle-check"></i></p>
                <p class="">{{ $page.props.flash.message }}</p>
            </div>
        </div>
    </div>
</template>
