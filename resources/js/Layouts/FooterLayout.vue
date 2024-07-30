<template>
    <div>
        <FooterMenu />
        <div class="bg-sky-50">
            <div class="py-1">
                <h1 class="text-2xl text-center">ここにロゴ</h1>
                <div class="py-4 text-center flex flex-col items-center">
                    <router-link to="/rules">利用規約</router-link>
                    <router-link to="/privacy">プライバシーポリシー</router-link>
                    <router-link to="/contact">お問い合わせ</router-link>
                </div>
            </div>
        </div>
        <div class="bg-black">
            <p class="text-center text-white">© 2024 FIVE TAG PLUS</p>
        </div>
    </div>
</template>

<script setup>
import FooterMenu from '../Components/Button/FotterMenu.vue';

</script>