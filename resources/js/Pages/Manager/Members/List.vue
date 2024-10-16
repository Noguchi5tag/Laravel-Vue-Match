<script setup>
import { computed } from 'vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    users: Array,
});

// 勤続年数を計算するための関数
const calculatedYears = computed(() => {
    const startYear = props.user.job_bg?.start_enrollment_year;
    const startMonth = props.user.job_bg?.start_enrollment_month;
    const endYear = props.user.job_bg?.end_enrollment_year;
    const endMonth = props.user.job_bg?.end_enrollment_month;

    if (startYear && startMonth && endYear && endMonth) {
        // 開始日と終了日の Date オブジェクトを作成
        const startDate = new Date(startYear, startMonth - 1); // 月は0から始まるので、-1 する
        const endDate = new Date(endYear, endMonth - 1);

        // 年月の差を計算
        const diffInMonths = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() - startDate.getMonth());
        const years = Math.floor(diffInMonths / 12);
        const months = diffInMonths % 12;

        return { years, months };
    }
    return null;
});

// 計算結果をテンプレートに表示
const calculatedYearsValue = computed(() => calculatedYears.value ? calculatedYears.value.years : null);
const calculatedMonths = computed(() => calculatedYears.value ? calculatedYears.value.months : null);
</script>

<template>
    <Head title="会員リスト" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">会員リスト</h2>
        </template>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto m-4 border-collapse border border-gray-600 bg-white">
                <thead>
                    <tr>
                        <th class="border px-4 py-2"></th>
                        <th class="border px-4 py-2">氏名</th>
                        <th class="border px-4 py-2">メールアドレス</th>
                        <th class="border px-4 py-2">電話番号</th>
                        <th class="border px-4 py-2">性別</th>
                        <th class="border px-4 py-2">居住地</th>
                        <th class="border px-4 py-2">最終学歴</th>
                        <th class="border px-4 py-2">職歴</th>
                        <th class="border px-4 py-2">こだわり条件</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in props.users" :key="user.id" class="whitespace-nowrap">
                        <td class="border px-4 py-2">
                            <div class="w-16 h-16">
                                <img class="w-full h-full object-cover rounded-full" src="/storage/storages/manager/manager4.jpg" alt="">
                            </div>
                        </td>
                        <!-- 氏名 -->
                        <td class="border px-4 py-2">{{ user.name ? user.name : 'データなし' }}</td>
                        <!-- メールアドレス -->
                        <td class="border px-4 py-2">{{ user.email ? user.email : 'データなし' }}</td>
                        <!-- 電話番号 -->
                        <td class="border px-4 py-2">{{ user.tel ? user.tel : 'データなし' }}</td>
                        <!-- 性別 -->
                        <td class="border px-4 py-2">
                        {{ user.sex === 0 ? '男性' : user.sex === 1 ? '女性' : user.sex === 2 ? '答えたくない' : 'データなし' }}
                        </td>
                        <!-- 居住地 -->
                        <td class="border px-4 py-2">{{ user.prefectures ? user.prefectures : 'データなし' }}</td>
            
                        <!-- 最終学歴 -->
                        <td class="border px-4 py-2">
                            <div class="flex flex-col gap-1">
                                <div>学校区分: {{ user.academic_bg?.school_classification ? user.academic_bg.school_classification : 'データなし' }}</div>
                                <div>学校名: {{ user.academic_bg?.school_name ? user.academic_bg.school_name : 'データなし' }}</div>
                                <div>学部学科: {{ user.academic_bg?.department ? user.academic_bg.department : 'データなし' }}</div>
                            </div>
                        </td>
            
                        <!-- 職歴 -->
                        <td class="border px-4 py-2">
                            <div class="flex flex-col gap-1">
                                <div>事業内容: {{ user.job_bg?.company_business ? user.job_bg.company_business : 'データなし' }}</div>
                                <div>入社時期: {{ user.job_bg?.start_enrollment_year ? user.job_bg.start_enrollment_year : 'データなし' }}年{{ user.job_bg?.start_enrollment_month ? user.job_bg.start_enrollment_month : 'データなし' }}月</div>
                                <div v-if="user.job_bg?.currently_working === 1">現職中</div>
                                <div>退社時期: {{ user.job_bg?.end_enrollment_year ? user.job_bg.end_enrollment_year : 'データなし' }}年{{ user.job_bg?.end_enrollment_month ? user.job_bg.end_enrollment_month : 'データなし' }}月</div>
                                <div>具体的な仕事内容: {{ user.job_bg?.business_other ? user.job_bg.business_other : 'データなし' }}</div>
                                <div>在職時の役職: {{ user.job_bg?.company_post ? user.job_bg.company_post : 'データなし' }}</div>
                                <div>在職時の給料: {{ user.job_bg?.company_pay_type ? user.job_bg.company_pay_type : 'データなし' }} {{ user.job_bg?.company_pay ? user.job_bg.company_pay : 'データなし' }}万円</div>
                            </div>
                        </td>
            
                        <!-- こだわり条件 -->
                        <td class="border px-4 py-2">
                            <div v-if="user.job_requirements && user.job_requirements.length > 0">
                                <div v-for="requirement in user.job_requirements" :key="requirement.id" class="flex flex-col gap-1">
                                <div>希望職種: {{ requirement.job_category ? requirement.job_category : 'データなし' }}</div>
                                <div>希望勤務地: {{ requirement.prefecture ? requirement.prefecture : 'データなし' }} {{ requirement.dutyStation ? requirement.dutyStation : 'データなし' }}</div>
                                <div>転勤の有無: {{ requirement.relocation === 0 ? '無' : requirement.relocation === 1 ? '有' : 'データなし' }}</div>
                                <div>希望入社時期: {{ requirement.job_join ? requirement.job_join : 'データなし' }}</div>
                                <div>希望雇用形態: {{ requirement.employment_type ? requirement.employment_type : 'データなし' }}</div>
                                <div>希望給与: {{ requirement.salary_type ? requirement.salary_type : 'データなし' }} {{ requirement.salary_amount ? requirement.salary_amount + '万円' : 'データなし' }}</div>
                                <div>こだわり条件: {{ requirement.particular_type ? requirement.particular_type : 'データなし' }}</div>
                                </div>
                            </div>
                            <div v-else>データがありません</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
