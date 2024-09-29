<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import FooterMenu from '../Components/Button/FotterMenu.vue';
import NavLink from '@/Components/NavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const { props } = usePage();
const isLoggedIn = props.auth.user !== null;
</script>

<template>
    <div class="">
        <div class="flex flex-col mb-6">
            <NavLink as="button" href="/questions" class="pt-3 pb-3 border-t-2 border-slate-300 font-bold">よくある質問</NavLink>
            <NavLink as="button" href="/jobpostings" class="pt-3 pb-3 border-slate-300 font-bold">求人掲載をお考えの方へ</NavLink>
            <NavLink as="button" href="/rules" class="pt-3 pb-3 border-slate-300 font-bold">利用規約</NavLink>
            <NavLink as="button" href="/privacy" class="pt-3 pb-3 border-slate-300 font-bold">プライバシーポリシー</NavLink>
            <NavLink as="button" href="/contact" class="pt-3 pb-3 border-slate-300 font-bold">お問い合わせ</NavLink>
        </div>
        <p class="text-center text-xs">© 2024 FIVE TAG PLUS</p>
    </div>
    <template v-if="isLoggedIn">
        <div class="pb-12"></div>
    </template>
    <FooterMenu />
</template>