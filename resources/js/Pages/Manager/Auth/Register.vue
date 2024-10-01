<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    login_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    manager_url: '',
    tel_manager: '',
    manager_address_number: '',
    manager_address: '',
    business: '',
    recruit_manager: '',
    other_manager: '',
    image_manager: '',
});


const submit = () => {
    form.post(route('manager.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="管理者登録" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
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
                <InputLabel for="login_name" value="ログインネーム" />

                <TextInput
                    id="login_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login_name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.login_name" />
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

            <div>
                <InputLabel for="manager_url" value="サイトURL" />

                <TextInput
                    id="manager_url"
                    type="url"
                    class="mt-1 block w-full"
                    v-model="form.manager_url"
                />

                <InputError class="mt-2" :message="form.errors.manager_url" />
            </div>

            <div>
                <InputLabel for="tel_manager" value="電話番号" />

                <TextInput
                    id="tel_manager"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.tel_manager"
                    required
                />

                <InputError class="mt-2" :message="form.errors.tel_manager" />
            </div>

            <div>
                <InputLabel for="manager_address_number" value="郵便番号" />

                <TextInput
                    id="manager_address_number"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.manager_address_number"
                    required
                />

                <InputError class="mt-2" :message="form.errors.manager_address_number" />
            </div>

            <div>
                <InputLabel for="manager_address" value="住所" />

                <TextInput
                    id="manager_address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.manager_address"
                    required
                />

                <InputError class="mt-2" :message="form.errors.manager_address" />
            </div>

            <div>
                <InputLabel for="business" value="事業内容" />

                <TextInput
                    id="business"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.business"
                    required
                />

                <InputError class="mt-2" :message="form.errors.business" />
            </div>

            <div>
                <InputLabel for="recruit_manager" value="採用担当者" />

                <TextInput
                    id="recruit_manager"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.recruit_manager"
                    required
                />

                <InputError class="mt-2" :message="form.errors.recruit_manager" />
            </div>

            <div>
                <InputLabel for="other_manager" value="その他" />

                <TextArea
                    id="other_manager"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.other_manager"
                />

                <InputError class="mt-2" :message="form.errors.other_manager" />
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
                <InputLabel for="password_confirmation" value="パスワードの再入力" />

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

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('manager.login')"
                    class="underline text-sm  hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    ログインはこちら
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    登録する
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
