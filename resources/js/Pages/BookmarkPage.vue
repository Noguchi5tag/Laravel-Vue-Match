<script setup>
import { Head } from '@inertiajs/vue3';
import BasePage from './BasePage.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
</script>

<template>
    <Head title="ブックマーク" />
    
    <BasePage>

        <SiteTitle>ブックマークリスト</SiteTitle>

        <section>
            ここにコンテンツ
        </section>
    </BasePage>

</template>