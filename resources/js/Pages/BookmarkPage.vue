<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import BaseLayouts from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

const props = defineProps({
    bookmarkedJobs: Array,
})
console.log(props.bookmarkedJobs);

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

const deleteBookmarkJob = (jobId) => {
    Inertia.delete(`/bookmark/${jobId}`, {}, {
        onSuccess: () => {
            alert(page.props.flash.message);
            window.location.reload();
        },
        onError: () => {
            alert(error.response.data.message || 'エラーが発生しました');
        }
    });
};
</script>

<template>
    <Head title="ブックマーク" />
    <BaseLayouts>
        <div>
            <SiteTitle>ブックマークした求人</SiteTitle>

            <div v-if="bookmarkedJobs.length === 0">
                <p class="text-center my-10">ブックマークされた求人はありません。</p>
            </div>
            <div v-else class="bookmark-lists m-2">
                <template v-for="job in bookmarkedJobs" :key="job.id">
                    <div class="mb-6 pb-4" v-if="job.status === 1">
                        <carousel :items-to-show="1">
                            <slide v-for="slide in imageCount(job)" :key="slide" class="!w-full">
                            <div v-if="job[`image${slide}`]" class="w-full aspect-w-1 aspect-h-1 relative overflow-hidden">
                                <img :src="`/images/${job[`image${slide}`]}`" alt="" class="object-cover w-full h-full">

                                <!-- 右上にブックマークボタンを配置 -->
                                <div id="bookmark" class="absolute top-4 right-4 bg-white pt-2 px-2 pb-1 rounded-full flex items-center shadow-lg">
                                    <button @click="deleteBookmarkJob(job.id)">
                                        <font-awesome-icon :icon="['far', 'bookmark']" class="w-5 h-5" />
                                    </button>
                                </div>

                                <div id="job-contact" class="absolute bottom-4 right-4 bg-sky-400 p-2 rounded-full shadow-lg border-1 border-white">
                                    <Link as:button :href="`/job-contact?companyName=${job.companyName}`" class="flex flex-col text-white">
                                        <font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" />
                                        <span class="text-[6px] text-white">いいね！</span>
                                    </Link>
                                </div>
                            </div>
                            </slide>
                            <template #addons>
                            <navigation />
                            <pagination />
                            </template>
                        </carousel>

                        <div class="p-2">
                            <button v-if="!job.showDetails" @click="toggleDetails(job)" class="py-1 focus:outline-none text-base font-bold">{{ job.companyName }}　{{ job.dutyStation }}</button>
                            <div class="w-full flex justify-between items-center">
                                <div class="relative flex items-center">
                                    <font-awesome-icon :icon="['fas', 'comment']" class="w-4 h-4" />
                                    <InputLabel for="WantedTitles" class="ml-2 leading-7 text-xs ">{{ job.WantedTitles }}</InputLabel>
                                </div>
                                <div class="flex items-center gap-1">
                                    <font-awesome-icon :icon="['far', 'bookmark']" class="w-4 h-4" />
                                    <p class="pt-1">{{ job.bookmarked_by_users_count }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 w-full">
                            <div class="relative flex items-center">
                                <InputLabel for="WantedTitles" class="leading-7 text-sm ">募集タイトル：</InputLabel>
                                <p>{{ job.WantedTitles }}</p>
                            </div>
                        </div>

                        <button v-if="!job.showDetails" @click="toggleDetails(job)" class="flex mx-auto text-gray-500 border-0 py-1 px-4 mt-4 focus:outline-none hover:text-gray-700 rounded text-sm">もっと見る</button>

                        <div v-show="job.showDetails">
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="Occupation" class="leading-7 text-sm ">職種</InputLabel>
                                    <div type="text" id="Occupation" name="Occupation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.Occupation }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="companyAddress" class="leading-7 text-sm ">会社の住所</InputLabel>
                                    <div type="text" id="companyAddress" name="companyAddress" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyAddress }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="companyPay" class="leading-7 text-sm ">給料</InputLabel>
                                    <div type="text" id="companyPay" name="companyPay" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyPay }}</div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="dutyStation" class="leading-7 text-sm ">勤務地</InputLabel>
                                    <div type="text" id="dutyStation" name="dutyStation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.dutyStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="workDescription" class="leading-7 text-sm ">仕事内容</InputLabel>
                                    <div type="text" id="workDescription" name="workDescription" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.workDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="payDescription" class="leading-7 text-sm ">給与詳細</InputLabel>
                                    <div type="text" id="payDescription" name="payDescription" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.payDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="travelExpenses" class="leading-7 text-sm ">交通費</InputLabel>
                                    <div type="text" id="travelExpenses" name="travelExpenses" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.travelExpenses }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="Welfare" class="leading-7 text-sm ">福利厚生</InputLabel>
                                    <div type="text" id="Welfare" name="Welfare" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.Welfare }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="startWork" class="leading-7 text-sm ">勤務開始時間</InputLabel>
                                    <div type="text" id="startWork" name="startWork" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.startWork.split(':').slice(0, 2).join(':') }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="endWork" class="leading-7 text-sm ">勤務終了時間</InputLabel>
                                    <div type="text" id="endWork" name="endWork" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.endWork.split(':').slice(0, 2).join(':') }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="workDays" class="leading-7 text-sm ">出勤日</InputLabel>
                                    <div type="text" id="workDays" name="workDays" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.workDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="freeDays" class="leading-7 text-sm ">休日</InputLabel>
                                    <div type="text" id="freeDays" name="freeDays" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.freeDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full">
                                <div class="relative">
                                    <InputLabel for="NearestStation" class="leading-7 text-sm ">最寄り駅</InputLabel>
                                    <div type="text" id="NearestStation" name="NearestStation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ job.NearestStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 w-full mb-4">
                                <div class="relative">
                                    <InputLabel for="workOther" class="leading-7 text-sm ">その他</InputLabel>
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
    </BaseLayouts>
</template>

<style>
.bookmark-lists .carousel__pagination-button--active::after {
    background-color: #38bdf8;
}
</style>