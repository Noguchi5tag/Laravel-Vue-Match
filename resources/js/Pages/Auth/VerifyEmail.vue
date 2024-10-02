<script setup>
import { computed } from 'vue';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: Boolean,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <BaseLayouts>
        <Head title="メール認証" />

        <SectionInner>
            <div class="flex flex-col gap-2 justify-center h-screen px-4">
                <div class="text-base font-bold">
                    入力いただいたメールアドレス宛に送信しました
                </div>
                <div class=" text-xs opacity-50">
                    入力いただいたメールアドレス宛に、利用登録用URLをお送りしました。<br>メールを確認いただき、利用登録の手続きを行ってください。
                </div>
    
                <div class="font-medium text-sm text-green-600" v-if="verificationLinkSent">
                    登録時に入力されたメールアドレスに新しい認証リンクが送信されました。
                </div>
    
                <form @submit.prevent="submit">
                    <div class="mt-4 flex flex-col gap-4 items-center justify-between">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            認証メールを再送する
                        </PrimaryButton>

                        <p class="text-xs opacity-50">※メールアドレス宛に利用登録URLを添付。そこから利用登録へ進む。</p>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="underline text-sm hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >ログアウトする</Link
                        >
                    </div>
                </form>
            </div>
    </SectionInner>
    </BaseLayouts>
</template>
