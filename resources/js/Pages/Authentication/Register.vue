<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {Link} from "@inertiajs/vue3";


const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <!-- form -->
        <form @submit.prevent="submit">
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
            <div class="grid my-6">
                <Button class="btn py-[10px] text-base text-white font-medium hover:bg-blue-700" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </Button>
            </div>

            <div class="flex justify-center gap-2 items-center">
                <p class="text-base font-medium text-gray-500">Already have an Account?</p>
                <Link :href="route('login')"
                      class="text-sm font-medium text-blue-600 hover:text-blue-700">Sign In</Link>
            </div>
        </form>
    </GuestLayout>
</template>
