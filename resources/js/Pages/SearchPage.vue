<script setup>
import { Head, Link, usePage  } from '@inertiajs/vue3';
import BaseLayouts from '../Layouts/BaseLayouts.vue';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted, watch, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { companyPays, requirements, prefectures, dutyStations, jobJoin, employment, particulars } from '@/data.js';
import SectionInner from '../Layouts/SectionInner.vue';
import 'vue3-carousel/dist/carousel.css'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextView from '@/Components/TextView.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import NavLink from '../Components/NavLink.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';
import CompanyInfo from './Company/CompanyInfo.vue';


const props = defineProps({
    inertiaJobs: Object,
    managers: Object,
    Carousel: Carousel,
    Slide: Slide,
    Pagination: Pagination,
    Navigation: Navigation
})

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

const selectedCategories = ref([]);
const dutyStation = ref('');
const prefecture = ref('');
const selectedParticulars = ref([]);
const search = ref('')

// 各カテゴリの表示・非表示フラグとデータをまとめて定義
const jobCategories = ref([
    { label: '営業', visible: false, requirements: requirements.find(req => req.label === '営業').value },
    { label: '医療・福祉', visible: false, requirements: requirements.find(req => req.label === '医療・福祉').value },
    { label: 'ITエンジニア', visible: false, requirements: requirements.find(req => req.label === 'ITエンジニア').value },
    { label: 'クリエイティブ', visible: false, requirements: requirements.find(req => req.label === 'クリエイティブ').value },
    { label: '美容・ブライダル・ホテル・交通', visible: false, requirements: requirements.find(req => req.label === '美容・ブライダル・ホテル・交通').value }
]);
// カテゴリの表示・非表示を切り替える関数
const toggleCategoryVisible = (categoryLabel) => {
    const category = jobCategories.value.find(cat => cat.label === categoryLabel);
    if (category) {
        category.visible = !category.visible;
    }
};

// 選択された給与タイプ（1つ目のセレクトボックス）
const salaryType = ref('');
// 選択された金額（2つ目のセレクトボックス）
const selectedAmount = ref('');
// 2つ目のセレクトボックスの選択肢を動的に管理する
const salaryOptions = computed(() => {
    if (salaryType.value === '月給') {
        // 月給を選択した場合の金額（20〜50の範囲で10単位）
        return Array.from({ length: 4 }, (_, i) => (20 + i * 10));
    } else if (salaryType.value === '年収') {
        // 年収を選択した場合の金額（250〜1000の範囲で100単位）
        return Array.from({ length: 8 }, (_, i) => (300 + i * 100));
    } else {
        return [];
    }
});
// 給与タイプが変更された際に金額の選択をリセットする
watch(salaryType, () => {
    selectedAmount.value = '';
});

const particularsCategories = ref([
    { label: '募集について', visible: false, particulars: particulars.find(req => req.label === '募集について').value },
    { label: '仕事について', visible: false, particulars: particulars.find(req => req.label === '仕事について').value },
    { label: '会社について', visible: false, particulars: particulars.find(req => req.label === '会社について').value },
    { label: '待遇、職場環境について', visible: false, particulars: particulars.find(req => req.label === '待遇、職場環境について').value },
]);
const toggleParticularsVisible = (particularsLabel) => {
    const particular = particularsCategories.value.find(cat => cat.label === particularsLabel);
    if (particular) {
        particular.visible = !particular.visible;
    }
};

const showSearchOptions = ref(true);

//クエリパラメータを取得
const searchKeyword = ref('');
const searchCompanyPay = ref('');
onMounted(() => {
    const params = new URLSearchParams(window.location.search);

    const occupationParams = [];
    let o_index = 0;
    // Occupation[] の形式でクエリパラメータを取得
    while (params.has(`Occupation[${o_index}]`)) {
        occupationParams.push(params.get(`Occupation[${o_index}]`));
        o_index++;
    }
    if (occupationParams.length > 0) {
        selectedCategories.value = occupationParams;
    }
    if (params.has('dutyStation')) {
        dutyStation.value = params.get('dutyStation');
    }
    if (params.has('prefecture')) {
        prefecture.value = params.get('prefecture');
    }
    if (params.has('search')) {
        search.value = params.get('search');
    }
    if (params.has('salaryType')) {
        salaryType.value = params.get('salaryType');
    }
    if (params.has('companyPay')) {
        selectedAmount.value = params.get('companyPay');
        console.log('selectedAmount:', selectedAmount.value);
    }

    const particularsParams = [];
    let p_index = 0;
    while (params.has(`particulars[${p_index}]`)) {
        particularsParams.push(params.get(`particulars[${p_index}]`));
        p_index++;
    }
    if (particularsParams.length > 0) {
        selectedParticulars.value = particularsParams;
    }
});



