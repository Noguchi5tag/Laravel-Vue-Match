<script setup>
import { Head, Link, usePage  } from '@inertiajs/vue3';
import BasePage from '../Layouts/BaseLayouts.vue';
import SectionInner from '../Layouts/SectionInner.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextView from '@/Components/TextView.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import NavLink from '../Components/NavLink.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';

import { companyPays } from '@/data';


const props = defineProps({
    inertiaJobs: Object,
    managers: Object,
    Carousel: Carousel,
    Slide: Slide,
    Pagination: Pagination,
    Navigation: Navigation
})
console.log(props);

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

const showSearchOptions = ref(false);

//クエリパラメータを取得
const searchKeyword = ref('');
const searchCompanyPay = ref('');
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    searchKeyword.value = params.get('search') || '';
    searchCompanyPay.value = params.get('companyPay') || '';
});

const search = ref('')
const companyPay = ref('')
//ローカルストレージから取得
const savedOccupations = ref([]);
onMounted(() => {
    savedOccupations.value = JSON.parse(localStorage.getItem('selectedOccupations') || '[]');
});
const savedDutyStations = ref([]);
onMounted(() => {
    savedDutyStations.value = JSON.parse(localStorage.getItem('selectedDutyStations') || '[]');
});

// 検索条件が設定されているかをチェック
const hasSearchConditions = () => {
    return (
        search.value !== '' ||
        companyPay.value !== '' ||
        savedOccupations.value.length > 0 ||
        savedDutyStations.value.length > 0
    );
};

//検索項目をControllerに送信
const searchCustomers = () => {
    if (!hasSearchConditions()) {
        alert('少なくとも1つの検索条件を入力してください。');
        return;
    }
    Inertia.get(route('search'), {
        search: search.value,
        dutyStation: savedDutyStations.value,
        Occupation: savedOccupations.value,
        companyPay: companyPay.value,
    });
}

//検索条件クリア
const clearFilters = () => {
    search.value = '';
    companyPay.value = null; 
    savedOccupations.value = [];
    savedDutyStations.value = []; 
    localStorage.removeItem('selectedOccupations');
    localStorage.removeItem('selectedDutyStations'); 
};

// 検索条件表示ボタンのクリック時に表示を切り替え
const showSearchOptionsSection = () => {
    showSearchOptions.value = true;
};

//  続きを見る、閉じる
const toggleDetails = (job) => {
    job.showDetails = !job.showDetails;
};

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
    <Head title="検索" />
    <BasePage>
        <SiteTitle>求人を探す</SiteTitle>
        <section class="relative py-1b mx-auto">

            <!-- <template v-if="showSearchOptions"> -->
                <transition name="fade-slide" mode="out-in">
                    <section class="h-screen relative">
                        <div class="p-4">
                            <div class="mx-auto">

                                <div class="p-2 w-full flex justify-between items-center border-b-baseColor border-b">
                                    <InputLabel for="Occupation" class="leading-7 text-sm">職種</InputLabel>
                                    <NavLink v-if="savedOccupations.length" href="/jobs-choose" class="opacity-50 text-xs">{{ savedOccupations.join(', ') }}</NavLink>
                                    <NavLink v-else href="/jobs-choose" class="opacity-50 text-xs">指定なし</NavLink>
                                </div>

                                <div class="p-2 w-full flex justify-between items-center border-b-baseColor border-b">
                                    <InputLabel for="dutyStation" class="leading-7 text-sm ">エリア</InputLabel>
                                    <span v-if="savedDutyStations.length" class="opacity-50 text-xs">{{ savedDutyStations.join(', ') }}</span>
                                    <NavLink v-else href="/area-choose" class="opacity-50 text-xs">指定なし</NavLink>
                                </div>
                                
                                <div class="p-2 w-full flex justify-between items-center border-b-baseColor border-b">
                                    <InputLabel for="companyPay" class="leading-7 text-sm ">給料からさがす</InputLabel>
                                    <select name="companyPay" id="companyPay" v-model="companyPay" class="border-gray-200 rounded-lg text-sm">
                                        <option value="">指定なし</option>
                                        <option v-for="companyPay in companyPays" :value="companyPay.value" :key="companyPay.value" class="text-sm">
                                            <p>{{ companyPay.label }}</p>
                                        </option>
                                    </select>
                                </div>
                                <div class="p-2 w-full flex justify-between items-center border-b-baseColor border-b">
                                    <InputLabel for="search" class="leading-7 text-sm ">キーワード検索</InputLabel>
                                    <TextInput type="text" name="search" id="search" placeholder="キーワード" v-model="search" class="text-sm" />
                                </div>
                                <div class="text-center flex justify-around items-center mt-4">
                                    <PrimaryButton @click="searchCustomers">この条件で検索する</PrimaryButton>
                                    <button @click="clearFilters" class="inline-flex items-center px-8 py-3 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">クリア</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </transition>
            <!-- </template> -->

            <!-- 検索結果 -->
            <template v-if="!showSearchOptions">
                <template v-if="savedOccupations.length > 0 || savedDutyStations.length > 0 ||  searchCompanyPay || searchKeyword ">
    
                    <div class="my-2 text-center">
                        <PrimaryButton @click="showSearchOptionsSection">条件を変更する</PrimaryButton>
                    </div>
    
                    <div class="bg-baseColor p-1">
                        <ul class="bg-white m-2 p-4 rounded-lg">
                            <li>
                                <template v-if="savedOccupations">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">職種</p>
                                        <p class="ml-2 opacity-50 text-xs">{{ savedOccupations.join(', ') }}</p>
                                    </div>
                                </template>
                            </li>
                            <li>
                                <template v-if="savedDutyStations.value">
                                    <div class="flex items-center mt-2">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">エリア</p>
                                        <p class="ml-2 opacity-50 text-xs">{{ savedDutyStations.join(', ') }}</p>
                                    </div>
                                </template>
                            </li>
                            <li>
                                <template v-if="searchCompanyPay">
                                    <div class="flex items-center mt-2">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">エリア</p>
                                        <p class="ml-2 opacity-50 text-xs">{{ companyPays.find(pay => pay.value === searchCompanyPay)?.label || '該当なし' }}</p>
                                    </div>
                                </template>
                            </li>
                            <li>
                                <template v-if="searchKeyword">
                                    <div class="flex items-center mt-2">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">エリア</p>
                                        <p class="ml-2 opacity-50 text-xs">{{ searchKeyword }}</p>
                                    </div>
                                </template>
                            </li>
                        </ul>
                    </div>
    
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
                                                            <img class="w-12 h-12 object-cover rounded-full" src="../../../public/images/job01.jpg" alt="">
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
                </template>
            </template>


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