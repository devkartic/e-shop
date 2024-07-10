<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import CustomButtonSubmit from "@/Components/CustomButtonSubmit.vue";
import CustomButtonEdit from "@/Components/CustomButtonEdit.vue";
import Checkbox from "@/Components/Checkbox.vue";

const isOpeningModal = ref(false);

const props = defineProps({
    role: Object,
    link: Object
})

const current_elements = ref({...props.link}).value

const form = useForm({
    role_id: props.role.id,
    index: Boolean(current_elements.index) ?? false,
    create: Boolean(current_elements.create) ?? false,
    edit: Boolean(current_elements.edit) ?? false,
    destroy: Boolean(current_elements.destroy) ?? false,
});
const openModal = () => {
    isOpeningModal.value = true;
};

const formSubmit = () => {
    form.patch(route('permissions.update', current_elements.id), {
        preserveState: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset()
    });
};

const closeModal = () => {
    isOpeningModal.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">

        <CustomButtonEdit @click="openModal">Edit</CustomButtonEdit>

        <Modal :show="isOpeningModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    <span class="text-red-500">{{ props.role.name }}</span> Permission Edit for <span class="text-red-500">{{ current_elements.name }}</span> feature
                </h2>

                <div class="mt-3">
                    <form @submit.prevent="formSubmit">
                        <!-- Permissions -->
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                            <tr>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center">
                                        <div class="text-sm font-bold text-gray-600">Show</div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center">
                                        <div class="text-sm font-bold text-gray-600">Create</div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center">
                                        <div class="text-sm font-bold text-gray-600">Update {{  current_elements.role_id }}</div>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center">
                                        <div class="text-sm font-bold text-gray-600">Delete</div>
                                    </div>
                                </td>
                            </tr>
                            </thead>
                            <tbody class="bg-white border border-200">
                            <tr>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center items-center">
                                        <Checkbox name="index" v-model:checked="form.index"
                                                  class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center items-center">
                                        <Checkbox name="create" v-model:checked="form.create"
                                                  class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center items-center">
                                        <Checkbox name="edit" v-model:checked="form.edit"
                                                  class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500"/>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border border-200">
                                    <div class="flex justify-center items-center">
                                        <Checkbox name="destory" v-model:checked="form.destroy"
                                                  class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500"/>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- button -->
                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>

                            <CustomButtonSubmit
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Update
                            </CustomButtonSubmit>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
    </section>
</template>
