<script setup>
import { Head } from '@inertiajs/vue3';
import BaseLayouts from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';

const props = defineProps({
    news: Array,
})

//作成日のフォーマットを変更
const formattedNews = props.news.map(item => {
    const date = new Date(item.created_at);
    const formattedDate = date.toLocaleDateString('ja-JP', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
    return {
        ...item,
        formattedDate,
    };
});

// console.log(props.news);
</script>

<template>
    <Head title="お知らせ" />
    <BaseLayouts>
        <SiteTitle>お知らせ</SiteTitle>

        <section class=" body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col flex-wrap py-6 text-left">
                    <div class="flex flex-col mb-10 lg:items-start items-center">
                        <div v-for="n in formattedNews" :key="n.id" class="flex-grow mb-8">
                            <span class="leading-relaxed text-base">{{ n.formattedDate }}</span>
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">{{ n.title }}</h2>
                            <p class="leading-relaxed text-base">{{ n.content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </BaseLayouts>
</template>