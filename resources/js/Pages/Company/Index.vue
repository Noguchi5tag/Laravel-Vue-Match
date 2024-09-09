<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BasePage from '../../Layouts/BaseLayouts.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { dutyStations } from '@/data';
import { Occupations } from '@/data';
import { companyPays } from '@/data';


const props = defineProps({
    inertiaJobs: Object,
    Carousel: Carousel,
    Slide: Slide,
    Pagination: Pagination,
    Navigation: Navigation
})
console.log(props.inertiaJobs);

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

</script>

<template>
    <Head title="ホーム" />
    <BasePage>

    <!-- フラッシュメッセージ -->
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>

        <section class="text-gray-600 body-font relative">
            <div class="container px-4 py-12 mx-auto">
                <div class="mx-auto">
                    <button 
                        @click="search_button" 
                        class="absolute top-3 right-2 text-white bg-indigo-500 border-0 mb-2 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-sm">
                        絞り込み<br>検索
                    </button>
                    <transition name="fade-slide" mode="out-in">
                        <section v-if="showSearch" class="text-gray-600 body-font relative">
                            <div class="container px-5 pb-12 mx-auto">
                                <div class="mx-auto">
                                    <div class="-m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <InputLabel for="dutyStation" class="leading-7 text-sm text-gray-600">勤務地からさがす</InputLabel>
                                                <select name="dutyStation" id="dutyStation" v-model="dutyStation">
                                                    <option v-for="dutyStation in dutyStations" :value="dutyStation.value" :key="dutyStation.value">
                                                        {{ dutyStation.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <InputLabel for="Occupation" class="leading-7 text-sm text-gray-600">職種からさがす</InputLabel>
                                                <select name="Occupation" id="Occupation" v-model="Occupation">
                                                    <option v-for="occupation in Occupations" :value="occupation.value" :key="occupation.value">
                                                        {{ occupation.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <InputLabel for="companyPay" class="leading-7 text-sm text-gray-600">給料からさがす</InputLabel>
                                                <select name="companyPay" id="companyPay" v-model="companyPay">
                                                    <option v-for="companyPay in companyPays" :value="companyPay.value" :key="companyPay.value">
                                                        {{ companyPay.label }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <InputLabel for="search" class="leading-7 text-sm text-gray-600">キーワード検索</InputLabel>
                                            <TextInput type="text" name="search" id="search" v-model="search" class="w-full" />
                                        </div>
                                        <div class="text-center flex">
                                            <button @click="searchCustomers" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索する</button>
                                            <Link as:button href="/" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">条件のリセット</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </transition>

                    <div class="pb-6">
                        <template v-if="searchDutyStation || searchOccupation || searchCompanyPay || searchKeyword">
                            <h1>選択した検索条件</h1>
                        </template>
                        <ul>
                            <li>
                                <template v-if="searchDutyStation">
                                    勤務地：{{ searchDutyStation }}
                                </template>
                            </li>
                            <li>
                                <template v-if="searchOccupation">
                                    職種：{{ searchOccupation }}
                                </template>
                            </li>
                            <li>
                                <template v-if="searchCompanyPay">
                                    給料：{{ companyPays.find(pay => pay.value === searchCompanyPay)?.label || '該当なし' }}
                                </template>
                            </li>
                            <li>
                                <template v-if="searchKeyword">
                                    キーワード：{{ searchKeyword }}
                                </template>
                            </li>
                        </ul>
                    </div>

                    <div v-if="inertiaJobs.data.length && inertiaJobs.links.length" class="my-6 flex justify-center">
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

                    <div v-if="inertiaJobs.data.length" class="-m-2">
                        <template v-for="job in inertiaJobs.data" :key="job.id">
                            <div class="my-2 py-2 border-t border-gray-300" v-if="job.status === 1">
                                <div class="flex flex-col text-center w-full mb-1">
                                    <h1 class="text-xl font-medium title-font text-gray-900">
                                        {{ job.companyName }}
                                    </h1>
                                </div>
    
                                <carousel :items-to-show="1">
                                    <slide v-for="slide in imageCount(job)" :key="slide" class="!w-full">
                                        <div v-if="job[`image${slide}`]" class="carousel__item  w-full">
                                            <img :src="`/images/${job[`image${slide}`]}`" alt="" class="w-full h-auto object-cover">
                                        </div>
                                    </slide>
                                    <template #addons>
                                        <navigation />
                                        <pagination />
                                    </template>
                                </carousel>

                                <div class="flex justify-between items-center">
                                    <div id="bookmark" class="">
                                        <img class="w-8" src="../../../../public/images/address.png" alt="">
                                        <InputLabel for="bookmark" class="text-sm">保存</InputLabel>
                                    </div>
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

                                <button v-if="!job.showDetails" @click="toggleDetails(job)" class="flex mx-auto text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-sm">もっと見る</button>
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

                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <InputLabel for="workOther" class="leading-7 text-sm text-gray-600">その他</InputLabel>
                                            <div type="text" id="workOther" name="workOther" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ job.workOther }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- 検索結果がない場合の表示 -->
                    <template v-else>
                        <p class="text-center text-gray-600">データがありません。検索条件を変更してください。</p>
                    </template>

                    <div v-if="inertiaJobs.data.length && inertiaJobs.links.length" class="mt-6 flex justify-center">
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
                </div>
            </div>
        </section>
    </BasePage>
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

.fade-slide-enter-active, .fade-slide-leave-active {
    transition: all 0.5s ease;
}

.fade-slide-enter-from, .fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}
</style>