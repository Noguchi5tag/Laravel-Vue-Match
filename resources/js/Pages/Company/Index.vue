<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BasePage from '../../Layouts/BaseLayouts.vue';
import SectionInner from '../../Layouts/SectionInner.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextView from '@/Components/TextView.vue';
import { dutyStations } from '@/data';
import { Occupations } from '@/data';
import { companyPays } from '@/data';


const props = defineProps({
    inertiaJobs: Object,
    managers: Object,
    Carousel: Carousel,
    Slide: Slide,
    Pagination: Pagination,
    Navigation: Navigation
})
console.log(props.managers);

//クエリパラメータを取得
const searchKeyword = ref('');
const searchDutyStation = ref('');
const searchOccupation = ref('');
const searchCompanyPay = ref('');

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    searchKeyword.value = params.get('search') || '';
    searchDutyStation.value = params.get('dutyStation') || '';
    searchOccupation.value = params.get('Occupation') || '';
    searchCompanyPay.value = params.get('companyPay') || '';
});

//検索項目をControllerに送信
const search = ref('')
const dutyStation = ref('')
const Occupation = ref('')
const companyPay = ref('')
const searchCustomers = () => {
    Inertia.get(route('company.index'), {
        search: search.value,
        dutyStation: dutyStation.value,
        Occupation: Occupation.value,
        companyPay: companyPay.value,
    });
}

//画像を取得して表示
const imageCount = (job) => {
    let count = 0;
        for (let i = 1; i <= 5; i++) {
            if (job[`image${i}`]) {
                count++;
            }
        }
    return count;
}

const jobs = ref(props.inertiaJobs.data);
const toggleDetails = (job) => {
    job.showDetails = !job.showDetails;
};

const showSearch = ref(false);
const search_button = () => {
    showSearch.value = !showSearch.value;
}

