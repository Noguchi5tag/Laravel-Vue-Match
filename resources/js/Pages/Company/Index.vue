<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    inertiaJobs: Array,
})
</script>

<template>
    企業様向けIndexページ<br>

    <!-- フラッシュメッセージ -->
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>

    <Link :href="route('company.create')" class="bg-sky-200">新規登録</Link>

    <div v-if="inertiaJobs">
        <div v-for="n in inertiaJobs" :key="n.id">
            <p>ID：{{ n.id }}</p>
            <h1>会社名：{{ n.companyName }}</h1>
            <p>募集タイトル：{{ n.WantedTitles }}</p>
            <p>職種：{{ n.Occupation }}</p>
            <p>会社の住所：{{ n.companyAddress }}</p>
            <Link :href="route('company.show', { id: n.id })">詳細へ</Link>
            <hr>
        </div>
    </div>
</template>