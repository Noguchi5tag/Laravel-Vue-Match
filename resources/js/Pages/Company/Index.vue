<script setup>
import { Link } from '@inertiajs/vue3';

import BasePage from '../BasePage.vue';

defineProps({
    inertiaJobs: Array,
})
</script>

<template>
    <BasePage>

    <!-- フラッシュメッセージ -->
    <!-- <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div> -->

        <section class="text-gray-600 body-font relative">
            <div class="container px-4 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">求人一覧</h1>
                </div>
                
                <div class="mx-auto">
                    <div class="p-2 w-full">
                        <Link as="button" :href="route('company.create')" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</Link>
                    </div>
                    <hr>

                    <div v-if="inertiaJobs" class="-m-2" >
                        <div v-for="job in inertiaJobs" :key="job.id" class="">
                            <div class="flex flex-col text-center w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                                    {{ job.companyName }}
                                </h1>
                            </div>
                            <div class="h-80 w-full my-12">
                                <img class="w-full h-full object-cover" src="../../../../public/images/company_img.jpg" alt="">
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">会社名</label>
                                    <div type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyName }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">募集タイトル</label>
                                    <div type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.WantedTitles }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">職種</label>
                                    <div type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.Occupation }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">会社の住所</label>
                                    <div type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyAddress }}</div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <!-- 管理者か一般ユーザーでルートを分ける -->
                                <Link as="button" :href="route('company.view', { id: job.id })" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">詳細へ</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </BasePage>
</template>