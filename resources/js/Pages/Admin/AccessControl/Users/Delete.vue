<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import CustomButtonDelete from "@/Components/CustomButtonDelete.vue";

const props = defineProps({
    user: Object
})

const current_element = ref({...props.user}).value

const confirmingUserDeletion = ref(false);

const form = useForm({
    id: current_element.id ?? '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route('users.destroy', current_element.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <CustomButtonDelete @click="confirmUserDeletion">Delete</CustomButtonDelete>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete <b class="text-orange-500">{{current_element.name}}</b> account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once data is deleted, all of its resources and data will be permanently deleted. Please
                    confirm you would like to permanently delete the data.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
