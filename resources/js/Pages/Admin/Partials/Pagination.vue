<script setup>
    defineProps({
    links: Array
})
</script>
<template>
    <div class="flex gap-1">
        <Component :is="link.url ? 'Link' : 'span'" v-for="link in links" :href="link.url" v-html="link.label" class="text-gray-700 py-2 px-4 border border-cyan-500 rounded" :class="{ 'bg-transparent': ! link.url, 'bg-cyan-500 text-white border-cyan-500 font-bold' : link.active }"/>
    </div>
</template>
