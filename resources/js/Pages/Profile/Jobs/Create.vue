<script setup>
import { reactive, computed, ref } from 'vue';
import { Link, Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import dayjs from 'dayjs';

const props = defineProps({
    user: Object,
})

const form = reactive({
    company_business: null,
    company_name: null,
    job_title: null,
    start_enrollment: null,
    end_enrollment: null,
    currently_working: false,
});
console.log(form);

//登録処理
const submitFunction = () => {

    // const today = dayjs().format('YYYY-MM-DD');
    // if (form.end_enrollment && form.end_enrollment > today) {
    //     alert('卒業日は本日以前の日付を選択してください');
    //     return;
    // }
    
    Inertia.post(route('jobbg.store'),{
        user_id: props.user.id,
        company_business: form.company_business,
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
        <SiteTitle class="bg-baseColor">職務履歴</SiteTitle>
        <div class="flex justify-around items-center bg-baseColor">
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">1.個人情報</div>
            <div class="w-full py-2 text-center text-sm font-bold border-black border-b-2">2.経歴・職務履歴</div>
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">3.応募条件</div>
        </div>
        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの学歴・職務経歴等を入力します。ここで入力した情報はいつでも修正・削除ができます。ここで入力した情報は求職者一覧にて企業側に情報が開示されます。
            </div>
            <form @submit.prevent="submitFunction" class="mt-6 flex flex-col gap-6">
                <InputLabel value="職務履歴を入力" />
                <TextInput
                    id="company_business"
                    type="text"
                    name="company_business"
                    v-model="form.company_business"
                    placeholder="勤務先の事業内容"
                    required
                />
                <section class=" body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="job_title" class="leading-7 text-sm ">職種名</label>
                                        <input type="text" name="job_title" id="job_title" v-model="form.job_title" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="company_name" class="leading-7 text-sm ">会社名</label>
                                        <input type="text" name="company_name" id="company_name" v-model="form.company_name" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="start_enrollment" class="leading-7 text-sm ">在籍開始</label>
                                        <input type="date" name="start_enrollment" id="start_enrollment" v-model="form.start_enrollment" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="end_enrollment" class="leading-7 text-sm ">在籍終了</label>
                                        <input type="date" name="end_enrollment" id="end_enrollment" v-model="form.end_enrollment" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <input type="checkbox" name="currently_working" id="currently_working" v-model="form.currently_working" class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="currently_working" class="leading-7 text-sm ">現職中</label>
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
        </SectionInner>
    </BaseLayouts>
</template>