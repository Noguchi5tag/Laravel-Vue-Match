<script setup>
import { reactive } from 'vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '../../../Layouts/BaseLayouts.vue';
import dayjs from 'dayjs';

const props = defineProps({
    user: Object,
})

const form = reactive({
    job_title: null,
    company_name: null,
    start_enrollment: null,
    end_enrollment: null,
    currently_working: false,
});
console.log(form);

//登録処理
const submitFunction = () => {

    const today = dayjs().format('YYYY-MM-DD');
    if (form.end_enrollment && form.end_enrollment > today) {
        alert('卒業日は本日以前の日付を選択してください');
        return;
    }
    
    Inertia.post(route('jobbg.store'),{
        user_id: props.user.id,
        job_title: form.job_title,
        company_name: form.company_name,
        start_enrollment: form.start_enrollment,
        end_enrollment: form.end_enrollment,
        currently_working: form.currently_working,
    });
};
</script>

<template>
<Head title="職務履歴登録" />
    <BaseLayouts>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">職務履歴登録</h2>
        </template>

        <div class="py-6">
            <form @submit.prevent="submitFunction">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <!-- 消す -->
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="user_id" class="leading-7 text-sm text-gray-600">ユーザーID</label>
                                        <input type="text" name="user_id" id="user_id" v-model="props.user.id" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <!-- 消す -->
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="job_title" class="leading-7 text-sm text-gray-600">職種名</label>
                                        <input type="text" name="job_title" id="job_title" v-model="form.job_title" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="company_name" class="leading-7 text-sm text-gray-600">会社名</label>
                                        <input type="text" name="company_name" id="company_name" v-model="form.company_name" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="start_enrollment" class="leading-7 text-sm text-gray-600">在籍開始</label>
                                        <input type="date" name="start_enrollment" id="start_enrollment" v-model="form.start_enrollment" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="end_enrollment" class="leading-7 text-sm text-gray-600">在籍終了</label>
                                        <input type="date" name="end_enrollment" id="end_enrollment" v-model="form.end_enrollment" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <input type="checkbox" name="currently_working" id="currently_working" v-model="form.currently_working" class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="currently_working" class="leading-7 text-sm text-gray-600">現職中</label>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </BaseLayouts>
</template>