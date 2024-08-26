<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BasePage from '../BasePage.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    inertiaJobs: Object,
    Carousel: Carousel,
    Slide: Slide,
    Pagination: Pagination,
    Navigation: Navigation
})

//クエリパラメータを取得
const searchKeyword = ref('');
const dutyStationKeyword = ref('');
const occupationKeyword = ref('');
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    searchKeyword.value = params.get('search') || '';
    dutyStationKeyword.value = params.get('dutyStation') || '';
    occupationKeyword.value = params.get('Occupation') || '';
});

//検索項目をControllerに送信
const search = ref('')
const dutyStation = ref('')
const Occupation = ref('')
const searchCustomers = () => {
    Inertia.get(route('company.index'), {
        search: search.value,
        dutyStation: dutyStation.value,
        Occupation: Occupation.value,
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

const dutyStations = [
    { value: '長崎市', label: '長崎市' },
    { value: '島原市', label: '島原市' },
    { value: '雲仙市', label: '雲仙市' },
    { value: '南島原市', label: '南島原市' },
    { value: '諫早市', label: '諫早市' },
    { value: '西海市', label: '西海市' },
    { value: '五島市', label: '五島市' },
    { value: '平戸市', label: '平戸市' },
    { value: '壱岐市', label: '壱岐市' },
    { value: '対馬市', label: '対馬市' },
    { value: '松浦市', label: '松浦市' },
    { value: '新上五島市', label: '新上五島市' },
];

const Occupations = [
    { value: '営業', label: '営業' },
    { value: '事務', label: '事務' },
    { value: 'エンジニア', label: 'エンジニア' },
    { value: 'デザイナー', label: 'デザイナー' },
    { value: 'その他', label: 'その他' },
];
</script>

<template>
    <Head title="求人一覧" />
    <BasePage>

    <!-- フラッシュメッセージ -->
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>

        <section class="text-gray-600 body-font relative">
            <div class="container px-4 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">求人一覧</h1>
                </div>
                
                <div class="mx-auto">
                    <div class="p-2 w-full my-6">
                        <Link as="button" :href="route('company.create')" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            新規登録
                        </Link>
                    </div>

                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 pb-24 mx-auto">
                            <div class="mx-auto">
                                <div class="-m-2">
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="dutyStation" class="leading-7 text-sm text-gray-600">勤務地からさがす</label>
                                            <select name="dutyStation" id="dutyStation" v-model="dutyStation">
                                                <option v-for="dutyStation in dutyStations" :value="dutyStation.value" :key="dutyStation.value">
                                                    {{ dutyStation.label }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="Occupation" class="leading-7 text-sm text-gray-600">職種からさがす</label>
                                            <select name="Occupation" id="Occupation" v-model="Occupation">
                                                <option v-for="occupation in Occupations" :value="occupation.value" :key="occupation.value">
                                                    {{ occupation.label }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="email" class="leading-7 text-sm text-gray-600">給料からさがす</label>
                                            <input type="email" id="email" name="email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="search" class="leading-7 text-sm text-gray-600">キーワード検索</label>
                                        <input type="text" name="search" id="search" v-model="search" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="text-center flex">
                                        <button @click="searchCustomers" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索する</button>
                                        <Link as:button href="/jobs" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">条件のリセット</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="">
                        <template v-if="dutyStationKeyword">
                            <p>勤務地：{{ dutyStationKeyword }}</p>
                        </template>
                        <template v-if="occupationKeyword">
                            <p>職種：{{ occupationKeyword }}</p>
                        </template>
                        <template v-if="dutyStationKeyword">
                            <p>給料：</p>
                        </template>
                        <template v-if="searchKeyword">
                            <p>キーワード：{{ searchKeyword }}</p>
                        </template>
                    </div>

                    <div v-if="inertiaJobs.data.length" class="-m-2">
                        <template v-for="job in inertiaJobs.data" :key="job.id">
                            <div class="rounded-lg bg-gray-100 my-6 py-6 " v-if="job.status === 1">
                                <div class="flex flex-col text-center w-full mb-6">
                                    <h1 class="text-3xl font-medium title-font mb-4 text-gray-900">
                                        {{ job.companyName }}
                                    </h1>
                                </div>
    
                                <carousel :items-to-show="1.5">
                                    <slide v-for="slide in imageCount(job)" :key="slide">
                                        <div v-if="job[`image${slide}`]" class="carousel__item">
                                            <img :src="`/images/${job[`image${slide}`]}`" alt="" class="w-full h-full object-cover">
                                        </div>
                                    </slide>
                                    <template #addons>
                                    <navigation />
                                    <pagination />
                                    </template>
                                </carousel>
    
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyName" class="leading-7 text-sm text-gray-600">会社名</label>
                                        <div type="text" id="companyName" name="companyName" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyName }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="WantedTitles" class="leading-7 text-sm text-gray-600">募集タイトル</label>
                                        <div type="text" id="WantedTitles" name="WantedTitles" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.WantedTitles }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="Occupation" class="leading-7 text-sm text-gray-600">職種</label>
                                        <div type="text" id="Occupation" name="Occupation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.Occupation }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyAddress" class="leading-7 text-sm text-gray-600">会社の住所</label>
                                        <div type="text" id="companyAddress" name="companyAddress" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyAddress }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <!-- 管理者か一般ユーザーで、"view"か"show"かルートを分ける -->
                                    <Link as="button" :href="route('company.show', { id: job.id })" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">詳細へ</Link>
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
</style>