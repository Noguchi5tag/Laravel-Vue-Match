<script setup>
import { Inertia } from '@inertiajs/inertia';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

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
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">お知らせ</h2>
    </template>

    <!-- フラッシュメッセージ -->
    <FlashMessage v-if="$page.props.flash.message" >
        {{ $page.props.flash.message }}
    </FlashMessage>
    
    <div class="max-w-xl mx-auto">
        <div class="py-10">
            <template v-if="news.length">
                <div v-for="item in news" :key="item.id" class="mb-4 p-4 border rounded">
                    <div class="flex justify-between">
                        <h2 class="text-xl font-semibold">{{ item.title }}</h2>
                        <DangerButton @click="deleteNews(item.id)">削 除</DangerButton>
                    </div>
                    <p>{{ item.content }}</p>
                </div>
            </template>
            <template v-else>
                    <p>お知らせはありません。</p>
            </template>
        </div>
    </div>
</AdminAuthenticatedLayout>
</template>