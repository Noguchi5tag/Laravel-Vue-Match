<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: Boolean,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    id: user.id,
    name: user.name,
    email: user.email,
    login_name: user.login_name,
    manager_url: user.manager_url || '',
    tel_manager: user.tel_manager || '01012345678',
    manager_address_number: user.manager_address_number || '8551234',
    manager_address: user.manager_address || '',
    business: user.business || '',
    recruit_manager: user.recruit_manager || '',
    other_manager: user.other_manager || '',
    image_manager: user.image_manager || '',
});

const updateFunction = () => {
    console.log(form);

    form.post(route('manager.profile.update', user.id), {
        _method: 'put',
        name: form.name,
        email: form.email,
        login_name: form.login_name,
        manager_url: form.manager_url,
        tel_manager: form.tel_manager,
        manager_address_number: form.manager_address_number,
        manager_address: form.manager_address,
        business: form.business,
        recruit_manager: form.recruit_manager,
        other_manager: form.other_manager,
        image_manager: form.image_manager,
    })
}

// 画像プレビュー用の参照を追加
const imagePreview = ref(user.image_manager || '');
// 画像が選択されたときの処理
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image_manager = file;
        // プレビューを表示するためのURLを設定
        imagePreview.value = URL.createObjectURL(file);
    }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">登録情報</h2>
        </header>

        <form @submit.prevent="updateFunction(form.id)" enctype="multipart/form-data" class="mt-6 space-y-6">
            <div class="flex">
                <div>
                    <InputLabel for="name" value="会社名" />
    
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
                <!-- <div>
                    <InputLabel for="image_manager" value="プロフィール画像" />
                    <div class="mt-1 flex items-center">
                        <img v-if="imagePreview" :src="imagePreview" class="w-16 h-16 rounded-full object-cover mr-2" />
                        <input
                            id="image_manager"
                            type="file"
                            accept="image/*"
                            @change="handleImageChange"
                        />
                    </div>
                    <InputError class="mt-2" :message="form.errors.image_manager" />
                </div> -->
            </div>

            <div>
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

            <!-- <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    メールアドレスが未認証です。
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm  hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        こちらをクリックして認証メールを再送信してください。
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    登録したメールアドレスに新しい認証リンクが送信されました。
                </div>
            </div> -->

            <div>
                <InputLabel for="login_name" value="ログインネーム" />

                <TextInput
                    id="login_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login_name"
                />

                <InputError class="mt-2" :message="form.errors.login_name" />
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

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">保 存</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm ">保存しました。</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
