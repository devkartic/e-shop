
<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />
        <!-- form -->
        <form @submit.prevent="submit">
            <!-- username -->
            <div class="mb-4">
                <InputLabel for="email" value="Email" class="block text-sm font-semibold mb-2 text-gray-600" />
                <TextInput
                    id="email"
                    type="email"
                    class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <!-- password -->
            <div class="mb-6">

                <InputLabel for="password" value="Password" class="block text-sm font-semibold mb-2 text-gray-600"/>

                <TextInput
                    id="password"
                    type="password"
                    class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-600 focus:ring-0"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <!-- checkbox -->
            <div class="flex justify-between">
                <div class="flex">
                    <Checkbox name="remember" v-model:checked="form.remember" class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500" />
                    <label for="hs-default-checkbox" class="text-sm text-gray-600 ms-3">Remember me</label>
                </div>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    Forgot your password?
                </Link>
            </div>
            <!-- button -->
            <div class="grid my-6">
                <Button class="btn py-[10px] text-base text-white font-medium hover:bg-blue-700" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </Button>
            </div>

            <div class="flex justify-center gap-2 items-center">
                <p class="text-base font-medium text-gray-500">New to Modernize?</p>
                <Link :href="route('register')" class="text-sm font-medium text-blue-600 hover:text-blue-700">Create an account</Link>
            </div>
        </form>
    </GuestLayout>
</template>
