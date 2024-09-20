<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

//ログインしているかどうかの処理
const { props } = usePage();
const isLoggedIn = props.auth.user !== null;

//Adminでログインしているかどうかの処理
const isAdmin = ref(false);
onMounted(() => {
    const currentUrl = window.location.pathname;
    isAdmin.value = currentUrl.includes('/admin/');
});
</script>

<template>
    <div v-if="isLoggedIn" class=" bg-white fixed bottom-0 max-w-sm w-full left-1/2 transform -translate-x-1/2 border-t-2 border-slate-200">
        <div class="pt-2 flex justify-around items-center">
            <Link as="button" href="/" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/home.png" alt="">
                <p>ホーム</p>
            </Link>
            <Link as="button" href="/bookmarked" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/address.png" alt="">
                <p>ブックマーク</p>
            </Link>
            <Link as="button" href="/applied-list" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/address.png" alt="">
                <p>応募済み</p>
            </Link>
            <Link as="button" href="/profile" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/address.png" alt="">
                <p>マイページ</p>
            </Link>
        </div>
    </div>
</template>