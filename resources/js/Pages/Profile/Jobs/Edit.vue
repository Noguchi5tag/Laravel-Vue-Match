<script setup>
import { reactive, computed, ref } from 'vue';
import { Link, Head, useForm  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import dayjs from 'dayjs';

const props = defineProps({
    jobBgs: Array,
})

const form = useForm({
    id: props.jobBgs?.length ? props.jobBgs[0].id : null,
    user_id: props.jobBgs?.length ? props.jobBgs[0].user_id : null,
    company_name: props.jobBgs?.length ? props.jobBgs[0].company_name : null,
    company_business: props.jobBgs?.length ? props.jobBgs[0].company_business : null,
    start_enrollment_year: props.jobBgs?.length ? props.jobBgs[0].start_enrollment_year : "",
    start_enrollment_month: props.jobBgs?.length ? props.jobBgs[0].start_enrollment_month : "",
    currently_working: props.jobBgs?.length ? Boolean(props.jobBgs[0].currently_working) : false,
    end_enrollment_year: props.jobBgs?.length ? props.jobBgs[0].end_enrollment_year : "",
    end_enrollment_month: props.jobBgs?.length ? props.jobBgs[0].end_enrollment_month : "",
    business_other: props.jobBgs?.length ? props.jobBgs[0].business_other : null,
    company_post: props.jobBgs?.length ? props.jobBgs[0].company_post : null,
    company_pay_type: props.jobBgs?.length ? props.jobBgs[0].company_pay_type : null,
    company_pay: props.jobBgs?.length ? props.jobBgs[0].company_pay : 0,
});
console.log(form.currently_working);

const updateFunction = () => {
    const today = dayjs().format('YYYY-MM-DD');
    if (form.end_enrollment && form.end_enrollment > today) {
        alert('卒業日は本日以前の日付を選択してください');
        return;
    }
    form.put(route('jobbg.update', form.id));
};

const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});

const months = [
    1,2,3,4,5,6,7,8,9,10,11,12
]

const job_posts = [
    "取締役",
    "部長",
    "社員",
    "パート",
    "アルバイト",
]

const pay_type = [
    "月給",
    "年収"
]
</script>

<template>
<Head title="職務履歴更新" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">職務履歴の更新</SiteTitle>

        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの学歴・職務経歴等を入力します。ここで入力した情報はいつでも修正・削除ができます。ここで入力した情報は求職者一覧にて企業側に情報が開示されます。
            </div>

            <form @submit.prevent="updateFunction" class="mt-6 flex flex-col gap-6">

                <InputLabel value="職務履歴を入力" />
                <div>
                    <InputLabel value="職務履歴１（直近）" />
                    <TextInput
                        id="company_name"
                        type="text"
                        name="company_name"
                        :class="inputClasses"
                        v-model="form.company_name"
                        placeholder="勤務先名"
                        required
                    />

                    <TextInput
                        id="company_business"
                        type="text"
                        name="company_business"
                        :class="inputClasses"
                        v-model="form.company_business"
                        placeholder="勤務先の事業内容"
                        required
                    />
                </div>
                <div>
                    <InputLabel value="勤務年数を入力" />
                    <InputLabel value="入社日" />
                    <div class="flex items-center gap-4 mb-4">
                        <TextInput
                            id="start_enrollment_year"
                            type="number"
                            name="start_enrollment_year"
                            :class="inputClasses"
                            class="w-2/3"
                            v-model="form.start_enrollment_year"
                            placeholder="年を入力"
                            required
                        />
                        <select
                            id="start_enrollment_month"
                            :class="inputClasses"
                            name="start_enrollment_month"
                            class="w-1/3"
                            v-model="form.start_enrollment_month"
                            required
                        >
                            <option value="" disabled selected>月を入力</option>
                            <option v-for="item in months" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div> 
                    <div class="my-2  flex justify-start items-center gap-2">
                        <input 
                            type="checkbox" 
                            name="currently_working" 
                            id="currently_working" 
                            v-model="form.currently_working" 
                            class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <p class="text-xs leading-normal tracking-wider">在籍中の方のみチェック</p>
                    </div> 
                    <InputLabel value="退社日" />
                    <div class="flex items-center gap-4">
                        <TextInput
                            id="end_enrollment_year"
                            type="number"
                            name="end_enrollment_year"
                            :class="inputClasses"
                            class="w-2/3"
                            v-model="form.end_enrollment_year"
                            placeholder="年を入力"
                        />
                        <select
                            id="end_enrollment_month"
                            :class="inputClasses"
                            name="end_enrollment_month"
                            class="w-1/3"
                            v-model="form.end_enrollment_month"
                            autocomplete="address-level1"
                        >
                            <option value="" disabled selected>月を入力</option>
                            <option v-for="item in months" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <TextArea
                            id="business_other"
                            type="text"
                            name="business_other"
                            :class="inputClasses"
                            v-model="form.business_other"
                            placeholder="仕事内容を入力（配置部署・役職経験の有無など詳細に記載）"
                            required
                        />
                    </div>
                </div>
                <div>
                    <InputLabel value="在籍時の役職を入力" />
                    <select
                        id="company_post"
                        name="company_post"
                        :class="inputClasses"
                        class="w-1/3"
                        v-model="form.company_post"
                        required
                    >
                        <option value="" disabled selected>役職を選択</option>
                        <option v-for="item in job_posts" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div>
                    <InputLabel value="在籍時の給与を入力（任意）" />
                    <div class="flex items-end gap-2">
                        <select
                            id="company_pay_type"
                            name="company_pay_type"
                            :class="inputClasses"
                            class="w-1/4"
                            v-model="form.company_pay_type"
                        >
                            <option value="" disabled selected>月を入力</option>
                            <option v-for="item in pay_type" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <TextInput
                            id="company_pay"
                            type="number"
                            name="company_pay"
                            :class="inputClasses"
                            class="w-1/3"
                            v-model="form.company_pay"
                            placeholder="300"
                        />
                        <p class="text-sm">万円</p>
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