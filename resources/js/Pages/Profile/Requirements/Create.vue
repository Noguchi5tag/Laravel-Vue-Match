<script setup>
import { reactive, computed, onMounted, ref, watch } from 'vue';
import { Link, Head, useForm, usePage  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { requirements, prefectures, dutyStations, jobJoin, employment, particulars } from '@/data.js';

const user = usePage().props.auth.user;
// console.log(user);

// フォームデータの定義
const form = reactive({
    job_category: [], // 希望職種
    prefecture: '', // 都道府県の選択
    dutyStation: '', // 市町村の選択
    relocation: false,  // 転勤の有無
    job_join: '', // 入社の希望時期
    employment_type: [], // 雇用形態の選択
    particular_type: [],  // 職種の詳細情報
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
    console.log(form);
    
    Inertia.post(route('requirements.store'), {
        user_id: user.id,
        job_category: form.job_category.length > 0 ? form.job_category.join(',') : '',
        prefecture: form.prefecture || '',
        dutyStation: form.dutyStation || '',
        relocation: form.relocation ? 1 : 0,
        job_join: form.job_join || '',
        employment_type: form.employment_type.length > 0 ? form.employment_type.join(',') : '',
        salary_type: salaryType.value || '',
        salary_amount: selectedAmount.value ? parseInt(selectedAmount.value, 10) : 0,
        particular_type: form.particular_type.length > 0 ? form.particular_type.join(',') : '',
    });
};

// 選択された給与タイプ（1つ目のセレクトボックス）
const salaryType = ref('');
// 選択された金額（2つ目のセレクトボックス）
const selectedAmount = ref('');
// 2つ目のセレクトボックスの選択肢を動的に管理する
const salaryOptions = computed(() => {
    if (salaryType.value === '月給') {
        // 月給を選択した場合の金額（20〜50の範囲で10単位）
        return Array.from({ length: 4 }, (_, i) => (20 + i * 10));
    } else if (salaryType.value === '年収') {
        // 年収を選択した場合の金額（250〜1000の範囲で100単位）
        return Array.from({ length: 8 }, (_, i) => (300 + i * 100));
    } else {
        return [];
    }
});
// 給与タイプが変更された際に金額の選択をリセットする
watch(salaryType, () => {
    selectedAmount.value = '';
});

const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});
</script>

