<script setup>
import { Link, usePage } from '@inertiajs/vue3';
//ログインしているかどうかの処理
const { props } = usePage();
const isLoggedIn = props.auth.user !== null;

</script>

<template>
    <div class=" bg-white fixed bottom-0 max-w-sm w-full left-1/2 transform -translate-x-1/2 border-t-2 border-slate-200">
        <div class="pt-2 flex justify-around items-center">
            <Link as="button" href="/" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/home.png" alt="">
                <p>ホーム</p>
            </Link>
            <Link as="button" href="/jobs" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/list-logo.png" alt="">
                <p>求人一覧</p>
            </Link>
            <Link as="button" href="/search" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/search-logo.png" alt="">
                <p>検索</p>
            </Link>
            <Link v-if="!isLoggedIn" as="button" href="/login" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/home.png" alt="">
                <p>ログイン</p>
            </Link>
            <Link v-else as="button" href="/profile" class="flex flex-col items-center">
                <img class="w-6" src="../../../../public/images/address.png" alt="">
                <p>マイページ</p>
            </Link>
        </div>
    </div>
</template>