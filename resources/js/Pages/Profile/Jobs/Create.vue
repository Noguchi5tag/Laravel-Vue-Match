<script setup>
import { reactive, computed, ref } from 'vue';
import { Link, Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    user: Object,
})

const form = reactive({
    company_name: '',
    company_business: '',
    start_enrollment_year: '',
    start_enrollment_month: 0,
    currently_working: false,
    end_enrollment_year: '',
    end_enrollment_month: 0,
    business_other: '',
    company_post: '',
    company_pay_type: '',
    company_pay: 0,
});

//登録処理

const submitFunction = () => {
    console.log(form);
    Inertia.post(route('jobbg.store'),{
        user_id: props.user.id,
        company_name: form.company_name,
        company_business: form.company_business,
        start_enrollment_year: form.start_enrollment_year,
        start_enrollment_month: form.start_enrollment_month,
        currently_working: form.currently_working,
        end_enrollment_year: form.end_enrollment_year,
        end_enrollment_month: form.end_enrollment_month,
        business_other: form.business_other,
        company_post: form.company_post,
        company_pay_type: form.company_pay_type,
        company_pay: form.company_pay,
    }, {
        onError: (errors) => {
            console.error("エラーが発生しました:", errors);
        },
        onSuccess: () => {
            console.log("データが正常に送信されました！");
        }
    });
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

// const showDetails = ref(false);
// const toggleDetails = () => {
//     showDetails.value = !showDetails.value;
// };
</script>

<template>
<Head title="利用登録・職務履歴" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">職務履歴</SiteTitle>
        <div class="flex justify-around items-center bg-baseColor">
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">
                1.個人情報
            </div>
            <div class="w-full py-2 text-center text-sm font-bold border-black border-b-2">
                2.学歴・職務履歴
            </div>
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">
                <Link as:button :href="route('requirements.create')">3.応募条件</Link>
            </div>
        </div>
        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの学歴・職務経歴等を入力します。ここで入力した情報はいつでも修正・削除ができます。ここで入力した情報は求職者一覧にて企業側に情報が開示されます。
            </div>

            <form @submit.prevent="submitFunction" class="mt-6 flex flex-col gap-6">

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

                <!-- 後から追加処理をする -->
                <!-- <button class="flex justify-center gap-4 py-6 text-sm font-bold bg-sky-100 rounded-lg">
                    職務履歴を追加（任意）
                </button> -->

                <div class="flex flex-col items-center gap-4 border-t-2 border-baseColor py-4">
                    <PrimaryButton>保存して応募条件を入力する</PrimaryButton>
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