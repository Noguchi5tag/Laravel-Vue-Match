<script setup>
import { reactive } from 'vue';
import { Link, Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { dutyStations } from '@/data';
import { Occupations } from '@/data';

const form = reactive({
    companyName: '',
    WantedTitles: '',
    Occupation: '',
    companyAddress: '',
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
    status: '',
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
    Inertia.post('/admin/company/job', formData);
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
        <div class="py-6">
            <form @submit.prevent="submitFunction" enctype="multipart/form-data">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyName" class="leading-7 text-sm text-gray-600">会社名</label>
                                        <input type="text" name="companyName" id="companyName" v-model="form.companyName" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="WantedTitles" class="leading-7 text-sm text-gray-600">募集タイトル</label>
                                        <input type="text" name="WantedTitles" id="WantedTitles" v-model="form.WantedTitles" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="Occupation" class="leading-7 text-sm text-gray-600">職種</label>
                                        <select name="Occupation" id="Occupation" v-model="form.Occupation">
                                            <option v-for="occupation in Occupations" :value="occupation.value" :key="occupation.value">
                                                {{ occupation.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyAddress" class="leading-7 text-sm text-gray-600">会社の住所</label>
                                        <input type="text" name="companyAddress" id="companyAddress" v-model="form.companyAddress" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyPay" class="leading-7 text-sm text-gray-600">給料</label>
                                        <input type="number" name="companyPay" id="companyPay" v-model="form.companyPay" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="dutyStation" class="leading-7 text-sm text-gray-600">勤務地</label>
                                        <select name="dutyStation" id="dutyStation" v-model="form.dutyStation">
                                            <option v-for="dutyStation in dutyStations" :value="dutyStation.value" :key="dutyStation.value">
                                                {{ dutyStation.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="workDescription" class="leading-7 text-sm text-gray-600">仕事内容</label>
                                        <input type="text" name="workDescription" id="workDescription" v-model="form.workDescription" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="payDescription" class="leading-7 text-sm text-gray-600">給与詳細</label>
                                        <input type="text" name="payDescription" id="payDescription" v-model="form.payDescription" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="travelExpenses" class="leading-7 text-sm text-gray-600">交通費 / 月</label>
                                        <input type="number" name="travelExpenses" id="travelExpenses" v-model="form.travelExpenses" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="Welfare" class="leading-7 text-sm text-gray-600">福利厚生</label>
                                        <input type="text" name="Welfare" id="Welfare" v-model="form.Welfare" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="startWork" class="leading-7 text-sm text-gray-600">勤務開始時間</label>
                                        <input type="time" name="startWork" id="startWork" required v-model="form.startWork" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="endWork" class="leading-7 text-sm text-gray-600">勤務終了時間</label>
                                        <input type="time" name="endWork" id="endWork" v-model="form.endWork" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="workDays" class="leading-7 text-sm text-gray-600">出勤日</label>
                                        <input type="text" name="workDays" id="workDays" v-model="form.workDays" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="freeDays" class="leading-7 text-sm text-gray-600">休日</label>
                                        <input type="text" name="freeDays" id="freeDays" v-model="form.freeDays" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="NearestStation" class="leading-7 text-sm text-gray-600">最寄り駅</label>
                                        <input type="text" name="NearestStation" id="NearestStation" v-model="form.NearestStation" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="message" class="leading-7 text-sm text-gray-600">その他</label>
                                        <textarea name="workOther" id="workOther" v-model="form.workOther" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="status" class="leading-7 text-sm text-gray-600">ステータス</label>
                                        <div class="">
                                            <label class="">
                                                <input type="radio" name="status" id="status" value="0" v-model="form.status" required>非公開
                                            </label>
                                            <label class="">
                                                <input type="radio" name="status" id="status" value="1" v-model="form.status" required>公開
                                            </label>
                                        </div>
                                    </div>
                                </div>



                                <!-- 画像登録 -->
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="image1" class="leading-7 text-sm text-gray-600">サムネ画像１</label>
                                        <input type="file" name="image1" id="image1" @input="form.image1 = $event.target.files[0]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="image2" class="leading-7 text-sm text-gray-600">サムネ画像２</label>
                                        <input type="file" name="image2" id="image2" @input="form.image2 = $event.target.files[0]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="image3" class="leading-7 text-sm text-gray-600">サムネ画像３</label>
                                        <input type="file" name="image3" id="image3" @input="form.image3 = $event.target.files[0]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="image4" class="leading-7 text-sm text-gray-600">サムネ画像４</label>
                                        <input type="file" name="image4" id="image4" @input="form.image4 = $event.target.files[0]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="image5" class="leading-7 text-sm text-gray-600">サムネ画像５</label>
                                        <input type="file" name="image5" id="image5" @input="form.image5 = $event.target.files[0]" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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