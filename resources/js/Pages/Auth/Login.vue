<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BasePage from '../../Layouts/BaseLayouts.vue';

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
    <BasePage>
        <Head title="ログイン" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="max-w-7xl mx-auto my-12 px-6 space-y-6">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="メールアドレス" />
    
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
    
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
    
                <div class="mt-4">
                    <InputLabel for="password" value="パスワード" />
    
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
    
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
    
                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">保存しておく</span>
                    </label>
                </div>
    
                <div class="flex items-center justify-end mt-4">
                    
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        ログイン
                    </PrimaryButton>
                </div>
            </form>
            
            <div class="my-6">
                <!-- v-if="canResetPassword" -->
                <DangerButton>
                    <Link
                    :href="route('password.request')"
                    class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    パスワードをわすれた
                </Link>
                </DangerButton>
                <Link as="button" :href="route('register')" class="rounded-md px-3 py-2 ml-2 text-white bg-sky-600 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    新規会員登録
                </Link>
            </div>
        </div>
    </BasePage>

</template>
