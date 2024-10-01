<script setup>
import { Head, useForm  } from '@inertiajs/vue3';
import BaseLayouts from '../../../Layouts/BaseLayouts.vue';
import dayjs from 'dayjs';

const props = defineProps({
    jobBgs: Array,
})

const form = useForm({
    id: props.jobBgs[0].id,
    user_id: props.jobBgs[0].user_id,
    job_title: props.jobBgs[0].job_title,
    company_name: props.jobBgs[0].company_name,
    start_enrollment: props.jobBgs[0].start_enrollment,
    end_enrollment: props.jobBgs[0].end_enrollment,
    currently_working: props.jobBgs[0].currently_working,
});

const updateFunction = () => {
    const today = dayjs().format('YYYY-MM-DD');
    if (form.end_enrollment && form.end_enrollment > today) {
        alert('卒業日は本日以前の日付を選択してください');
        return;
    }
    form.put(route('jobbg.update', form.id));
};
</script>

<template>
    <Head title="職務履歴一覧" />

    <BaseLayouts>
            <!-- フラッシュメッセージ -->
            <div v-if="$page.props.flash.message" class="bg-blue-300">
                {{ $page.props.flash.message }}
            </div>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">職務履歴一覧</h2>
        </template>

        
        <section class=" body-font relative">
            <div class="container px-4 py-10 mx-auto">
                <section class=" body-font relative">
                    <div class="container px-4 py-12 mx-auto">
                        <div class="flex flex-col text-center w-full mb-6">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">編集フォーム</h1>
                        </div>
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative mb-2">
                                        <label for="job_title" class="leading-7 text-sm ">職種名</label>
                                        <input type="text" name="job_title" id="job_title" v-model="form.job_title" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative mb-2">
                                        <label for="company_name" class="leading-7 text-sm ">会社名</label>
                                        <input type="text" name="company_name" id="company_name" v-model="form.company_name" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative mb-2">
                                        <label for="start_enrollment" class="leading-7 text-sm ">在籍開始</label>
                                        <input type="date" name="start_enrollment" id="start_enrollment" v-model="form.start_enrollment" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative mb-2">
                                        <label for="end_enrollment" class="leading-7 text-sm ">在籍終了</label>
                                        <input type="date" name="end_enrollment" id="end_enrollment" v-model="form.end_enrollment" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative mb-2">
                                        <input type="checkbox" name="currently_working" id="currently_working" v-model="form.currently_working" true-value="1" false-value="0" class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="currently_working" class="leading-7 text-sm ">現職中</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="p-2 w-full mb-2 flex justify-center">
                    <button  @click.prevent="updateFunction" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                </div>
            </div>
        </section>
    </BaseLayouts>
</template>