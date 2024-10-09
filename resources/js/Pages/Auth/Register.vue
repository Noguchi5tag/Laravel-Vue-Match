<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { prefectures } from '@/data';
import BaseLayouts from '../../Layouts/BaseLayouts.vue';

const form = useForm({
    name: '',
    kana: '',
    email: '',
    // tel: '',
    // sex: '',
    // birth: '',
    // postal: '',
    // prefectures: '',
    // city: '',
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
    <BaseLayouts>
        <Head title="会員登録" />

        <form @submit.prevent="submit">
            <SiteTitle>会員登録</SiteTitle>
            <div class="max-w-7xl mx-auto mt-6 mb-12 px-6 space-y-6">
                <div>
                    <InputLabel for="name" value="名前" />
    
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
    
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="kana" value="フリガナ" />
    
                    <TextInput
                        id="kana"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.kana"
                        required
                        autofocus
                    />
    
                    <InputError class="mt-2" :message="form.errors.kana" />
                </div>
    
                <div class="mt-4">
                    <InputLabel for="email" value="メールアドレス" />
    
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
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
                        autocomplete="new-password"
                    />
    
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
    
                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="パスワードを再入力" />
    
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
    
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
    
                <div class="flex flex-col items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        登録する
                    </PrimaryButton>
                    <Link
                        :href="route('login')"
                        class="underline text-xs mt-2 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        すでにアカウントをお持ちですか？
                    </Link>
                </div>
            </div>
        </form>
    </BaseLayouts>
</template>
