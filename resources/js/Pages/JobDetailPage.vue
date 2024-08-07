<script setup>
import { router, Link } from '@inertiajs/vue3';

import BasePage from './BasePage.vue';

const props = defineProps({
    id: String,
    inertiaJob: Object,
})

</script>

<template>
    <BasePage>

        <div v-if="props.inertiaJob">
            <!-- {{ props.inertiaJob.id }} -->
            <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-24 mx-auto">
                        <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                                {{ props.inertiaJob.companyName }}
                            </h1>
                        </div>
                        <div class="h-80 w-full mb-12">
                            <img class="w-full h-full object-cover" src="../../../public/images/company_img.jpg" alt="">
                        </div>
                        <div class="mx-auto">
                            <div class="flex flex-wrap -m-2">
                                <div class="p-1 w-full">
                                    <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">募集タイトル</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                        {{ props.inertiaJob.WantedTitles }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="occupation" class="leading-7 text-sm text-gray-600">職種</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.Occupation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="companyAddress" class="leading-7 text-sm text-gray-600">会社の住所</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.companyAddress }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="companyPay" class="leading-7 text-sm text-gray-600">給料</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.companyPay }}円～
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="dutyStation" class="leading-7 text-sm text-gray-600">勤務地</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.dutyStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="workDescription" class="leading-7 text-sm text-gray-600">仕事内容</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.workDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="payDescription" class="leading-7 text-sm text-gray-600">給与詳細</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.payDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="travelExpenses" class="leading-7 text-sm text-gray-600">交通費</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.travelExpenses }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="Welfare" class="leading-7 text-sm text-gray-600">福利厚生</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.Welfare }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="workHours" class="leading-7 text-sm text-gray-600">勤務時間</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.startWork }}～{{ props.inertiaJob.endWork }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="workDays" class="leading-7 text-sm text-gray-600">出勤日</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.workDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="freeDays" class="leading-7 text-sm text-gray-600">休日</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.freeDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="NearestStation" class="leading-7 text-sm text-gray-600">最寄り駅</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.NearestStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <label for="workOther" class="leading-7 text-sm text-gray-600">その他</label>
                                    <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-2 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ props.inertiaJob.workOther }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <Link as="button" href="/jobs" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">戻る</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div v-else>
            <p>データが見つかりません。</p>
        </div>
    </BasePage>
</template>