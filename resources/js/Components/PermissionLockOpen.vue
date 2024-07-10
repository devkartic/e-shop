<script setup>
const props = defineProps({
    permission: Boolean
});
</script>

<template>
    <div type="button" v-if="props.permission">
        <i class="fa-solid text-2xl fa-lock-open text-teal-600"></i>
    </div>
    <div type="button" v-else>
        <i class="fa-solid text-2xl fa-lock text-gray-400"></i>
    </div>
</template>
