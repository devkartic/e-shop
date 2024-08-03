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
import Checkbox from "@/Components/Checkbox.vue";

const isOpeningModal = ref(false);

const props = defineProps({
    categories: Object,
    product: Object,
})

const current_elements = ref({...props.product}).value

const form = useForm({
    name: current_elements.name ?? '',
    category_id: current_elements.category_id ?? '',
    description: current_elements.description ?? '',
    upload_product_image: current_elements.image_path ?? null,
    status: Boolean(current_elements.status),
    order_number: current_elements.order_number ?? '',
});
const openModal = () => {
    isOpeningModal.value = true;
};

const formSubmit = () => {
    form.patch(route('products.update', current_elements.id), {
        preserveState: false,
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
                    Product Edit
                </h2>

                <div class="mt-6">
                    <form @submit.prevent="formSubmit">
                        <!-- Category -->
                        <div class="mb-4">
                            <InputLabel for="category_id" value="Category" class="block text-sm font-semi-bold mb-2 text-gray-600" />
                            <select v-model="form.category_id" class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0" required>
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

                            <input
                                id="upload_product_image"
                                type="file"
                                class="py-3 px-4 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline dark:border-gray-300 dark:placeholder-gray-400"
                                @input="form.upload_product_image = $event.target.files[0]"
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
                                Update
                            </CustomButtonSubmit>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
    </section>
</template>
