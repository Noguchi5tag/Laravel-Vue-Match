<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: Boolean,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('manager.verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mb-4 text-sm ">
            ご登録ありがとうございます！登録を始める前に、以下のリンクをクリックしてメールアドレスを確認してください。<br>
            Eメールが届いていない場合は、再度お送りいたします。
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            登録時に入力されたEメールアドレスに新しい認証リンクが送信されました。
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    認証メールを再送する
                </PrimaryButton>

                <Link
                    :href="route('manager.logout')"
                    method="post"
                    as="button"
                    class="underline text-sm  hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >ログアウト</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
