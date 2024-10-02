<script setup>
import { Head, router, Link } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';

//ログインしているかどうかの処理
const isManager = ref(false);
onMounted(() => {
    const currentUrl = window.location.pathname;
    isManager.value = currentUrl.includes('/manager/');
});
console.log(isManager);

const props = defineProps({
    id: String,
    inertiaJob: Object,
})

const keyWords = props.inertiaJob.search_keywords.join(', ') || 'キーワード';

const imageCount = (job) => {
    let count = 0;
    for (let i = 1; i <= 5; i++) {
        if (job[`image${i}`]) {
            count++;
        }
    }
    return count;
}
</script>

<template>
    <Head title="求人詳細" />
    <AuthenticatedLayout>
        <!-- フラッシュメッセージ -->
        <div v-if="$page.props.flash.message" class="bg-blue-300">
            {{ $page.props.flash.message }}
        </div>

        <div v-if="props.inertiaJob" class=" max-w-screen-md mx-auto">
            <!-- {{ props.inertiaJob.id }} -->
            <section class=" body-font relative">
                <div class="container px-4 py-24 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                            {{ props.inertiaJob.companyName }}
                        </h1>
                    </div>
                    <carousel :items-to-show="1.5">
                        <slide v-for="slide in imageCount(props.inertiaJob)" :key="slide">
                            <div v-if="props.inertiaJob[`image${slide}`]" class="carousel__item">
                                <img :src="`/storage/storages/${props.inertiaJob[`image${slide}`]}`" alt="" class="w-full h-full object-cover">
                            </div>
                        </slide>
                        <template #addons>
                            <navigation />
                            <pagination />
                        </template>
                    </carousel>
                    <div class="mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="WantedTitles" class="leading-7 text-sm ">募集タイトル</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ props.inertiaJob.WantedTitles }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="Occupation" class="leading-7 text-sm ">職種</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.Occupation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="companyAddress" class="leading-7 text-sm ">会社の住所</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.companyAddress }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="companyPay" class="leading-7 text-sm ">給料</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.companyPay }}円～
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="dutyStation" class="leading-7 text-sm ">勤務地</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.dutyStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="workDescription" class="leading-7 text-sm ">仕事内容</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.workDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="payDescription" class="leading-7 text-sm ">給与詳細</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.payDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="travelExpenses" class="leading-7 text-sm ">交通費</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.travelExpenses }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="Welfare" class="leading-7 text-sm ">福利厚生</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.Welfare }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="workHours" class="leading-7 text-sm ">勤務時間</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.startWork.split(':').slice(0, 2).join(':') }}～{{ props.inertiaJob.endWork.split(':').slice(0, 2).join(':') }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="workDays" class="leading-7 text-sm ">出勤日</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.workDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="freeDays" class="leading-7 text-sm ">休日</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.freeDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="NearestStation" class="leading-7 text-sm ">最寄り駅</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.NearestStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="workOther" class="leading-7 text-sm ">その他</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.workOther }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel for="search_keywords" class="leading-7 text-sm">検索キーワード</InputLabel>
                                    <div class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ keyWords }}
                                    </div>
                                </div>
                            </div>

                            <div class="w-full">
                                <div class="relative">
                                    <InputLabel for="status" class="leading-7 text-sm ">ステータス</InputLabel>
                                    <div class="">
                                        <p class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">現在のステータス: 
                                            <span v-if="props.inertiaJob.status === 0">非公開</span>
                                            <span v-else>公開</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="p-2 w-full">
                                <div class="p-2">
                                    <Link as="button" :href="route('manager.company.edit', { inertiaJob: props.inertiaJob.id })" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集する</Link>
                                </div>
                            </div>
                            
                            <div class="p-2 w-full">
                                <Link as="button" href="/manager/companylist" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">戻る</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div v-else>
            <p>データが見つかりません。</p>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.carousel__item {
    min-height: 200px;
    width: 100%;
    background-color: var(--vc-clr-primary);
    color: var(--vc-clr-white);
    display: flex;
    justify-content: center;
    align-items: center;
    }

    .carousel__slide {
    padding: 2px;
    }

    .carousel__prev,
    .carousel__next {
    color: white;
    }
</style>