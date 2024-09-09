<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
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

const pageProps = usePage().props;
const totalNewJobs = pageProps.totalNewJobs || 0;
</script>

<template>
    <Head title="新着求人" />
    <AuthenticatedLayout>
        <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">新着求人：{{ totalNewJobs }}件</h2>
    </template>
    <!-- フラッシュメッセージ -->
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>

        <section class="text-gray-600 body-font relative max-w-screen-md mx-auto">
            <div class="container px-4 py-10 mx-auto">
                <div class="mx-auto">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 pb-24 mx-auto">
                            <div class="mx-auto">
                                <div class="-m-2">
                                    <div class="p-2 w-full">
                                        <InputLabel for="search" class="leading-7 text-sm text-gray-600">キーワード検索</InputLabel>
                                        <TextInput type="text" name="search" id="search" v-model="search" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                    <div class="p-2 w-full">
                                        <InputLabel for="companySearch" class="leading-7 text-sm text-gray-600">会社名で検索</InputLabel>
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
                            <div class="rounded-lg bg-white my-6 py-6 ">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyName" class="leading-7 text-sm text-gray-600">会社名</InputLabel>
                                        <div type="text" id="companyName" name="companyName" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyName }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="WantedTitles" class="leading-7 text-sm text-gray-600">募集タイトル</InputLabel>
                                        <div type="text" id="WantedTitles" name="WantedTitles" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.WantedTitles }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyAddress" class="leading-7 text-sm text-gray-600">会社の住所</InputLabel>
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
    </AuthenticatedLayout>
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