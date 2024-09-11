<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import BasePage from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

const props = defineProps({
    bookmarkedJobs: Array,
})

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

const bookmarkJob = (jobId) => {
    Inertia.post(`/bookmark/${jobId}`, {}, {
        onSuccess: () => {
            alert('保存しました');
            window.location.reload();
        },
        onError: () => {
            alert('エラーが発生しました');
        }
    });
};
</script>

<template>
    <Head title="ブックマーク" />
    <BasePage>
        <div>
            <SiteTitle>ブックマークした求人</SiteTitle>

            <div v-if="bookmarkedJobs.length === 0">
                <p class="text-center my-10">ブックマークされた求人はありません。</p>
            </div>
            <div v-else class="m-2">
                <template v-for="job in bookmarkedJobs" :key="job.id">
                    <div class="mb-6 pb-4 px-2 border border-gray-200 rounded shadow-md" v-if="job.status === 1">
                        <carousel :items-to-show="1">
                            <slide v-for="slide in imageCount(job)" :key="slide" class="!w-full">
                            <div v-if="job[`image${slide}`]" class="carousel__item w-full">
                                <img :src="`/images/${job[`image${slide}`]}`" alt="" class="w-full h-auto object-cover">
                            </div>
                            </slide>
                            <template #addons>
                            <navigation />
                            <pagination />
                            </template>
                        </carousel>

                        <div class="flex justify-end items-center mx-2">
                            <div id="job-contact">
                            <Link as:button :href="`/job-contact?companyName=${job.companyName}`" class="flex mx-auto text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-sm">簡単応募</Link>
                            </div>
                        </div>

                        <div class="p-2 w-full">
                            <div class="relative flex items-center">
                                <InputLabel for="WantedTitles" class="leading-7 text-sm text-gray-600">募集タイトル：</InputLabel>
                                <p>{{ job.WantedTitles }}</p>
                            </div>
                        </div>

                        <button v-if="!job.showDetails" @click="toggleDetails(job)" class="flex mx-auto text-gray-500 border-0 py-1 px-4 mt-4 focus:outline-none hover:text-gray-700 rounded text-sm">もっと見る</button>

                        <div v-show="job.showDetails">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="Occupation" class="leading-7 text-sm text-gray-600">職種</InputLabel>
                                    <div type="text" id="Occupation" name="Occupation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.Occupation }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="companyAddress" class="leading-7 text-sm text-gray-600">会社の住所</InputLabel>
                                    <div type="text" id="companyAddress" name="companyAddress" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyAddress }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="companyPay" class="leading-7 text-sm text-gray-600">給料</InputLabel>
                                    <div type="text" id="companyPay" name="companyPay" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyPay }}</div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="dutyStation" class="leading-7 text-sm text-gray-600">勤務地</InputLabel>
                                    <div type="text" id="dutyStation" name="dutyStation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.dutyStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="workDescription" class="leading-7 text-sm text-gray-600">仕事内容</InputLabel>
                                    <div type="text" id="workDescription" name="workDescription" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.workDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="payDescription" class="leading-7 text-sm text-gray-600">給与詳細</InputLabel>
                                    <div type="text" id="payDescription" name="payDescription" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.payDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="travelExpenses" class="leading-7 text-sm text-gray-600">交通費</InputLabel>
                                    <div type="text" id="travelExpenses" name="travelExpenses" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.travelExpenses }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="Welfare" class="leading-7 text-sm text-gray-600">福利厚生</InputLabel>
                                    <div type="text" id="Welfare" name="Welfare" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.Welfare }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="startWork" class="leading-7 text-sm text-gray-600">勤務開始時間</InputLabel>
                                    <div type="text" id="startWork" name="startWork" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.startWork.split(':').slice(0, 2).join(':') }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="endWork" class="leading-7 text-sm text-gray-600">勤務終了時間</InputLabel>
                                    <div type="text" id="endWork" name="endWork" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.endWork.split(':').slice(0, 2).join(':') }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="workDays" class="leading-7 text-sm text-gray-600">出勤日</InputLabel>
                                    <div type="text" id="workDays" name="workDays" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.workDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="freeDays" class="leading-7 text-sm text-gray-600">休日</InputLabel>
                                    <div type="text" id="freeDays" name="freeDays" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.freeDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="NearestStation" class="leading-7 text-sm text-gray-600">最寄り駅</InputLabel>
                                    <div type="text" id="NearestStation" name="NearestStation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.NearestStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full mb-4">
                                <div class="relative">
                                    <InputLabel for="workOther" class="leading-7 text-sm text-gray-600">その他</InputLabel>
                                    <div type="text" id="workOther" name="workOther" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.workOther }}
                                    </div>
                                </div>
                            </div>

                            <div id="job-contact" class="text-center">
                                <Link as:button :href="`/job-contact?companyName=${job.companyName}`" class="mx-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-sm">応募する</Link>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </BasePage>
</template>