<script setup>
import NavLink from '@/Components/NavLink.vue';
import { ref } from 'vue'

const isMenuOpen = ref(false);
const closeMenu = () => {
    isMenuOpen.value = false;
}
</script>

<template>
    <div class="fixed top-0 left-1/2 -translate-x-1/2 z-10 w-full max-w-sm">
        <div class= "bg-baseColor p-2 flex justify-between items-center">
            <button class="w-10 h-10 py-3 px-2 relative" @click="isMenuOpen = !isMenuOpen">
                <div class="w-full h-full flex flex-col justify-between items-center">
                    <span class="block w-full h-[2px] bg-black"></span>
                    <span class="block w-full h-[2px] bg-black"></span>
                    <span class="block w-full h-[2px] bg-black"></span>
                </div>
            </button>
            <NavLink href="/">JobMatch</NavLink>
            <font-awesome-icon :icon="['far', 'bell']" class="w-5 h-5" />
        </div>
        <div v-if="isMenuOpen" class="fixed top-0 left-0 w-full h-screen bg-white z-50 shadow-lg flex flex-col p-6 transition-all duration-200">
            <div class="flex justify-end">
                <button @click="closeMenu" class="text-customBlue text-3xl font-bold">&times;</button>
            </div>
            <ul class="text-base space-y-2 mt-6">
                <li><NavLink as="button" href="/questions" class="pt-3 pb-3 border-t-2 border-baseColor font-bold">よくある質問</NavLink></li>
                <li><NavLink as="button" href="/site-details" class="pt-3 pb-3 border-t-2 border-baseColor font-bold">このサイトについて</NavLink></li>
                <li><NavLink as="button" href="/rules" class="pt-3 pb-3 border-baseColor font-bold">利用規約</NavLink></li>
                <li><NavLink as="button" href="/privacy" class="pt-3 pb-3 border-baseColor font-bold">プライバシーポリシー</NavLink></li>
                <li><NavLink as="button" href="/jobpostings" class="pt-3 pb-3 border-baseColor font-bold">求人掲載をお考えの方へ</NavLink></li>
                <li><NavLink as="button" href="/contact" class="pt-3 pb-3 border-baseColor font-bold">お問い合わせ</NavLink></li>
            </ul>
        </div>
    </div>
</template>