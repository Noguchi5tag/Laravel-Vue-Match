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
    school_classification: null,
    school_name: null,
    department: null,
    matriculation: null,
    graduation: null,
    undergraduate: false,
});

//登録処理
const submitFunction = () => {

    const today = dayjs().format('YYYY-MM-DD');
    if (form.graduation && form.graduation > today) {
        alert('卒業日は本日以前の日付を選択してください');
        return;
    }
    
    Inertia.post(route('academic.store'),{
        user_id: props.user.id,
        school_classification: form.school_classification,
        school_name: form.school_name,
        department: form.department,
        matriculation: form.matriculation,
        graduation: form.graduation,
        undergraduate: form.undergraduate,
    });
};
</script>

<template>
<Head title="学歴登録" />
    <BaseLayouts>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">学歴登録</h2>
        </template>

        <div class="py-6">
            <form @submit.prevent="submitFunction">
                <section class=" body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="school_classification" class="leading-7 text-sm ">学校区分</label>
                                        <input type="text" name="school_classification" id="school_classification" v-model="form.school_classification" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="school_name" class="leading-7 text-sm ">学校名</label>
                                        <input type="text" name="school_name" id="school_name" v-model="form.school_name" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="department" class="leading-7 text-sm ">学部・学科</label>
                                        <input type="text" name="department" id="department" v-model="form.department" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="matriculation" class="leading-7 text-sm ">入学</label>
                                        <input type="date" name="matriculation" id="matriculation" v-model="form.matriculation" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="graduation" class="leading-7 text-sm ">卒業</label>
                                        <input type="date" name="graduation" id="graduation" v-model="form.graduation" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <input type="checkbox" name="undergraduate" id="undergraduate" v-model="form.undergraduate" class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="undergraduate" class="leading-7 text-sm ">在学中</label>
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