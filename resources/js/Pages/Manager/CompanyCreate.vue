<script setup>
import { reactive } from 'vue';
import { Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { dutyStations } from '@/data';
import { Occupations } from '@/data';

const props = defineProps({
    manager: Array,
});

const form = reactive({
    companyName: props.manager.name,
    WantedTitles: '',
    Occupation: '',
    companyAddress: props.manager.manager_address,
    companyPay: '',
    dutyStation: '',
    workDescription: '',
    payDescription: '',
    travelExpenses: '',
    Welfare: '',
    startWork: '',
    endWork: '',
    workDays: '',
    freeDays: '',
    NearestStation: '',
    workOther: '',
    search_keywords: '',
    status: 0,
    registrant: props.managerName,
    is_checked: 0,
    image1: '',
    image2: '',
    image3: '',
    image4: '',
    image5: '',
});

//登録処理
const submitFunction = () => {
    const formData = new FormData();
    for (const key in form) {
        formData.append(key, form[key]);
    }
    Inertia.post('/manager/company/job', formData);
}
</script>

<template>
<Head title="求人登録" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">求人登録</h2>
        </template>

        <!-- フラッシュメッセージ -->
        <div v-if="$page.props.flash.message" class="bg-blue-300">
            {{ $page.props.flash.message }}
        </div>
        <div class="py-6 max-w-screen-md mx-auto">
            <form @submit.prevent="submitFunction" enctype="multipart/form-data">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyName" class="leading-7 text-sm text-gray-600">会社名</InputLabel>
                                        <TextInput type="text" name="companyName" id="companyName" v-model="form.companyName" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="WantedTitles" class="leading-7 text-sm text-gray-600">募集タイトル</InputLabel>
                                        <TextInput type="text" name="WantedTitles" id="WantedTitles" v-model="form.WantedTitles" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="Occupation" class="leading-7 text-sm text-gray-600">職種</InputLabel>
                                        <select name="Occupation" id="Occupation" v-model="form.Occupation">
                                            <option v-for="occupation in Occupations" :value="occupation.value" :key="occupation.value">
                                                {{ occupation.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyAddress" class="leading-7 text-sm text-gray-600">会社の住所</InputLabel>
                                        <TextInput type="text" name="companyAddress" id="companyAddress" v-model="form.companyAddress" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="companyPay" class="leading-7 text-sm text-gray-600">給料</InputLabel>
                                        <TextInput type="number" name="companyPay" id="companyPay" v-model="form.companyPay" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="dutyStation" class="leading-7 text-sm text-gray-600">勤務地</InputLabel>
                                        <select name="dutyStation" id="dutyStation" v-model="form.dutyStation">
                                            <option v-for="dutyStation in dutyStations" :value="dutyStation.value" :key="dutyStation.value">
                                                {{ dutyStation.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="workDescription" class="leading-7 text-sm text-gray-600">仕事内容</InputLabel>
                                        <TextInput type="text" name="workDescription" id="workDescription" v-model="form.workDescription" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="payDescription" class="leading-7 text-sm text-gray-600">給与詳細</InputLabel>
                                        <TextInput type="text" name="payDescription" id="payDescription" v-model="form.payDescription" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="travelExpenses" class="leading-7 text-sm text-gray-600">交通費 / 月</InputLabel>
                                        <TextInput type="number" name="travelExpenses" id="travelExpenses" v-model="form.travelExpenses" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="Welfare" class="leading-7 text-sm text-gray-600">福利厚生</InputLabel>
                                        <TextInput type="text" name="Welfare" id="Welfare" v-model="form.Welfare" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="startWork" class="leading-7 text-sm text-gray-600">勤務開始時間</InputLabel>
                                        <TextInput type="time" name="startWork" id="startWork" required v-model="form.startWork" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="endWork" class="leading-7 text-sm text-gray-600">勤務終了時間</InputLabel>
                                        <TextInput type="time" name="endWork" id="endWork" v-model="form.endWork" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="workDays" class="leading-7 text-sm text-gray-600">出勤日</InputLabel>
                                        <TextInput type="text" name="workDays" id="workDays" v-model="form.workDays" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="freeDays" class="leading-7 text-sm text-gray-600">休日</InputLabel>
                                        <TextInput type="text" name="freeDays" id="freeDays" v-model="form.freeDays" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="NearestStation" class="leading-7 text-sm text-gray-600">最寄り駅</InputLabel>
                                        <TextInput type="text" name="NearestStation" id="NearestStation" v-model="form.NearestStation" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="search_keyword" class="leading-7 text-sm text-gray-600">その他</InputLabel>
                                        <textarea name="workOther" id="workOther" v-model="form.workOther" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="search_keywords" class="leading-7 text-sm text-gray-600">検索キーワード（カンマ区切り）</InputLabel>
                                        <textarea name="search_keywords" id="search_keywords" v-model="form.search_keywords" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>

                                <!-- 画像登録 -->
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image1" class="leading-7 text-sm text-gray-600">サムネ画像１</InputLabel>
                                        <input type="file" name="image1" id="image1" @input="form.image1 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image2" class="leading-7 text-sm text-gray-600">サムネ画像２</InputLabel>
                                        <input type="file" name="image2" id="image2" @input="form.image2 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image3" class="leading-7 text-sm text-gray-600">サムネ画像３</InputLabel>
                                        <input type="file" name="image3" id="image3" @input="form.image3 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image4" class="leading-7 text-sm text-gray-600">サムネ画像４</InputLabel>
                                        <input type="file" name="image4" id="image4" @input="form.image4 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image5" class="leading-7 text-sm text-gray-600">サムネ画像５</InputLabel>
                                        <input type="file" name="image5" id="image5" @input="form.image5 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
    </AuthenticatedLayout>
</template>