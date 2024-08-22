<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';

</script>

<template>
    <Head title="お知らせ" />
    <BasePage>
        <SiteTitle>お知らせ</SiteTitle>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col flex-wrap py-6 text-left">
                    <div class="flex flex-col mb-10 lg:items-start items-center">
                        <div class="flex-grow">
                        <h2 class="text-gray-900 text-lg title-font font-medium mb-3">新機能「スキップマッチング」登場！</h2>
                        <p class="leading-relaxed text-base">
                        スキップマッチングとは: あなたのスキルや経験、希望条件を入力するだけで、ぴったりな求人を自動で提案する新機能です。<br>
                        メリット: 面倒な検索作業が不要になり、効率的に求人を探すことができます。
                        </p>
                        </div>
                    </div>
                    <div class="flex flex-col mb-10 lg:items-start items-center">
                        <div class="flex-grow">
                        <h2 class="text-gray-900 text-lg title-font font-medium mb-3"> オンラインキャリア相談会「あなたのキャリアを一緒に考えよう！」</h2>
                        <p class="leading-relaxed text-base">
                            日時: 2024年12月15日（土）10:00～12:00<br>
                            キャリアアドバイザーが、あなたのキャリアに関する悩みや疑問に個別にご相談に乗ります。
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </BasePage>
</template>