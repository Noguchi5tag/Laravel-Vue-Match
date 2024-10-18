
<script setup>
import { Link, Head, useForm, router  } from '@inertiajs/vue3';
import { reactive, computed, onMounted, ref, watch } from 'vue';
import { requirements, prefectures, dutyStations, jobJoin, employment, particulars } from '@/data.js';
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    id: String,
    inertiaJob: Object,
})

const form = useForm({
    id: props.inertiaJob.id,
    companyName: props.inertiaJob.companyName,          // 会社名
    WantedTitles: props.inertiaJob.WantedTitles,        // 募集タイトル
    Occupation: props.inertiaJob.Occupation?.split(',') || [],            // 職種
    companyAddress: props.inertiaJob.companyAddress,    // 会社の住所
    prefecture: props.inertiaJob.prefecture,            // 勤務地 都道府県
    dutyStation: props.inertiaJob.dutyStation,          // 勤務地 市町村
    relocation: props.inertiaJob?.relocation === 1 ? true : false,            // 転勤の有無
    workDescription: props.inertiaJob.workDescription,  // 仕事内容
    employment_type: props.inertiaJob.employment_type?.split(',') || [],  // 雇用形態
    job_join: props.inertiaJob.job_join,                // 入社時期
    salary_type: props.inertiaJob.salary_type,          // 月収か年収か
    salary_amount: props.inertiaJob.salary_amount,      // 給与
    travelExpenses: props.inertiaJob.travelExpenses,    // 交通費
    particular_type: props.inertiaJob.particular_type?.split(',') || [],  // こだわり条件
    Welfare: props.inertiaJob.Welfare,                  // 福利厚生
    startWork: props.inertiaJob.startWork,              // 勤務開始時間
    endWork: props.inertiaJob.endWork,                  // 勤務終了時間
    workDays: props.inertiaJob.workDays,                // 出勤日
    freeDays: props.inertiaJob.freeDays,                // 休日
    NearestStation: props.inertiaJob.NearestStation,    // 最寄り駅
    workOther: props.inertiaJob.workOther,              // その他
    status: props.inertiaJob.status,                    // 公開か非公開か
    registrant: props.inertiaJob.registrant,            // 登録者
    is_checked: props.inertiaJob.is_checked,            // 確認フラグ
    search_keywords: props.inertiaJob.search_keywords,  // 検索キーワード

    image1: null,
    registerd_image1: props.inertiaJob.image1,
    image2: null,
    registerd_image2: props.inertiaJob.image2,
    image3: null,
    registerd_image3: props.inertiaJob.image3,
    image4: null,
    registerd_image4: props.inertiaJob.image4,
    image5: null,
    registerd_image5: props.inertiaJob.image5,

    imageDeleteFlag: {
        image1: false,
        image2: false,
        image3: false,
        image4: false,
        image5: false,
    },
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

const deleteImage = (imageKey) => {
    form[imageKey] = null;
    form.imageDeleteFlag[imageKey] = true;
}

const updateFunction = () => {
    router.post(route('admin.company.update', props.inertiaJob.id), {
        _method: 'put',
        companyName: form.companyName,
        WantedTitles: form.WantedTitles,
        Occupation:  Array.isArray(form.Occupation) ? form.Occupation.join(',') : form.Occupation || '',
        companyAddress: form.companyAddress,
        prefecture: form.prefecture,
        dutyStation: form.dutyStation,
        workDescription: form.workDescription,
        employment_type: Array.isArray(form.employment_type) ? form.employment_type.join(',') : form.employment_type || '',
        job_join: form.job_join,
        relocation: form.relocation,
        salary_type: form.salary_type,
        salary_amount: form.salary_amount,
        travelExpenses: form.travelExpenses,
        particular_type: Array.isArray(form.particular_type) ? form.particular_type.join(',') : form.particular_type || '',
        Welfare: form.Welfare,
        startWork: form.startWork,
        endWork: form.endWork,
        workDays: form.workDays,
        freeDays: form.freeDays,
        NearestStation: form.NearestStation,
        workOther: form.workOther,
        search_keywords: form.search_keywords,
        status: form.status,
        is_checked: form.is_checked,

        image1: form.image1,
        registerd_image1: form.registerd_image1,
        image2: form.image2,
        registerd_image2: form.registerd_image2,
        image3: form.image3,
        registerd_image3: form.registerd_image3,
        image4: form.image4,
        registerd_image4: form.registerd_image4,
        image5: form.image5,
        registerd_image5: form.registerd_image5,

        imageDeleteFlag: form.imageDeleteFlag,
    });
}

</script>

<template>
    <Head title="編集フォーム" />
    <AuthenticatedLayout>
        <div class="py-6 max-w-screen-md mx-auto">
            <form @submit.prevent="updateFunction(form.id)" enctype="multipart/form-data">
                <section class=" body-font relative">
                    <div class="container px-4 py-24 mx-auto">
                        <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">編集フォーム</h1>
                        </div>
                        <div class="mx-auto">
                            <div class="-m-2">
                                
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="募集タイトル" for="WantedTitles" />
                                        <TextInput 
                                            type="text" 
                                            name="WantedTitles" 
                                            id="WantedTitles" 
                                            v-model="form.WantedTitles" 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="職種（当てはまるものにチェック）" for="Occupation" />
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

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="雇用形態" for="employment_type" />
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
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
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
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="勤務地" for="dutyStation" />
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
                                        <input type="text" name="workDescription" id="workDescription" v-model="form.workDescription" class="w-full rounded border border-gray-300 text-base py-1 px-3 leading-8">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="入社時期" />
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
                                            class="w-full" 
                                        />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel value="求人の公開状況" />
                                        <label class="">
                                            <input type="radio" name="status" id="status" value="0" v-model="form.status" required>非公開
                                        </label>
                                        <label class="">
                                            <input type="radio" name="status" id="status" value="1" v-model="form.status" required>公開
                                        </label>
                                    </div>
                                </div>

                                <div class="p-2 w-full flex items-center gap-2 ">
                                    <InputLabel value="求人の確認" />
                                    <input 
                                        type="checkbox" 
                                        id="is_checked" 
                                        v-model="form.is_checked" 
                                        :true-value="1"
                                        :false-value="0"
                                    />
                                </div>

                                <!-- 画像の変更など -->
                                <div v-for="index in 5" :key="`image${index}`" class="p-2 w-full">
                                    <div class="relative">
                                        <label :for="`image${index}`" class="leading-7 text-sm ">サムネ画像{{ index }}</label>
                                        
                                        <template v-if="form[`registerd_image${index}`]">
                                            <div class="mb-2">
                                                <div class="flex justify-between items-center p-2">
                                                    <p>現在設定しているサムネイル画像{{ index }}</p>
                                                    <!-- index が 1 でない場合のみ削除ボタンを表示 -->
                                                    <DangerButton v-if="index !== 1" @click="deleteImage(`image${index}`)">削 除</DangerButton>
                                                </div>
                                                <img :src="`/storage/storages/jobs/` + form[`registerd_image${index}`]">
                                                <input type="hidden" v-model="form[`registerd_image${index}`]">
                                            </div>
                                        </template>
                                        
                                        <input 
                                            type="file" 
                                            :name="`image${index}`" 
                                            :id="`image${index}`" 
                                            @input="form[`image${index}`] = $event.target.files[0]" 
                                            class="w-full rounded border border-gray-300 text-base py-1 px-3 leading-8">
                                    </div>
                                </div>
                                
                                <div class="p-2 w-full">
                                    <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                </div>
                                <div class="p-2 w-full">
                                    <Link as="button" href="/admin/companylist" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 rounded text-lg">戻る</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </AuthenticatedLayout>
</template>