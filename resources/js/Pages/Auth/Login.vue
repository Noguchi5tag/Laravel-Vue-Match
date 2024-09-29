<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BasePage from '../../Layouts/BaseLayouts.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: Boolean,
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
                    <label class="flex items-center justify-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">ログイン情報を保存する</span>
                    </label>
                </div>
    
                <div class="flex items-center justify-center mt-4">
                    
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        ログインする
                    </PrimaryButton>
                </div>
            </form>
            
            <div class="flex justify-center">
                <!-- v-if="canResetPassword" -->
                <!-- <NavLink
                    as="button" 
                    :href="route('password.request')"
                >
                    パスワードをわすれた
                </NavLink> -->
                <p class="inline-flex items-center mr-1 border-b-2 border-transparent text-xs font-medium leading-5 text-gray-500 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">利用登録はお済みですか？</p>
                <NavLink 
                    as="button" 
                    :href="route('register')"
                    class="text-xs text-sky-500 hover:text-sky-400 hover:border-sky-400 "
                >
                    新規会員登録
                </NavLink>
            </div>
        </div>
    </BasePage>

</template>
