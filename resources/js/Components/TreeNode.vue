<script setup>
import {ref} from 'vue';
import Create from "@/Pages/Admin/General/Categories/Create.vue";
import Edit from "@/Pages/Admin/General/Categories/Edit.vue";
import Delete from "@/Pages/Admin/General/Categories/Delete.vue";

const props = defineProps({
    parentItems: Object,
    items: {
        type: Array,
        required: true,
    },
});

const openItems = ref([]);

const toggle = (id) => {
    if (openItems.value.includes(id)) {
        openItems.value = openItems.value.filter((itemId) => itemId !== id);
    } else {
        openItems.value.push(id);
    }
};
const isOpen = (id) => openItems.value.includes(id);

</script>

<template>
    <ul>
        <li v-for="item in items" :key="item.id">
            <div class="flex justify-between border px-5 py-2 my-1" @click="toggle(item.id)">
                <div class="flex gap-2">
                    <div v-if="item.children && item.children.length" class="flex items-center">
                    <span v-if=isOpen(item.id)>
                        <i class="fa fa-angle-down"></i>
                    </span>
                        <span v-else>
                        <i class="fa fa-angle-right"></i>
                    </span>
                    </div>
                    <div class="flex items-center">{{ item.name }}</div>
                </div>
                <div class="flex gap-1">
                    <Create :parentItems="parentItems" :createItem="item.id"/>
                    <Edit :item="item" :parentItems="parentItems"/>
                    <Delete :item="item"/>
                </div>
            </div>
            <TreeNode
                v-if="isOpen(item.id) && item.children && item.children.length"
                :items="item.children" :parentItems="parentItems"
                class="pl-5"
            />
        </li>
    </ul>
</template>
