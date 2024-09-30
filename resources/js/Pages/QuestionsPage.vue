<script setup>
import { Head } from '@inertiajs/vue3';
import BasePage from '../Layouts/BaseLayouts.vue';
import SectionInner from '../Layouts/SectionInner.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

</script>

<template>
    <Head title="よくある質問" />
    <BasePage>
        <SiteTitle>よくある質問</SiteTitle>
        <SectionInner class="my-4">
            <div class="pb-6 border-b-2 border-baseColor">
                <div class="md:flex-grow">
                    <h2 class="text-sm font-medium title-font mb-2">登録は無料ですか？</h2>
                    <p class="text-sm leading-relaxed">はい、当サイトの会員登録は完全無料です。求職者の方、企業様ともに、お気軽にご登録いただけます。</p>
                </div>
            </div>
            <div class="py-6 border-b-2 border-baseColor">
                <div class="md:flex-grow">
                    <h2 class="text-sm font-medium title-font mb-2">どのような仕事が掲載されていますか？</h2>
                    <p class="text-sm leading-relaxed">当サイトでは、正社員、契約社員、アルバイト、パート、インターンなど、様々な雇用形態の求人が掲載されています。業種も多岐にわたり、IT、営業、事務、クリエイティブなど、様々な分野の求人を探すことができます。</p>
                </div>
            </div>
            <div class="py-6 border-b-2 border-baseColor">
                <div class="md:flex-grow">
                    <h2 class="text-sm font-medium title-font mb-2">求人情報の検索方法は？</h2>
                    <p class="text-sm leading-relaxed">求人情報は、キーワード検索、業種別検索、地域別検索など、様々な方法で検索することができます。また、新着求人や人気の求人などの特集もご用意していますので、ぜひご利用ください。</p>
                </div>
            </div>
            <div class="py-6 border-b-2 border-baseColor">
                <div class="md:flex-grow">
                    <h2 class="text-sm font-medium title-font mb-2">応募から内定までの流れを教えてください。</h2>
                    <p class="text-sm leading-relaxed">
                        1.気になる求人に応募: 求人詳細ページから、簡単に応募することができます。<br>
                        2.企業からの連絡: 企業から面接日時などの連絡が届きます。<br>
                        3.面接: 企業と面接を行い、お互いのことをよく知り合いましょう。<br>
                        4.内定: 内定が出たら、入社手続きを進めます。
                    </p>
                </div>
            </div>
            <div class="py-6 border-b-2 border-baseColor">
                <div class="md:flex-grow">
                    <h2 class="text-sm font-medium title-font mb-2">個人情報の取り扱いについて教えてください。</h2>
                    <p class="text-sm leading-relaxed">当サイトでは、会員様の個人情報を厳重に管理しており、不正なアクセスや漏洩防止に万全を期しています。個人情報の取り扱いについては、プライバシーポリシーをご確認ください。</p>
                </div>
            </div>
            <div class="py-6 w-full flex justify-center">
                <PrimaryButton href="/contact" class="">お問い合わせ</PrimaryButton>
            </div>
        </SectionInner>
    </BasePage>
</template>