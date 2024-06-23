<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import CustomButtonSubmit from "@/Components/CustomButtonSubmit.vue";
import CustomButtonEdit from "@/Components/CustomButtonEdit.vue";

const isOpeningModal = ref(false);

const props = defineProps({
    user: Object
})

const currentUser = ref({...props.user}).value

const form = useForm({
    name: currentUser.name ?? '',
    email: currentUser.email ?? '',
    password: '',
    password_confirmation: '',
});

const openModal = () => {
    isOpeningModal.value = true;
};

const formSubmit = () => {
    form.patch(route('users.update', currentUser.id), {
        preserveScroll: true,
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
                    User Edit
                </h2>

                <div class="mt-6">
                    <form @submit.prevent="formSubmit">
                        <!-- username -->
                        <div class="mb-4">
                            <InputLabel for="name" value="Name" class="block text-sm font-semi-bold mb-2 text-gray-600" />

                            <TextInput
                                id="name"
                                type="text"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />

                        </div>
                        <!-- Email -->
                        <div class="mb-4">
                            <InputLabel for="email" value="Email" class="block text-sm font-semi-bold mb-2 text-gray-600" />

                            <TextInput
                                id="email"
                                type="email"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <!-- password -->
                        <div class="mb-4">
                            <InputLabel for="password" value="Password" class="block text-sm font-semi-bold mb-2 text-gray-600"/>

                            <TextInput
                                id="password"
                                type="password"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div class="mb-4">

                            <InputLabel for="password_confirmation" value="Confirm Password" class="block text-sm font-semi-bold mb-2 text-gray-600" />

                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- button -->
                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                            <CustomButtonSubmit
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Update User
                            </CustomButtonSubmit>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
    </section>
</template>