<template>
    <Head title="利用登録・応募条件" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">応募条件</SiteTitle>
        <div class="flex justify-around items-center bg-baseColor">
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">
                1.個人情報
            </div>
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">
                2.学歴・職務履歴
            </div>
            <div class="w-full py-2 text-center text-sm font-bold border-black border-b-2">3.応募条件</div>
        </div>
        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの応募に関して希望条件を入力します。ここで入力した情報はいつでも修正・削除ができます。ここで入力した情報は求職者一覧に情報が開示されます。
            </div>

            <form @submit.prevent="submitFunction" class="mt-6 flex flex-col gap-6">
                <InputLabel value="希望職種を入力" />
                <div class="border-b-2 border-baseColor pb-4">
                    <!-- 各職種カテゴリを繰り返し表示 -->
                    <div v-for="(category, index) in jobCategories" :key="index" class="mb-4">
                        <div @click="toggleCategoryVisible(category.label)" class="w-full bg-baseColor py-2 flex justify-between items-center px-4 cursor-pointer">
                            <div class="text-left text-sm">{{ category.label }}</div>
                            <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                        </div>
                        <!-- カテゴリが開いている時に職種を表示 -->
                        <div v-if="category.visible" class="border-baseColor border-2 py-2 px-4">
                            <div class="flex flex-wrap gap-2">
                                <div v-for="job in category.requirements" :key="job.value" class="flex items-center space-x-2">
                                    <input type="checkbox" :id="job.value" v-model="form.job_category" :value="job.label" class="bg-baseColor border-none" />
                                    <label :for="job.value" class="text-sm">{{ job.label }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <InputLabel value="希望勤務地" />
                    <div>
                        <p class="text-sm">都道府県</p>
                        <select v-model="form.prefecture" class="w-full text-sm border-gray-200 border-2 px-4 py-2 rounded-md bg-baseColor">
                            <option disabled value="">都道府県</option>
                            <option v-for="prefecture in prefectures" :key="prefecture" :value="prefecture">
                                {{ prefecture }}
                            </option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <p class="text-sm">市町村</p>
                        <select v-model="form.dutyStation" class="w-full text-sm border-2 px-4 py-2 rounded-md bg-baseColor border-gray-200">
                            <option disabled value="">市町村</option>
                            <option v-for="dutyStation in dutyStations" :key="dutyStation.value" :value="dutyStation.value">
                                {{ dutyStation.label }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        name="relocation" 
                        id="relocation" 
                        v-model="form.relocation"
                        class="rounded bg-baseColor border-gray-200"
                    >
                    <p class="text-xs leading-normal tracking-wider">転勤有でも可</p>
                </div>

                <div>
                    <InputLabel value="希望入社時期" />
                    <div class="mt-2">
                        <select v-model="form.job_join" class="w-2/5 text-sm border-2 px-4 py-2 rounded-md bg-baseColor border-gray-200">
                            <option disabled value="">こだわらない</option>
                            <option v-for="join in jobJoin" :key="join.label" :value="join.label">
                                {{ join.label }}
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <InputLabel value="希望雇用形態" />
                    <div class="mt-2 flex flex-wrap gap-2">
                        <div v-for="type in employment" :key="type.value" class="flex items-center space-x-2">
                            <input
                            type="checkbox"
                            :id="type.value"
                            v-model="form.employment_type"
                            :value="type.label"
                            class="bg-baseColor border-gray-200"
                            />
                            <label :for="type.value" class="text-sm">{{ type.label }}</label>
                        </div>
                    </div>
                </div>

                <div>
                    <InputLabel value="希望年収または月収" />
                    <div class="mt-2 flex items-end gap-2">
                        <select v-model="salaryType" class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-baseColor border-gray-200">
                            <option disabled value="">月給・年収</option>
                            <option value="月給">月給</option>
                            <option value="年収">年収</option>
                        </select>
                        <select v-model="selectedAmount" class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-baseColor border-gray-200" :disabled="salaryOptions.length === 0">
                            <option disabled value="">金額</option>
                            <option v-for="option in salaryOptions" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </select>
                        <div class="text-sm font-bold">万円 以上</div>
                    </div>
                </div>

                <div>
                    <InputLabel value="こだわり条件" />
                    <div class="py-4">
                        <!-- 各職種カテゴリを繰り返し表示 -->
                        <div v-for="(particular, index) in particularsCategories" :key="index" class="mb-4">
                            <div @click="toggleParticularsVisible(particular.label)" class="w-full bg-baseColor py-2 flex justify-between items-center px-4 cursor-pointer">
                                <div class="text-left text-sm">{{ particular.label }}</div>
                                <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                            </div>
                            <!-- カテゴリが開いている時に職種を表示 -->
                            <div v-if="particular.visible" class="border-baseColor border-2 py-2 px-4">
                                <div class="flex flex-wrap gap-2">
                                    <div v-for="job in particular.particulars" :key="job.value" class="flex items-center space-x-2">
                                        <input type="checkbox" :id="job.value" v-model="form.particular_type" :value="job.label" class="bg-baseColor border-none" />
                                        <label :for="job.value" class="text-sm">{{ job.label }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col items-center">
                    <PrimaryButton type="submit">保存して内容確認へ</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                    </Transition>
                </div>

                <Link :href="route('profile.edit')" class="inline-block mx-auto px-6 py-3 border-2 border-gray-400 rounded-full text-xs">スキップして確認画面へ</Link>
            </form>
        </SectionInner>
    </BaseLayouts>
</template>