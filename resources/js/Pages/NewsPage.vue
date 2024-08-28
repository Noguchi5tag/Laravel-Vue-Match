<script setup>
import { Head } from '@inertiajs/vue3';
import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';

const props = defineProps({
    news: Array,
})

console.log(props.news);
</script>

<template>
    <Head title="お知らせ" />
    <BasePage>
        <SiteTitle>お知らせ</SiteTitle>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col flex-wrap py-6 text-left">
                    <div class="flex flex-col mb-10 lg:items-start items-center">
                        <div v-for="item in news" :key="item.id" class="flex-grow mb-8">
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">{{ item.title }}</h2>
                            <p class="leading-relaxed text-base">{{ item.content }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </BasePage>
</template>