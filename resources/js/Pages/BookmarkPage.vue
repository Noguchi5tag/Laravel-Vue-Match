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
    managers: Object,
    applications: Object,
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

const likeFunction = ref(false);
const jobIdToSend = ref(null);
const companyNameToSend = ref(null);

const likeButton = (jobId, companyName) => {
    likeFunction.value = true;
    jobIdToSend.value = jobId;
    companyNameToSend.value = companyName;
};

const closeLikeButton = () => {
    likeFunction.value = false;

    if (jobIdToSend.value && companyNameToSend.value) {
        Inertia.post(`/jobs/${jobIdToSend.value}/apply`, {
            company_name: companyNameToSend.value,
        }, {
            onSuccess: () => {
                alert("データが正常に送信されました！");
                window.location.reload();
            },
            onError: (error) => {
                alert(error.response.data.message || 'エラーが発生しました');
            }
        });
    }
}
</script>

<template>
    <Head title="ブックマーク" />
    <BaseLayouts>
        <section class="relative">
            <SiteTitle>ブックマークした求人</SiteTitle>

            <div v-if="bookmarkedJobs.length === 0">
                <p class="text-center my-10">ブックマークされた求人はありません。</p>
            </div>
            <div v-else class="bookmark-lists my-2">
                <template v-for="job in bookmarkedJobs" :key="job.id">
                    <div class="mb-6 pb-4" v-if="job.status === 1">
                        <carousel :items-to-show="1">
                            <slide v-for="slide in imageCount(job)" :key="slide">
                                <div v-if="job[`image${slide}`]" class="w-full aspect-w-1 aspect-h-1 relative overflow-hidden">
                                    <img 
                                        :src="`/storage/storages/jobs/${job[`image${slide}`]}`" 
                                        alt="" 
                                        class="object-cover w-full h-full"
                                    >
                                    <!-- 右上にブックマークボタンを配置 -->
                                    <div id="bookmark" class="absolute top-4 right-4 bg-white pt-2 px-2 pb-1 rounded-full flex items-center shadow-lg">
                                        <button @click="deleteBookmarkJob(job.id)">
                                            <font-awesome-icon :icon="['fas', 'bookmark']" class="w-5 h-5" />
                                        </button>
                                    </div>

                                    <template v-if="!applications.some(application => application.inertia_job_id === job.id) && !bookmarkedJobs.some(bookmark => bookmark.inertia_job_id === job.id)">
                                        <div id="job-contact" class="absolute bottom-4 right-4 bg-sky-400 p-2 rounded-full shadow-lg border-1 border-white">
                                            <button @click="likeButton(job.id, job.companyName)" class="flex flex-col justify-center items-center text-white">
                                                <font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" />
                                                <span class="text-[6px] text-white">いいね！</span>
                                            </button>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div id="job-contact" class="absolute bottom-4 right-4 bg-sky-400 p-2 rounded-full shadow-lg border-1 border-white">
                                            <div class="flex flex-col justify-center items-center text-white">
                                                <font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" />
                                                <span class="text-[6px] text-white">いいね済</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </slide>
                            <template #addons>
                            <pagination />
                            </template>
                        </carousel>

                        <div class="p-2">
                            <p class="py-1 focus:outline-none text-base font-bold">{{ job.companyName }}　{{ job.dutyStation }}</p>
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

                            <button v-if="!job.showDetails" @click="toggleDetails(job)" class="text-xs">続きを読む</button>

                            <div v-show="job.showDetails" class="flex flex-col gap-4 w-full mt-4">
                                <div>
                                    <InputLabel for="Occupation" class="leading-5">職種</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.Occupation }}</p>
                                </div>
                                <div>
                                    <InputLabel for="workDescription" class="leading-5">仕事内容</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.workDescription }}</p>
                                </div>
                                <div>
                                    <InputLabel for="dutyStation" class="leading-5">勤務地</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.dutyStation }}</p>
                                </div>
                                <div>
                                    <InputLabel for="companyPay" class="leading-5">給料</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.companyPay }}円</p>
                                </div>
                                <div>
                                    <InputLabel for="payDescription" class="leading-5">給与詳細</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.payDescription }}</p>
                                </div>
                                <div>
                                    <InputLabel for="travelExpenses" class="leading-5">交通費</InputLabel>
                                    <p class="text-xs leading-loose">月に{{ job.travelExpenses }}円まで</p>
                                </div>
                                <div>
                                    <InputLabel for="Welfare" class="leading-5">福利厚生</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.Welfare }}</p>
                                </div>
                                <div>
                                    <InputLabel for="startWork" class="leading-5">勤務時間</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.startWork.split(':').slice(0, 2).join(':') }}～{{ job.endWork.split(':').slice(0, 2).join(':') }}</p>
                                </div>
                                <div>
                                    <InputLabel for="workDays" class="leading-5">出勤日</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.workDays }}</p>
                                </div>
                                <div>
                                    <InputLabel for="freeDays" class="leading-5">休日</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.freeDays }}</p>
                                </div>
                                <div>
                                    <InputLabel for="NearestStation" class="leading-5">最寄り駅</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.NearestStation }}</p>
                                </div>
                                <div>
                                    <InputLabel for="workOther" class="leading-5">その他</InputLabel>
                                    <p class="text-xs leading-loose">{{ job.workOther }}</p>
                                </div>

                                <!-- 企業情報 -->
                                <!-- <template  v-if="managers.find(manager => manager.name === job.companyName)">
                                    <CompanyInfo :managers="managers" />
                                </template> -->
                                
                                <div class="flex justify-around mt-4">
                                    <template v-if="!applications.some(application => application.inertia_job_id === job.id) && !bookmarkedJobs.some(bookmark => bookmark.inertia_job_id === job.id)">
                                        <div class="bg-sky-400 py-2 px-10 rounded-full shadow-lg border-1 border-white">
                                            <Link :href="`/job-contact?job_id=${job.id}&companyName=${job.companyName}`" class="text-white flex justify-center items-center">
                                                <span class="text-sm font-bold text-white">企業にいいね</span><font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" /><span class="text-sm font-bold text-white">を送る</span>
                                            </Link>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="bg-gray-300 py-2 px-10 rounded-full shadow-lg border-1 border-white">
                                            <div class="text-white flex justify-center items-center">
                                                <span class="text-sm font-bold text-white">企業にいいね</span><font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" /><span class="text-sm font-bold text-white">を送りました</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button v-if="job.showDetails" @click="toggleDetails(job)" class="text-xs">閉じる</button>
                        </div>
                    </div>
                </template>
            </div>
            <!-- いいねしたとき -->
            <div v-if="likeFunction" class="absolute top-0 left-0 inset-0 bg-black bg-opacity-50 pt-16 px-4">
                <div class="bg-white rounded-lg py-6 px-2">
                    <template  v-if="managers.find(manager => bookmarkedJobs.some(bookmark => bookmark.companyName === manager.name))">
                        <div v-for="manager in managers" :key="manager.id" class="flex flex-col justify-center items-center">
                            <img class="w-12 h-12 object-cover rounded-full" :src="`/storage/storages/manager/${ manager.image_manager }`" alt="プロフィール画像">
                            <p class="text-xs mt-4 font-bold">{{ manager.name }}</p>
                            <h3 class="mt-4 text-sky-400 font-bold text-2xl">いいね！しました</h3>
                            <!-- <div class="text-center">
                                <h3 class="mt-4 text-sky-400 font-bold text-2xl">お互いのいいね！</h3>
                                <p class="font-bold text-base">が成立しました。</p>
                            </div> -->

                            <!-- <div class="bg-sky-100 p-4 mt-6 w-full rounded-b-lg">
                                <p class="font-bold text-center text-base">マッチングした企業に<br>早速メッセージを送ってみましょう！</p>
                                <Link href="#" class="rounded-full bg-green-500 flex items-center justify-center mt-4">
                                    <img class="w-10 h-10" src="../../../../public/images/logo/LINE_logo.png" alt="LINE">
                                    <p class="text-white text-sm">友達追加してメッセージを送る</p>
                                </Link>
                            </div> -->
                        </div>
                    </template>
                </div>
                <button @click="closeLikeButton" class="block rounded-full border-2 border-white text-center mx-auto mt-4 px-8 py-2 text-xs text-white">画面を閉じる</button>
            </div>
        </section>
    </BaseLayouts>
</template>

<style>
.bookmark-lists .carousel__pagination-button--active::after {
    background-color: #38bdf8;
}
</style>