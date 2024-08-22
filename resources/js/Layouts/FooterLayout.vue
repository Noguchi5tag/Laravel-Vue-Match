<script setup>
import { Link } from '@inertiajs/vue3';
import FooterMenu from '../Components/Button/FotterMenu.vue';

</script>

<template>
    <div>
        <FooterMenu />
        <div class="bg-sky-50">
            <div class="py-1">
                <h1 class="text-2xl text-center">ここにロゴ</h1>
                <div class="py-4 text-center flex flex-col items-center">
                    <Link as="button" href="/rules">利用規約</Link>
                    <Link as="button" href="/privacy">プライバシーポリシー</Link>
                    <Link as="button" href="/questions">よくある質問</Link>
                    <Link as="button" href="/contact">お問い合わせ</Link>
                </div>
            </div>
        </div>
        <div class="bg-black mb-14">
            <p class="text-center text-white">© 2024 FIVE TAG PLUS</p>
        </div>
    </div>
</template>