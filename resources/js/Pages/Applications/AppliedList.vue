<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import BaseLayouts from '../../Layouts/BaseLayouts.vue';
import SiteTitle from '../../Components/SiteTitle.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

const props = defineProps({
    applications: Array,
    bookmarkedJobs: Array,
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

const jobs = ref(props.bookmarkedJobs);
const toggleDetails = (application) => {
    application.showDetails = !application.showDetails;
};

const isBookmarked = (jobId) => {
    return props.bookmarkedJobs.some(job => job.id === jobId);
};

const bookmarkJob = (jobId) => {
    Inertia.post(`/bookmark/${jobId}?applied`, {}, {
        onSuccess: () => {
            alert(page.props.flash.message);
        },
        onError: () => {
            alert(error.response.data.message || 'エラーが発生しました');
        }
    });
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
    <Head title="いいね！済リスト" />
    <BaseLayouts>
        <div>
            <SiteTitle>いいね！した求人</SiteTitle>

            <div v-if="applications.length === 0">
                <p class="text-center my-10">応募した求人はまだありません</p>
            </div>
            <div v-else class="my-2">
                <template v-for="application in applications" :key="application.id">
                    <carousel :items-to-show="1">
                        <slide v-for="slide in imageCount(application.job)" :key="slide">
                            <div 
                                v-if="application.job[`image${slide}`]" 
                                class="w-full aspect-w-1 aspect-h-1 relative overflow-hidden"
                            >
                                <img 
                                    :src="`/storage/storages/jobs/${application.job[`image${slide}`]}`" 
                                    alt="" 
                                    class="object-cover w-full h-full"
                                >
                                <!-- 右上にブックマークボタンを配置 -->
                                <div id="bookmark" class="absolute top-4 right-4 bg-white pt-2 px-2 pb-1 rounded-full flex items-center shadow-lg">
                                    <template v-if="isBookmarked(application.job.id)">
                                        <button @click="deleteBookmarkJob(application.job.id)">
                                            <font-awesome-icon :icon="['fas', 'bookmark']" class="w-5 h-5" />
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button @click="bookmarkJob(application.job.id)">
                                            <font-awesome-icon :icon="['far', 'bookmark']" class="w-5 h-5" />
                                        </button>
                                    </template>
                                </div>
                                
                                <div id="job-contact" class="absolute bottom-4 right-4 bg-sky-400 p-2 rounded-full shadow-lg border-1 border-white">
                                    <div class="flex flex-col justify-center items-center text-white">
                                        <font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" />
                                        <span class="text-[6px] text-white">いいね済</span>
                                    </div>
                                </div>
                            </div>
                        </slide>
                        <template #addons>
                        <pagination />
                        </template>
                    </carousel>

                    <div class="p-2">
                        <p class="py-1 focus:outline-none text-base font-bold">{{ application.job.companyName }}　{{ application.job.dutyStation }}</p>
                        <div class="w-full flex justify-between items-center">
                            <div class="relative flex items-center">
                                <font-awesome-icon :icon="['fas', 'comment']" class="w-4 h-4" />
                                <InputLabel for="WantedTitles" class="ml-2 leading-7 text-xs ">{{ application.job.WantedTitles }}</InputLabel>
                            </div>
                            <div class="flex items-center gap-1">
                                <font-awesome-icon :icon="['far', 'bookmark']" class="w-4 h-4" />
                                <p class="pt-1">
                                    {{ 
                                        bookmarkedJobs.find(bookmarkedJob => bookmarkedJob.companyName === application.job.companyName)?.bookmarked_by_users_count || 0 
                                    }}
                                </p>
                            </div>
                        </div>

                        <button v-if="!application.showDetails" @click="toggleDetails(application)" class="text-xs">続きを読む</button>

                        <div v-show="application.showDetails" class="flex flex-col gap-4 w-full mt-4">
                            <div>
                                <InputLabel for="Occupation" class="leading-5">職種</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.Occupation }}</p>
                            </div>
                            <div>
                                <InputLabel for="workDescription" class="leading-5">仕事内容</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.workDescription }}</p>
                            </div>
                            <div>
                                <InputLabel for="dutyStation" class="leading-5">勤務地</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.dutyStation }}</p>
                            </div>
                            <div>
                                <InputLabel for="companyPay" class="leading-5">給料</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.companyPay }}円</p>
                            </div>
                            <div>
                                <InputLabel for="payDescription" class="leading-5">給与詳細</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.payDescription }}</p>
                            </div>
                            <div>
                                <InputLabel for="travelExpenses" class="leading-5">交通費</InputLabel>
                                <p class="text-xs leading-loose">月に{{ application.job.travelExpenses }}円まで</p>
                            </div>
                            <div>
                                <InputLabel for="Welfare" class="leading-5">福利厚生</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.Welfare }}</p>
                            </div>
                            <div>
                                <InputLabel for="startWork" class="leading-5">勤務時間</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.startWork.split(':').slice(0, 2).join(':') }}～{{ application.job.endWork.split(':').slice(0, 2).join(':') }}</p>
                            </div>
                            <div>
                                <InputLabel for="workDays" class="leading-5">出勤日</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.workDays }}</p>
                            </div>
                            <div>
                                <InputLabel for="freeDays" class="leading-5">休日</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.freeDays }}</p>
                            </div>
                            <div>
                                <InputLabel for="NearestStation" class="leading-5">最寄り駅</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.NearestStation }}</p>
                            </div>
                            <div>
                                <InputLabel for="workOther" class="leading-5">その他</InputLabel>
                                <p class="text-xs leading-loose">{{ application.job.workOther }}</p>
                            </div>

                            <!-- 企業情報 -->
                            <!-- <template  v-if="managers.find(manager => manager.name === job.companyName)">
                                <CompanyInfo :managers="managers" />
                            </template> -->
                            
                            <div class="flex justify-around mt-4">
                                <div class="bg-gray-300 py-2 px-10 rounded-full shadow-lg border-1 border-white">
                                    <div class="text-white flex justify-center items-center">
                                        <span class="text-sm font-bold text-white">企業にいいね</span><font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" /><span class="text-sm font-bold text-white">を送りました</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button v-if="application.showDetails" @click="toggleDetails(application)" class="text-xs">閉じる</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </BaseLayouts>
</template>