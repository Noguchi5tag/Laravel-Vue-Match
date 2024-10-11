<script setup>
import { reactive, computed, onMounted, ref, watch } from 'vue';
import { Link, Head, useForm  } from '@inertiajs/vue3';
import { requirements, prefectures, dutyStations, jobJoin, employment, particulars } from '@/data.js';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    job_requirements: Array,
});

const form = useForm({
    id: props.job_requirements[0]?.id || '',
    user_id: props.job_requirements[0]?.user_id || '',
    job_category: props.job_requirements[0]?.job_category?.split(',') || [],
    prefecture: props.job_requirements[0]?.prefecture || '',
    dutyStation: props.job_requirements[0]?.dutyStation || '',
    relocation: props.job_requirements[0]?.relocation === 1 ? true : false,
    job_join: props.job_requirements[0]?.job_join || '',
    employment_type: props.job_requirements[0]?.employment_type?.split(',') || [],
    salary_type: props.job_requirements[0]?.salary_type || '',
    salary_amount: props.job_requirements[0]?.salary_amount || '',
    particular_type: props.job_requirements[0]?.particular_type?.split(',') || [],
});

const jobCategories = ref([
    { label: '営業', visible: false, requirements: requirements.find(req => req.label === '営業').value },
    { label: '医療・福祉', visible: false, requirements: requirements.find(req => req.label === '医療・福祉').value },
    { label: 'ITエンジニア', visible: false, requirements: requirements.find(req => req.label === 'ITエンジニア').value },
    { label: 'クリエイティブ', visible: false, requirements: requirements.find(req => req.label === 'クリエイティブ').value },
    { label: '美容・ブライダル・ホテル・交通', visible: false, requirements: requirements.find(req => req.label === '美容・ブライダル・ホテル・交通').value }
]);
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

const salaryOptions = computed(() => {
    if (form.salary_type === '月給') {
        return Array.from({ length: 4 }, (_, i) => (20 + i * 10));
    } else if (form.salary_type === '年収') {
        return Array.from({ length: 8 }, (_, i) => (300 + i * 100));
    } else {
        return [];
    }
});
watch(() => form.salary_type, () => {
    form.salary_amount = '';
});

const updateFunction = () => {
    form.relocation = form.relocation ? 1 : 0;
    form.put(route('requirements.update', form.id));
};

</script>

<template>
    <Head title="こだわり条件変更" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">こだわり条件更新</SiteTitle>

        <SectionInner class="my-6 px-4">
            <form @submit.prevent="updateFunction" class="mt-6 flex flex-col gap-6">
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
                        <select v-model="form.salary_type" class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-baseColor border-gray-200">
                            <option disabled value="">月給・年収</option>
                            <option value="月給">月給</option>
                            <option value="年収">年収</option>
                        </select>
                        <select v-model="form.salary_amount" class="w-1/3 text-sm border-2 px-2 py-2 rounded-md bg-baseColor border-gray-200" :disabled="salaryOptions.length === 0">
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
                        <div v-for="(particular, index) in particularsCategories" :key="index" class="mb-4">
                            <div @click="toggleParticularsVisible(particular.label)" class="w-full bg-baseColor py-2 flex justify-between items-center px-4 cursor-pointer">
                                <div class="text-left text-sm">{{ particular.label }}</div>
                                <font-awesome-icon :icon="['fas', 'chevron-down']" class="w-3 h-3" />
                            </div>
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
        
                <div class="flex flex-col items-center gap-4 border-t-2 border-baseColor py-4">
                    <PrimaryButton>更新する</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                    </Transition>
                </div>
            </form>
        </SectionInner>
        
    </BaseLayouts>
</template>