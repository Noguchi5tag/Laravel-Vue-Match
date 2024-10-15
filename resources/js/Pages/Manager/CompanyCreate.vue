<script setup>
import { reactive, computed, onMounted, ref, watch } from 'vue';
import { Link, Head, useForm, usePage  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { requirements, prefectures, dutyStations, jobJoin, employment, particulars } from '@/data.js';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
    manager: Object,
});

const form = reactive({
    companyName: props.manager.name || '',         // 会社名
    WantedTitles: '',                             // 募集タイトル
    Occupation: [],                               // 職種
    companyAddress: props.manager.manager_address || '', // 会社の住所
    prefecture: '',                               // 勤務地 都道府県
    dutyStation: '',                              // 勤務地 市町村
    relocation: 0,                            // 転勤の有無
    workDescription: '',                          // 仕事内容
    employment_type: [],                          // 雇用形態
    job_join: '',                                 // 入社時期
    salary_type: '',                              // 月収か年収か
    salary_amount: '',                            // 給与
    travelExpenses: '',                           // 交通費
    particular_type: [],                          // こだわり条件
    Welfare: '',                                  // 福利厚生
    startWork: '',                                // 勤務開始時間
    endWork: '',                                  // 勤務終了時間
    workDays: '',                                 // 出勤日
    freeDays: '',                                 // 休日
    NearestStation: '',                           // 最寄り駅
    workOther: '',                                // その他
    status: 0,                                    // ステータス（デフォルト0）
    registrant: props.managerName || '',           // 登録者名
    is_checked: false,                            // 確認フラグ
    search_keywords: '',                          // 検索キーワード
    image1: '',                                   // 画像1
    image2: '',                                   // 画像2
    image3: '',                                   // 画像3
    image4: '',                                   // 画像4
    image5: '',                                   // 画像5
});

// 各カテゴリの表示・非表示フラグとデータをまとめて定義
const jobCategories = ref([
    { label: '営業', visible: false, requirements: requirements.find(req => req.label === '営業').value },
    { label: '医療・福祉', visible: false, requirements: requirements.find(req => req.label === '医療・福祉').value },
    { label: 'ITエンジニア', visible: false, requirements: requirements.find(req => req.label === 'ITエンジニア').value },
    { label: 'クリエイティブ', visible: false, requirements: requirements.find(req => req.label === 'クリエイティブ').value },
    { label: '美容・ブライダル・ホテル・交通', visible: false, requirements: requirements.find(req => req.label === '美容・ブライダル・ホテル・交通').value }
]);
// カテゴリの表示・非表示を切り替える関数
const toggleCategoryVisible = (categoryLabel) => {
    const category = jobCategories.value.find(cat => cat.label === categoryLabel);
    if (category) {
        category.visible = !category.visible;
    }
};

const particularsCategories = ref([
    { label: '募集について', visible: false, particulars: particulars.find(req => req.label === '募集について').value },
    { label: '仕事について', visible: false, particulars: particulars.find(req => req.label === '仕事について').value },
    { label: '会社について', visible: false, particulars: particulars.find(req => req.label === '会社について').value },
    { label: '待遇、職場環境について', visible: false, particulars: particulars.find(req => req.label === '待遇、職場環境について').value },
]);
const toggleParticularsVisible = (particularsLabel) => {
    const particular = particularsCategories.value.find(cat => cat.label === particularsLabel);
    if (particular) {
        particular.visible = !particular.visible;
    }
};