// Inertiaを使ったブックマーク機能
const bookmarkJob = (jobId) => {
    Inertia.post(`/bookmark/${jobId}`, {}, {
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
    <Head title="ホーム" />
    <BasePage>
        <section class="relative pb-12 mx-auto">
            <div v-if="inertiaJobs.data.length" class="job-lists">
                <template v-for="job in inertiaJobs.data" :key="job.id">
                    <div class="mb-6 pb-4" v-if="job.status === 1">

                        <carousel :items-to-show="1">
                            <slide v-for="slide in imageCount(job)" :key="slide">
                                <div v-if="job[`image${slide}`]" class="w-full aspect-w-1 aspect-h-1 relative overflow-hidden">
                                    <img 
                                        :src="`/images/${job[`image${slide}`]}`" 
                                        alt="" 
                                        class="object-cover w-full h-full"
                                    >

                                    <!-- 右上にブックマークボタンを配置 -->
                                    <div id="bookmark" class="absolute top-4 right-4 bg-white pt-2 px-2 pb-1 rounded-full flex items-center shadow-lg">
                                        <button @click="bookmarkJob(job.id)">
                                            <font-awesome-icon :icon="['far', 'bookmark']" class="w-5 h-5" />
                                        </button>
                                    </div>

                                    <div id="job-contact" class="absolute bottom-4 right-4 bg-sky-400 p-2 rounded-full shadow-lg border-1 border-white">
                                        <Link as:button :href="`/job-contact?job_id=${job.id}&companyName=${job.companyName}`" class="flex flex-col text-white">
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

                        <div class="m-4">
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

                            <div v-show="job.showDetails" class="flex flex-col gap-2 w-full">
                                <div class="">
                                    <InputLabel for="Occupation" class="leading-5">職種</InputLabel>
                                    <TextView >{{ job.Occupation }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="workDescription" class="leading-5">仕事内容</InputLabel>
                                    <TextView>{{ job.workDescription }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="dutyStation" class="leading-5">勤務地</InputLabel>
                                    <TextView>{{ job.dutyStation }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="companyPay" class="leading-5">給料</InputLabel>
                                    <TextView>{{ job.companyPay }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="payDescription" class="leading-5">給与詳細</InputLabel>
                                    <TextView>{{ job.payDescription }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="travelExpenses" class="leading-5">交通費</InputLabel>
                                    <TextView>{{ job.travelExpenses }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="Welfare" class="leading-5">福利厚生</InputLabel>
                                    <TextView>{{ job.Welfare }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="startWork" class="leading-5">勤務開始時間</InputLabel>
                                    <TextView>{{ job.startWork.split(':').slice(0, 2).join(':') }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="endWork" class="leading-5">勤務終了時間</InputLabel>
                                    <TextView>{{ job.endWork.split(':').slice(0, 2).join(':') }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="workDays" class="leading-5">出勤日</InputLabel>
                                    <TextView>{{ job.workDays }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="freeDays" class="leading-5">休日</InputLabel>
                                    <TextView>{{ job.freeDays }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="NearestStation" class="leading-5">最寄り駅</InputLabel>
                                    <TextView>{{ job.NearestStation }}</TextView>
                                </div>
                                <div class="">
                                    <InputLabel for="workOther" class="leading-5">その他</InputLabel>
                                    <TextView>{{ job.workOther }}</TextView>
                                </div>

                                <div v-if="managers" class="mt-6">
                                    <div class="bg-stone-50 -mx-4 py-4">
                                        <InputLabel class="pl-4">企業情報</InputLabel>
                                        <div class="mx-4 my-2 px-4 bg-white">
                                            <template v-for="manager in managers" :key="manager.id">
                                                <div class="flex gap-4 py-4 border-b-2 border-stone-50">
                                                    <img class="w-12 h-12 object-cover rounded-full" src="../../../../public/images/job01.jpg" alt="">
                                                    <div class="">
                                                        <h3 class="text-base font-bold">{{ manager.name }}</h3>
                                                        <a href="#" class="text-sm" target="_blank">https:://google.com</a>
                                                    </div>
                                                </div>
                                                <div class="py-4 flex flex-col gap-2">
                                                    <div class="">
                                                        <InputLabel>名称</InputLabel>
                                                        <p class="text-xs leading-loose">{{ manager.name }}</p>
                                                    </div>
                                                    <div class="">
                                                        <InputLabel>所在地</InputLabel>
                                                        <p class="text-xs leading-loose">〒{{ manager.manager_address_number }}　{{ manager.manager_address }}</p>
                                                    </div>
                                                    <div class="">
                                                        <InputLabel>電話番号</InputLabel>
                                                        <p class="text-xs leading-loose">{{ manager.tel_manager }}</p>
                                                    </div>
                                                    <div class="">
                                                        <InputLabel>事業内容</InputLabel>
                                                        <p class="text-xs leading-loose">{{ manager.business }}</p>
                                                    </div>
                                                    <div class="">
                                                        <InputLabel>採用担当</InputLabel>
                                                        <p class="text-xs leading-loose">{{ manager.recruit_manager }}</p>
                                                    </div>
                                                    <div class="">
                                                        <InputLabel>その他</InputLabel>
                                                        <p class="text-xs leading-loose">{{ manager.other_manager }}</p>
                                                    </div>
                                                </div>

                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-around mt-4">
                                    <div class="bg-sky-400 py-2 px-10 rounded-full shadow-lg border-1 border-white">
                                        <Link :href="`/job-contact?job_id=${job.id}&companyName=${job.companyName}`" class="text-white flex justify-center items-center">
                                            <span class="text-sm font-bold text-white">企業にいいね</span><font-awesome-icon :icon="['fas', 'thumbs-up']" class="px-2 py-1" /><span class="text-sm font-bold text-white">を送る</span>
                                        </Link>
                                    </div>
                                    <div class="pt-2 px-2 pb-1 flex items-center">
                                        <button @click="bookmarkJob(job.id)">
                                            <font-awesome-icon :icon="['far', 'bookmark']" class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button v-if="job.showDetails" @click="toggleDetails(job)" class="text-xs">閉じる</button>
                        </div>
                    </div>
                </template>
            </div>
            <!-- 検索結果がない場合の表示 -->
            <template v-else>
                <p class="text-center ">データがありません。検索条件を変更してください。</p>
            </template>

            <div v-if="inertiaJobs.data.length && inertiaJobs.links.length" class="flex justify-center">
                <ul class="pagination flex">
                    <li v-for="(link, index) in inertiaJobs.links" :key="link.label" :class="{ 'active': link.active }">
                        <!-- "前"のリンクを表示しない（インデックスが0かつリンクが存在しない場合） -->
                        <template v-if="index !== 0 || link.url">
                            <!-- "次"のリンクを表示しない（最終ページでかつリンクが存在しない場合） -->
                            <template v-if="index !== inertiaJobs.links.length - 1 || link.url">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    v-html="link.label"
                                    :class="{ 
                                        'bg-indigo-500 text-white p-2 mx-2': link.active,
                                        'bg-gray-200 text-black p-2 mx-2': !link.active
                                    }">
                                </Link>
                                <span 
                                    v-else v-html="link.label" 
                                    :class="{ 
                                        'bg-indigo-500 text-white p-2': link.active ,
                                        'bg-gray-200 text-black': !link.active
                                        }">
                                </span>
                            </template>
                        </template>
                    </li>
                </ul>
            </div>
        </section>
    </BasePage>
</template>

<style>
.job-lists .carousel__item {
    min-height: 200px;
    width: 100%;
    background-color: var(--vc-clr-primary);
    color: var(--vc-clr-white);
    display: flex;
    justify-content: center;
    align-items: center;
}

.job-lists .carousel__slide {
    padding: 2px;
}

.job-lists .carousel__prev,
.job-lists .carousel__next {
    color: white;
}

.job-lists .carousel__pagination-button--active::after {
    background-color: #38bdf8;
}

.fade-slide-enter-active, .fade-slide-leave-active {
    transition: all 0.5s ease;
}

.fade-slide-enter-from, .fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>