<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    inertiaJobs: Array,
})
</script>

<template>
    企業様向けIndexページ

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