//登録処理
const submitFunction = () => {
    const formData = new FormData();

    formData.append('relocation', form.relocation ? '1' : '0'); // `true/false` から `1/0` に変換

    for (const key in form) {
        if (key !== 'relocation') { // すでに追加されたフィールドを除外
            formData.append(key, form[key]);
        }
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
        <FlashMessage v-if="$page.props.flash.message">
            {{ $page.props.flash.message }}
        </FlashMessage>

        <div class="py-6 max-w-screen-md mx-auto">
            <form @submit.prevent="submitFunction" enctype="multipart/form-data">
                <section class=" body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="会社名" for="companyName" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="companyName" 
                                            id="companyName" 
                                            v-model="form.companyName" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="会社の住所" for="companyAddress" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="companyAddress" 
                                            id="companyAddress" 
                                            v-model="form.companyAddress" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="募集タイトル" for="WantedTitles" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="WantedTitles" 
                                            id="WantedTitles" 
                                            v-model="form.WantedTitles" 
                                            required  
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="職種（当てはまるものにチェック）" for="Occupation" class="leading-7 text-sm " />
                                        <div class="border-b-2 border-baseColor pb-4">
                                            <!-- 各職種カテゴリを繰り返し表示 -->
                                            <div v-for="(category, index) in jobCategories" :key="index" class="mb-4">
                                                <div @click="toggleCategoryVisible(category.label)" class="bg-white py-2 flex justify-between items-center px-4 cursor-pointer">
                                                    <div class="text-left text-sm">{{ category.label }}</div>
                                                    <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                                                </div>
                                                <!-- カテゴリが開いている時に職種を表示 -->
                                                <div v-if="category.visible" class="border-white border-2 py-2 px-4">
                                                    <div class="flex flex-wrap gap-2">
                                                        <div v-for="job in category.requirements" :key="job.value" class="flex items-center space-x-2">
                                                            <input type="checkbox" :id="job.value" v-model="form.Occupation" :value="job.label" class="bg-white border-none" />
                                                            <label :for="job.value" class="text-sm">{{ job.label }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <InputLabel value="雇用形態" />
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <div v-for="type in employment" :key="type.value" class="flex items-center space-x-2">
                                            <input
                                            type="checkbox"
                                            :id="type.value"
                                            v-model="form.employment_type"
                                            :value="type.label"
                                            class="bg-white border-gray-200"
                                            />
                                            <label :for="type.value" class="text-sm">{{ type.label }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <InputLabel value="年収または月収" />
                                    <div class="mt-2 flex items-end gap-2">
                                        <select v-model="form.salary_type" 
                                            class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-white border-gray-200"
                                        >
                                            <option disabled value="">月給・年収</option>
                                            <option value="月給">月給</option>
                                            <option value="年収">年収</option>
                                        </select>
                                        <TextInput 
                                            type="number" 
                                            name="salary_amount" 
                                            id="salary_amount" 
                                            v-model="form.salary_amount" 
                                            class="border-2 border-gray-200 text-sm"
                                            required 
                                        />
                                        <div class="text-sm font-bold">円</div>
                                    </div>
                                </div>

                                <div>
                                    <InputLabel value="勤務地" />
                                    <div>
                                        <select v-model="form.prefecture" class="w-full text-sm border-gray-200 border-2 px-4 py-2 rounded-md bg-white">
                                            <option disabled value="">都道府県</option>
                                            <option v-for="prefecture in prefectures" :key="prefecture" :value="prefecture">
                                                {{ prefecture }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <select v-model="form.dutyStation" class="w-full text-sm border-2 px-4 py-2 rounded-md bg-white border-gray-200">
                                            <option disabled value="">市町村</option>
                                            <option v-for="dutyStation in dutyStations" :key="dutyStation.value" :value="dutyStation.value">
                                                {{ dutyStation.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 mt-4">
                                    <input 
                                        type="checkbox" 
                                        name="relocation" 
                                        id="relocation" 
                                        v-model="form.relocation"
                                        class="rounded bg-white border-gray-200"
                                    >
                                    <p class="text-xs leading-normal tracking-wider">転勤有でも可</p>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="仕事内容" for="workDescription" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="workDescription" 
                                            id="workDescription" 
                                            v-model="form.workDescription" 
                                            required 
                                            class="w-full"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <InputLabel value="入社時期" />
                                    <div class="mt-2">
                                        <select v-model="form.job_join" class="w-2/5 text-sm border-2 px-4 py-2 rounded-md bg-white border-gray-200">
                                            <option disabled value="">こだわらない</option>
                                            <option v-for="join in jobJoin" :key="join.label" :value="join.label">
                                                {{ join.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="交通費 / 月" for="travelExpenses" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="number" 
                                            name="travelExpenses" 
                                            id="travelExpenses" 
                                            v-model="form.travelExpenses" 
                                            required 
                                        />円
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="勤務開始時間" for="startWork" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="time" 
                                            name="startWork" 
                                            id="startWork" 
                                            required 
                                            v-model="form.startWork" 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="勤務終了時間" for="endWork" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="time" 
                                            name="endWork" 
                                            id="endWork" 
                                            v-model="form.endWork" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="出勤日" for="workDays" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="workDays" 
                                            id="workDays" 
                                            v-model="form.workDays" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="休日" for="freeDays" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="freeDays" 
                                            id="freeDays" 
                                            v-model="form.freeDays" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="最寄り駅" for="NearestStation" class="leading-7 text-sm " />
                                        <TextInput 
                                            type="text" 
                                            name="NearestStation" 
                                            id="NearestStation" 
                                            v-model="form.NearestStation" 
                                            required 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="その他" for="search_keyword" class="leading-7 text-sm " />
                                        <textarea 
                                            name="workOther" 
                                            id="workOther" 
                                            v-model="form.workOther" 
                                            required 
                                            class="w-full" 
                                        />
                                    </div>
                                </div>

                                <div>
                                    <InputLabel value="こだわり条件" />
                                    <div class="py-4">
                                        <!-- 各職種カテゴリを繰り返し表示 -->
                                        <div v-for="(particular, index) in particularsCategories" :key="index" class="mb-4">
                                            <div @click="toggleParticularsVisible(particular.label)" class="w-full bg-white py-2 flex justify-between items-center px-4 cursor-pointer">
                                                <div class="text-left text-sm">{{ particular.label }}</div>
                                                <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                                            </div>
                                            <!-- カテゴリが開いている時に職種を表示 -->
                                            <div v-if="particular.visible" class="border-white border-2 py-2 px-4">
                                                <div class="flex flex-wrap gap-2">
                                                    <div v-for="job in particular.particulars" :key="job.value" class="flex items-center space-x-2">
                                                        <input type="checkbox" :id="job.value" v-model="form.particular_type" :value="job.label" class="bg-white border-none" />
                                                        <label :for="job.value" class="text-sm">{{ job.label }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="その他福利厚生" for="Welfare" class="leading-7 text-sm" />
                                        <TextInput 
                                            type="text" 
                                            name="Welfare" 
                                            id="Welfare" 
                                            v-model="form.Welfare"
                                            class="w-full" 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="検索キーワード（カンマ区切り）" for="search_keywords" class="leading-7 text-sm" />
                                        <textarea 
                                            name="search_keywords" 
                                            id="search_keywords" 
                                            v-model="form.search_keywords" 
                                            required 
                                            class="w-full" 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image1" class="leading-7 text-sm ">サムネ画像１</InputLabel>
                                        <input type="file" name="image1" id="image1" @input="form.image1 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image2" class="leading-7 text-sm ">サムネ画像２</InputLabel>
                                        <input type="file" name="image2" id="image2" @input="form.image2 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image3" class="leading-7 text-sm ">サムネ画像３</InputLabel>
                                        <input type="file" name="image3" id="image3" @input="form.image3 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image4" class="leading-7 text-sm ">サムネ画像４</InputLabel>
                                        <input type="file" name="image4" id="image4" @input="form.image4 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="image5" class="leading-7 text-sm ">サムネ画像５</InputLabel>
                                        <input type="file" name="image5" id="image5" @input="form.image5 = $event.target.files[0]" class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <button 
                                        type="submit" 
                                        class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                        登録する
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </AuthenticatedLayout>
</template>