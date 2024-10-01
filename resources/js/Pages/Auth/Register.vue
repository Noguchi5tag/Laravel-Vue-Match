<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { prefectures } from '@/data';
import BasePage from '../../Layouts/BaseLayouts.vue';

const form = useForm({
    name: '',
    email: '',
    tel: '',
    sex: '',
    birth: '',
    postal: '',
    prefectures: '',
    city: '',
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
    <BasePage>
        <Head title="会員登録" />

        <form @submit.prevent="submit">
            <SiteTitle>会員登録</SiteTitle>
            <div class="max-w-7xl mx-auto my-12 px-6 space-y-6">
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

                <!-- ここに追加 -->
                <div>
                    <InputLabel for="tel" value="電話番号（ハイフンなし）" />

                    <TextInput
                        id="tel"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.tel"
                        required
                        autofocus
                        autocomplete="tel"
                        pattern="\d*"
                        maxlength="11"
                    />

                    <InputError class="mt-2" :message="form.errors.tel" />
                </div>

                <div>
                    <InputLabel for="sex" value="性別" />

                    <div class="mt-1">
                        <label class="">
                            <input
                                type="radio"
                                name="sex"
                                value="0"
                                v-model="form.sex"
                                required
                            />
                            男性
                        </label>
                        <label class="">
                            <input
                                type="radio"
                                name="sex"
                                value="1"
                                v-model="form.sex"
                                required
                            />
                            女性
                        </label>
                        <label class="">
                            <input
                                type="radio"
                                name="sex"
                                value="2"
                                v-model="form.sex"
                                required
                            />
                            どちらでもない
                        </label>
                    </div>

                    <InputError class="mt-2" :message="form.errors.sex" />
                </div>

                <div>
                    <InputLabel for="birth" value="生年月日" />

                    <TextInput
                        id="birth"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.birth"
                        required
                        autofocus
                        autocomplete="birth"
                    />

                    <InputError class="mt-2" :message="form.errors.birth" />
                </div>

                <div class="">
                    <InputLabel value="住所" />
                </div>
                <div>
                    <InputLabel for="postal" value="郵便番号（ハイフンなし）" />

                    <TextInput
                        id="postal"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.postal"
                        required
                        autofocus
                        autocomplete="postal"
                        placeholder="8501122"
                    />

                    <InputError class="mt-2" :message="form.errors.postal" />
                </div>

                <div>
                    <InputLabel for="prefectures" value="都道府県" />

                    <select
                        id="prefectures"
                        class="mt-1 block w-full"
                        v-model="form.prefectures"
                        required
                        autofocus
                        autocomplete="prefectures"
                    >
                    <option value="" disabled>都道府県を選択してください</option>
                    <option v-for="prefecture in prefectures" :key="prefecture" :value="prefecture">
                        {{ prefecture }}
                    </option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.prefectures" />
                </div>

                <div>
                    <InputLabel for="city" value="市町村" />

                    <TextInput
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.city"
                        required
                        autofocus
                        autocomplete="city"
                        placeholder="長崎市万屋町12-2"
                    />

                    <InputError class="mt-2" :message="form.errors.city" />
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
    
                <div class="flex items-center justify-end mt-4">
                    <Link
                        :href="route('login')"
                        class="underline text-sm  hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        すでにアカウントをお持ちですか？
                    </Link>
    
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        登録する
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </BasePage>
</template>