// 検索条件が設定されているかをチェック
const hasSearchConditions = () => {
    return (
        selectedCategories.value.length > 0 ||
        salaryType.value !== '' ||
        selectedAmount.value !== '' ||
        prefecture.value !== '' ||
        dutyStation.value !== ''||
        search.value !== '' ||
        selectedParticulars.value.length > 0
    );
};

//検索項目をControllerに送信
const searchCustomers = () => {

    if (!hasSearchConditions()) {
        alert('少なくとも1つの検索条件を入力してください。');
        return;
    } else {
        showSearchOptions.value = false;
        localStorage.setItem('showSearchOptions', JSON.stringify(false));

        Inertia.get(route('search'), {
            Occupation: selectedCategories.value, //職種
            dutyStation: dutyStation.value,
            prefecture: prefecture.value,
            search: search.value,
            salaryType: salaryType.value,
            companyPay: selectedAmount.value,
            particulars: selectedParticulars.value, //こだわり
        });
    }
}

//検索条件クリア
const clearFilters = () => {
    selectedCategories.value = [];
    dutyStation.value = '';
    prefecture.value = '';
    salaryType.value = '';
    selectedAmount.value = '';
    search.value = '';
    selectedParticulars.value = [];
};

// 検索条件表示ボタンのクリック時に表示を切り替え
const showSearchOptionsSection = () => {
    showSearchOptions.value = true;
    localStorage.setItem('showSearchOptions', JSON.stringify(true));
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
    <BaseLayouts>
        <SiteTitle>求人を探す</SiteTitle>
        <section class="relative pb-6 mx-auto">

            <!-- <template v-if="!showSearchOptions"> -->
                <transition name="fade-slide" mode="out-in">
                    <section class="flex flex-col justify-center gap-4 p-4">
                        <div>

                            <div class="border-b-2 border-baseColor pb-4">
                                <InputLabel value="職種からさがす" class="pb-2" />
                                <!-- 各職種カテゴリを繰り返し表示 -->
                                <div v-for="(category, index) in jobCategories" :key="index" class="mb-4">
                                    <div @click="toggleCategoryVisible(category.label)" class="w-full bg-baseColor py-2 flex justify-between items-center px-4 cursor-pointer">
                                        <div class="text-left text-sm">{{ category.label }}</div>
                                        <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                                    </div>
                                    <!-- カテゴリが開いている時に職種を表示 -->
                                    <div v-if="category.visible" class="border-baseColor border-2 py-2 px-4">
                                        <div class="flex flex-wrap gap-2">
                                            <div v-for="job in category.requirements" :key="job.value" class="flex items-center space-x-2">
                                                <input type="checkbox" :id="job.value" v-model="selectedCategories" :value="job.label" class="bg-baseColor border-none" />
                                                <label :for="job.value" class="text-sm">{{ job.label }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-b-2 border-baseColor py-4">
                                <InputLabel value="希望年収または月収" class="pb-2" />
                                <div class="mt-2 flex items-end gap-2">
                                    <select v-model="salaryType" class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-baseColor border-gray-200">
                                        <option disabled value="">月給・年収</option>
                                        <option value="月給">月給</option>
                                        <option value="年収">年収</option>
                                    </select>
                                    <select v-model="selectedAmount" class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-baseColor border-gray-200" :disabled="salaryOptions.length === 0">
                                        <option disabled value="">金額</option>
                                        <option v-for="option in salaryOptions" :key="option" :value="option">
                                            {{ option }}
                                        </option>
                                    </select>
                                    <div class="text-sm font-bold">万円 以上</div>
                                </div>
                            </div>

                            <div class="border-b-2 border-baseColor py-4">
                                <InputLabel value="希望勤務地" class="pb-2" />
                                <div>
                                    <p class="text-sm">都道府県</p>
                                    <select v-model="prefecture" class="w-full text-sm border-gray-200 border-2 px-4 py-2 rounded-md bg-baseColor">
                                        <option disabled value="">都道府県</option>
                                        <option v-for="prefecture in prefectures" :key="prefecture" :value="prefecture">
                                            {{ prefecture }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <p class="text-sm">市町村</p>
                                    <select v-model="dutyStation" class="w-full text-sm border-2 px-4 py-2 rounded-md bg-baseColor border-gray-200">
                                        <option disabled value="">市町村</option>
                                        <option v-for="dutyStation in dutyStations" :key="dutyStation.value" :value="dutyStation.value">
                                            {{ dutyStation.label }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="border-b-2 border-baseColor py-4">
                                <InputLabel value="こだわり条件" class="pb-2" />
                                <div>
                                    <!-- 各職種カテゴリを繰り返し表示 -->
                                    <div v-for="(particular, index) in particularsCategories" :key="index" class="mb-4">
                                        <div @click="toggleParticularsVisible(particular.label)" class="w-full bg-baseColor py-2 flex justify-between items-center px-4 cursor-pointer">
                                            <div class="text-left text-sm">{{ particular.label }}</div>
                                            <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                                        </div>
                                        <!-- カテゴリが開いている時に職種を表示 -->
                                        <div v-if="particular.visible" class="border-baseColor border-2 py-2 px-4">
                                            <div class="flex flex-wrap gap-2">
                                                <div v-for="job in particular.particulars" :key="job.value" class="flex items-center space-x-2">
                                                    <input type="checkbox" :id="job.value" v-model="selectedParticulars" :value="job.label" class="bg-baseColor border-none" />
                                                    <label :for="job.value" class="text-sm">{{ job.label }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-b-2 border-baseColor py-4 flex justify-between items-center">
                                <InputLabel for="search" class="leading-7 text-sm ">キーワード検索</InputLabel>
                                <TextInput type="text" name="search" id="search" placeholder="キーワード" v-model="search" class="text-sm w-2/3" />
                            </div>

                            <div class="text-center flex justify-around items-center mt-4">
                                <button @click="clearFilters" class="block px-8 py-3 text-sky-400 border-2 border-sky-400 rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">クリア</button>

                                <PrimaryButton 
                                    v-if=" selectedCategories.length > 0 ||
                                    dutyStation !== '' || 
                                    prefecture !== '' ||
                                    salaryType !== '' || 
                                    selectedAmount !== '' ||
                                    selectedParticulars.length > 0 ||
                                    search !== '' "
                                    @click="searchCustomers"
                                >
                                    この条件で検索する
                                </PrimaryButton>
                                <div v-else class="inline-flex items-center px-12 py-3 bg-gray-400 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest">この条件で検索する</div>
                            </div>
                        </div>
                    </section>
                </transition>
            <!-- </template> -->

            <!-- 検索結果 -->
            <!-- <template v-else> -->
    
                    <div class="my-2 text-center">
                        <PrimaryButton @click="showSearchOptionsSection">条件を変更する</PrimaryButton>
                    </div>
    
                    <div class="bg-baseColor p-1">
                        <ul class="bg-white m-2 p-2 rounded-lg">
                            <li>
                                <template v-if="selectedCategories.length > 0">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">職種</p>
                                        <div class="opacity-50 text-xs">{{ selectedCategories.join(', ') }}</div>
                                    </div>
                                </template>
                            </li>

                            <li>
                                <template v-if="prefecture || dutyStation">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">勤務地</p>
                                        <div class="opacity-50 text-xs">{{ prefecture }} {{ dutyStation }}</div>
                                    </div>
                                </template>
                            </li>
                            
                            <li>
                                <template v-if="salaryType || selectedAmount">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">年収または月給</p>
                                        <div class="opacity-50 text-xs">{{ salaryType }} {{ selectedAmount }}万円</div>
                                    </div>
                                </template>
                            </li>

                            <li>
                                <template v-if="selectedParticulars.length > 0">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">こだわり条件</p>
                                        <div class="opacity-50 text-xs">{{ selectedParticulars.join(', ') }}</div>
                                    </div>
                                </template>
                            </li>

                            <li>
                                <template v-if="search">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center px-6 py-1 text-sky-400 border border-sky-400 border-transparent rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">キーワード</p>
                                        <div class="opacity-50 text-xs">{{ search }}</div>
                                    </div>
                                </template>
                            </li>
                            
                        </ul>
                    </div>
    
                    <div v-if="inertiaJobs.data.length" class="job-lists">
                        <template v-for="job in inertiaJobs.data" :key="job.id">
                            <div class="mb-6" v-if="job.status === 1">
        
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
        
                                        <CompanyInfo :managers="managers" />
                                        
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
                        <p class="py-10 text-center">求人がありません。検索条件を変更してください。</p>
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
            <!-- </template> -->
        </section>
    </BaseLayouts>
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