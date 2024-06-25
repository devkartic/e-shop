<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import CustomButtonDelete from "@/Components/CustomButtonDelete.vue";

const props = defineProps({
    role: Object
})

const current_role = ref({...props.role}).value

const confirmingDeletion = ref(false);

const form = useForm({
    id: current_role.id ?? '',
});

const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const deleteHandler = () => {
    form.delete(route('roles.destroy', current_role.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <CustomButtonDelete @click="confirmDeletion">Delete</CustomButtonDelete>

        <Modal :show="confirmingDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete <b>{{current_role.name}}</b> role?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once the role is deleted, all of its resources and data will be permanently deleted. Please
                    confirm you would like to permanently delete the role.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteHandler"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
