<template>
    <button
        type="button"
        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semi-bold rounded-md border border-red-500 text-red-500 hover:border-red-500 hover:text-white hover:bg-red-500"
    >
        <i class="fa fa-trash"></i> <slot/>
    </button>
</template>
