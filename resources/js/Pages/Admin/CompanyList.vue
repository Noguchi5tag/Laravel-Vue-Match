<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import { ref, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    inertiaJobs: Object,
    Carousel: Carousel,
    Slide: Slide,
    Pagination: Pagination,
    Navigation: Navigation,
    totalJobs: Number,
})

//クエリパラメータを取得
const searchKeyword = ref('');
const company_Search = ref('');

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    searchKeyword.value = params.get('search') || '';
    company_Search.value = params.get('companySearch') || '';
});

//検索項目をControllerに送信
const search = ref('')
const companySearch = ref('')
const searchCustomers = () => {
    Inertia.get(route('admin.companylist.index'), {
        search: search.value,
        companySearch: companySearch.value,
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
</script>

<template>
    <Head title="求人一覧" />
    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template v-if="totalJobs > 0">
                    {{ totalJobs }}つの求人
                </template>
                <template v-else>
                    求人がありません
                </template>
            </h2>
        </template>
        <!-- フラッシュメッセージ -->
        <div v-if="$page.props.flash.message" class="bg-blue-300">
            {{ $page.props.flash.message }}
        </div>

        <section class=" body-font relative max-w-screen-md mx-auto">
            <div class="container px-4 py-10 mx-auto">
                <div class="mx-auto">
                    <section class=" body-font relative">
                        <div class="container px-5 pb-24 mx-auto">
                            <div class="mx-auto">
                                <div class="-m-2">
                                    <div class="p-2 w-full">
                                        <InputLabel for="search" class="leading-7 text-sm ">キーワード検索</InputLabel>
                                        <TextInput type="text" name="search" id="search" v-model="search" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                    <div class="p-2 w-full">
                                        <InputLabel for="companySearch" class="leading-7 text-sm ">会社名で検索</InputLabel>
                                        <TextInput type="text" name="companySearch" id="companySearch" v-model="companySearch" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                    <div class="text-center flex">
                                        <button @click="searchCustomers" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索する</button>
                                        <Link as:button href="/admin/companylist" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">条件のリセット</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="pb-6">
                        <template v-if="searchKeyword || company_Search">
                            <h1>選択した検索条件</h1>
                        </template>
                        <ul>
                            <li>
                                <template v-if="company_Search">
                                    会社名：{{ company_Search }}
                                </template>
                            </li>
                            <li>
                                <template v-if="searchKeyword">
                                    キーワード：{{ searchKeyword }}
                                </template>
                            </li>
                        </ul>
                    </div>

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

                    <div v-if="inertiaJobs.data.length" class="-m-2">
                        <template v-for="job in inertiaJobs.data" :key="job.id">
                            <div class="rounded-lg bg-gray-100 my-6 py-6 ">
                                <div class="flex flex-col text-center w-full mb-6">
                                    <h1 class="text-3xl font-medium title-font mb-4 text-gray-900">
                                        {{ job.companyName }}
                                    </h1>
                                </div>
    
                                <div class="w-1/2 mx-auto">
                                    <carousel :items-to-show="1">
                                        <slide v-for="slide in imageCount(job)" :key="slide">
                                            <div v-if="job[`image${slide}`]" class="carousel__item">
                                                <img :src="`/storage/storages/jobs/${job[`image${slide}`]}`" alt="" class="w-full h-full object-cover">
                                            </div>
                                        </slide>
                                        <template #addons>
                                        <navigation />
                                        <pagination />
                                        </template>
                                    </carousel>
                                </div>
    
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyName" class="leading-7 text-sm ">会社名</InputLabel>
                                        <div type="text" id="companyName" name="companyName" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyName }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="WantedTitles" class="leading-7 text-sm ">募集タイトル</InputLabel>
                                        <div type="text" id="WantedTitles" name="WantedTitles" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.WantedTitles }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="Occupation" class="leading-7 text-sm ">職種</InputLabel>
                                        <div type="text" id="Occupation" name="Occupation" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.Occupation }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyAddress" class="leading-7 text-sm ">会社の住所</InputLabel>
                                        <div type="text" id="companyAddress" name="companyAddress" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyAddress }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <Link as="button" :href="route('admin.company.show', { id: job.id })" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">詳細へ</Link>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- 検索結果がない場合の表示 -->
                    <template v-else>
                        <p class="text-center ">データがありません。検索条件を変更してください。</p>
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
    </AdminAuthenticatedLayout>
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