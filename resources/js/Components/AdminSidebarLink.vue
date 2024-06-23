<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: Boolean
});

</script>

<template>
    <Link :class="{'font-bold text-blue-600 bg-blue-100': props.active}">
        <slot />
    </Link>
</template>
