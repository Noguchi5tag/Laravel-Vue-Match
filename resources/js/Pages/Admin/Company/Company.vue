<script setup>
import { Head, router, Link } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { ref, onMounted, computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    id: String,
    inertiaJob: Object,
})

const keyWords = props.inertiaJob.search_keywords.join(', ') || 'キーワード';

const imageCount = (job) => {
    let count = 0;
    for (let i = 1; i <= 5; i++) {
        if (job[`image${i}`]) {
            count++;
        }
    }
    return count;
}

const relocationStatus = computed(() => {
    return props.inertiaJob.relocation ? '有' : '無';
});
</script>

<template>
    <Head title="求人詳細" />
    <AuthenticatedLayout>

        <div v-if="props.inertiaJob" class=" max-w-screen-md mx-auto">
            <section class=" body-font relative">
                <div class="container px-4 py-24 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                            {{ props.inertiaJob.companyName }}
                        </h1>
                    </div>

                    <div class="w-1/2 mx-auto">
                        <carousel :items-to-show="1">
                            <slide v-for="slide in imageCount(props.inertiaJob)" :key="slide">
                                <div v-if="props.inertiaJob[`image${slide}`]" class="carousel__item">
                                    <img :src="`/storage/storages/jobs/${props.inertiaJob[`image${slide}`]}`" alt="" class="w-full h-full object-cover">
                                </div>
                            </slide>
                            <template #addons>
                                <navigation />
                                <pagination />
                            </template>
                        </carousel>
                    </div>

                    <div class="mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="募集タイトル" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.WantedTitles }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="職種" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.Occupation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="雇用形態" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.employment_type }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="年収または月収" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.salary_type }} {{ props.inertiaJob.salary_amount }}円
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="勤務地" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.prefecture }}{{ props.inertiaJob.dutyStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="転勤の有無" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ relocationStatus }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="仕事内容" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.workDescription }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="入社時期" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.job_join }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="交通費 / 月" class="leading-7 text-sm " />
                                    <div v-if="props.inertiaJob.travelExpenses" class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.travelExpenses }}円
                                    </div>
                                    <div v-else class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">未設定</div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="勤務時間" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.startWork.split(':').slice(0, 2).join(':') }}～{{ props.inertiaJob.endWork.split(':').slice(0, 2).join(':') }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="出勤日" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.workDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="休日" class="leading-7 text-sm " />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.freeDays }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="最寄り駅" class="leading-7 text-sm" />
                                    <div class="w-full bg-white rounded border border-gray-300 text-base outline-none py-1 px-2 leading-8">
                                        {{ props.inertiaJob.NearestStation }}
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="その他" class="leading-7 text-sm " />
                                    <div v-if="props.inertiaJob.workOther" class="w-full bg-white rounded border border-gray-300 py-1 px-2 leading-8">
                                        {{ props.inertiaJob.workOther }}
                                    </div>
                                    <div v-else class="w-full bg-white rounded border border-gray-300 py-1 px-2 leading-8">未設定</div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="こだわり条件" class="leading-7 text-sm " />
                                    <div v-if="props.inertiaJob.particular_type" class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.particular_type }}
                                    </div>
                                    <div v-else class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">未設定</div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="その他福利厚生" class="leading-7 text-sm " />
                                    <div v-if="props.inertiaJob.Welfare" class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">
                                        {{ props.inertiaJob.Welfare }}
                                    </div>
                                    <div v-else class="w-full bg-white rounded border border-gray-300 text-base py-1 px-2 leading-8">未設定</div>
                                </div>
                            </div>

                            <div class="p-1 w-full">
                                <div class="relative">
                                    <InputLabel value="検索キーワード" class="leading-7 text-sm " />
                                    <div v-if="keyWords" class="w-full bg-white rounded border border-gray-300  text-base outline-none py-1 px-2 leading-8">
                                        {{ keyWords }}
                                    </div>
                                </div>
                            </div>

                            <div class="w-full">
                                <div class="relative">
                                    <InputLabel value="求人の公開状況" class="leading-7 text-sm " />
                                    <div class="">
                                        <p class="w-full bg-white rounded border border-gray-300 text-base outline-none py-1 px-2 leading-8"> 
                                            <span v-if="props.inertiaJob.status === 0">非公開</span>
                                            <span v-else>公開</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="p-2 w-full">
                                <div class="p-2">
                                    <Link as="button" :href="route('admin.company.edit', { inertiaJob: props.inertiaJob.id })" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集する</Link>
                                </div>
                            </div>
                            
                            <div class="p-2 w-full">
                                <Link as="button" href="/admin/companylist" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg">戻る</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div v-else>
            <p>データが見つかりません。</p>
        </div>
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