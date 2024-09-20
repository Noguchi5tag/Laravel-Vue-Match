<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import BasePage from '../../Layouts/BaseLayouts.vue';
import SiteTitle from '../../Components/SiteTitle.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

const props = defineProps({
    applications: Array,
})
console.log(props.applications);

const imageCount = (job) => {
    let count = 0;
    for (let i = 1; i <= 5; i++) {
        if (job[`image${i}`]) {
            count++;
        }
    }
    return count;
};

const toggleDetails = (job) => {
    job.showDetails = !job.showDetails;
};

</script>

<template>
    <Head title="応募済みリスト" />
    <BasePage>
        <div>
            <SiteTitle>応募した求人</SiteTitle>

            <div v-if="applications.length === 0">
                <p class="text-center my-10">応募した求人はまだありません</p>
            </div>
            <div v-else class="m-2">
                <template v-for="job in applications" :key="job.id">
                    {{ job.job.companyName }}
                </template>
            </div>
        </div>
    </BasePage>
</template>