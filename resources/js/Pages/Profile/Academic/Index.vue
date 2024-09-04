<script setup>
import { reactive } from 'vue';
import { Link, Head, useForm  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '../../../Layouts/BaseLayouts.vue';
import dayjs from 'dayjs';

const props = defineProps({
    academic_bgs: Array,
})

const form = useForm({
    id: props.academic_bgs[0].id,
    user_id: props.academic_bgs[0].user_id,
    school_classification: props.academic_bgs[0].school_classification,
    school_name: props.academic_bgs[0].school_name,
    department: props.academic_bgs[0].department,
    matriculation: props.academic_bgs[0].matriculation,
    graduation: props.academic_bgs[0].graduation,
    undergraduate: props.academic_bgs[0].undergraduate,
});

const updateFunction = () => {
    const today = dayjs().format('YYYY-MM-DD');
    if (form.graduation && form.graduation > today) {
        alert('卒業日は本日以前の日付を選択してください');
        return;
    }
    form.put(route('academic.update', form.id));
};

const deleteFunction = () => {
    if (confirm('本当に削除しますか？')) {
        Inertia.delete(route('academic.destroy', form.id));
    }
};
</script>

<template>
    <Head title="学歴一覧" />
    <BaseLayouts>
            <!-- フラッシュメッセージ -->
            <div v-if="$page.props.flash.message" class="bg-blue-300">
                {{ $page.props.flash.message }}
            </div>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">学歴一覧</h2>
        </template>

        
        <section class="text-gray-600 body-font relative">
            <div class="container px-4 py-10 mx-auto">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-12 mx-auto">
                        <div class="flex flex-col text-center w-full mb-6">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">編集フォーム</h1>
                        </div>
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="school_classification" class="leading-7 text-sm text-gray-600">学校区分</label>
                                        <input type="text" name="school_classification" id="school_classification" v-model="form.school_classification" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <label for="school_name" class="leading-7 text-sm text-gray-600">学校名</label>
                                        <input type="text" name="school_name" id="school_name" v-model="form.school_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <label for="department" class="leading-7 text-sm text-gray-600">学部・学科</label>
                                        <input type="text" name="department" id="department" v-model="form.department" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <label for="matriculation" class="leading-7 text-sm text-gray-600">入学</label>
                                        <input type="date" name="matriculation" id="matriculation" v-model="form.matriculation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <label for="graduation" class="leading-7 text-sm text-gray-600">卒業</label>
                                        <input type="date" name="graduation" id="graduation" v-model="form.graduation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" name="undergraduate" id="undergraduate" v-model="form.undergraduate" true-value="1" false-value="0" class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="undergraduate" class="leading-7 text-sm text-gray-600">在学中</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="p-2 w-full mb-2 flex justify-between">
                    <button  @click.prevent="updateFunction" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                    <button @click.prevent="deleteFunction" class="flex text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                </div>
                <hr>
                <Link as="button" :href="route('academic.create')" class="flex mx-auto my-2 text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">新しく追加する</Link>
            </div>
        </section>
    </BaseLayouts>
</template>