<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import { ref } from 'vue';
import CustomButtonCreate from "@/Components/CustomButtonCreate.vue";
import CustomButtonSubmit from "@/Components/CustomButtonSubmit.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    categories: Object
})

const isOpeningModal = ref(false);

const form = useForm({
    name: '',
    category_id: '',
    description: '',
    upload_product_image: '',
    order_number: '',
    status: false,
});

const openModal = () => {
    isOpeningModal.value = true;
};

const formSubmit = () => {
    form.post(route('products.store'), {
        forceFormData: true,
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

        <CustomButtonCreate @click="openModal">Create</CustomButtonCreate>

        <Modal :show="isOpeningModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Product Create
                </h2>

                <div class="mt-6">
                    <form @submit.prevent="formSubmit">
                        <!-- Category -->
                        <div class="mb-4">
                            <InputLabel for="category_id" value="Category" class="block text-sm font-semi-bold mb-2 text-gray-600" />
                            <select v-model="form.category_id" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0">
                                <option value="">Select One</option>
                                <option v-for="category in props.categories" :value="category.id">{{ category.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.category_id" />
                        </div>
                        <!-- name -->
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
                        <!-- description -->
                        <div class="mb-4">
                            <InputLabel for="description" value="Description" class="block text-sm font-semi-bold mb-2 text-gray-600" />

                            <textarea
                                id="description"
                                type="text"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.description"
                                required
                                autofocus
                                autocomplete="description"
                            ></textarea>

                            <InputError class="mt-2" :message="form.errors.description" />

                        </div>
                        <!-- Image -->
                        <div class="mb-4">
                            <InputLabel for="upload_product_image" value="Image Upload" class="block text-sm font-semi-bold mb-2 text-gray-600" />

                            <TextInput
                                id="upload_product_image"
                                type="file"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.upload_product_image"
                            />

                            <InputError class="mt-2" :message="form.errors.upload_product_image" />

                        </div>
                        <!-- Order Number -->
                        <div class="mb-4">
                            <InputLabel for="order_number" value="Order Number" class="block text-sm font-semi-bold mb-2 text-gray-600" />

                            <TextInput
                                id="order_number"
                                type="text"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                                v-model="form.order_number"
                                autocomplete="order_number"
                            />

                            <InputError class="mt-2" :message="form.errors.order_number" />
                        </div>
                        <!-- checkbox -->
                        <div class="flex justify-between">
                            <div class="flex">
                                <Checkbox name="status" v-model:checked="form.status" class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500" />
                                <label for="hs-default-checkbox" class="text-sm text-gray-600 ms-3">Is Active?</label>
                            </div>
                        </div>

                        <!-- button -->
                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                            <CustomButtonSubmit
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Save
                            </CustomButtonSubmit>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
    </section>
</template>
