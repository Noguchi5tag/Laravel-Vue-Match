
<template>
    <SiteTitle>マイページ</SiteTitle>

    <Button slug="/">ボタン</Button>

<div class="">
    <div class="text-center my-4">
        <router-link to="/dashboard/bookmark" class="mr-4 border border-black p-0.5">ブックマークした求人</router-link>
        <router-link to="/dashboard/applied" class="border border-black p-0.5">応募済み求人</router-link>
    </div>
    <hr>
    <div class="">
        ここに「ブックマークした求人」や「応募済み求人」の一覧を表示をしたい
    </div>
    <hr>

    <div class="">
        
    </div>
</div>
</template>

<script setup>
import SiteTitle from '../Components/SiteTitle.vue';
import Button from '../Components/Button/Button.vue';
</script>
