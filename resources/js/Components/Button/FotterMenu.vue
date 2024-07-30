<template>
    <hr>
    <div class="flex justify-around items-center p-1">
        <Link href="/" class="flex flex-col items-center">
            <img class="w-6" src="../../../../public/images/home.png" alt="">
            <p>ホーム</p>
        </Link>
        <Link href="/" class="flex flex-col items-center">
            <img class="w-6" src="../../../../public/images/home.png" alt="">
            <p>メニュー</p>
        </Link>
        <Link href="/search" class="flex flex-col items-center">
            <img class="w-6" src="../../../../public/images/home.png" alt="">
            <p>検索</p>
        </Link>
        <Link href="/dashboard" class="flex flex-col items-center">
            <img class="w-6" src="../../../../public/images/home.png" alt="">
            <p>マイページ</p>
        </Link>
    </div>
    <hr>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>