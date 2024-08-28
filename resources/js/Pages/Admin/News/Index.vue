<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    news: Array
});

const deleteNews = (id) => {
    if (confirm('本当に削除しますか？')) {
        Inertia.delete(route('admin.news.destroy', { id }));
    }
};
</script>
<template>

<AdminAuthenticatedLayout>
    <div class="max-w-xl mx-auto">
        <div class="py-10">
            <h1 class="text-2xl font-bold mb-6">お知らせ</h1>
            <div v-for="item in news" :key="item.id" class="mb-4 p-4 border rounded">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold">{{ item.title }}</h2>
                    <DangerButton v-if="index !== 1" @click="deleteNews(item.id)">削 除</DangerButton>
                </div>
                <p>{{ item.content }}</p>
            </div>
        </div>
    </div>
</AdminAuthenticatedLayout>
</template>