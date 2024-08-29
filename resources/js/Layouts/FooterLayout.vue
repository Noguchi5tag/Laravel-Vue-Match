<script setup>
import { usePage } from '@inertiajs/vue3';
import FooterMenu from '../Components/Button/FotterMenu.vue';
import NavLink from '@/Components/NavLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const { props } = usePage();
const isLoggedIn = props.auth.user !== null;
</script>

<template>
    <div class="">
        <div class="bg-sky-50">
            <div class="py-1">
                <div class="flex justify-center">
                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                </div>
                <div class="py-4 text-center flex flex-col items-center">
                    <NavLink as="button" href="/rules">利用規約</NavLink>
                    <NavLink as="button" href="/privacy">プライバシーポリシー</NavLink>
                    <NavLink as="button" href="/questions">よくある質問</NavLink>
                    <NavLink as="button" href="/contact">お問い合わせ</NavLink>
                </div>
            </div>
        </div>
        <div class="bg-black ">
            <p class="text-center text-white">© 2024 FIVE TAG PLUS</p>
        </div>
    </div>
    <template v-if="isLoggedIn">
        <div class="pb-12"></div>
    </template>
    <FooterMenu />
</template>