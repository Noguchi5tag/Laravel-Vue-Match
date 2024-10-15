<script setup>
import { Head, usePage, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    users: Array,
});
console.log(props.users);
</script>

<template>
    <Head title="マネージャー情報" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">会員リスト</h2>
        </template>

        <div class="m-4">
            <div 
            v-for="user in props.users" 
            :key="user.id"
            class="bg-white p-4 flex flex-col gap-4"    
            >
                <div>
                    <InputLabel value="基本情報" />

                    <div class="flex gap-4">
                    <InputLabel value="ID" />
                    <InputLabel>{{ user.id ? user.id : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="氏名" />
                    <InputLabel>{{ user.name ? user.name : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="メールアドレス" />
                    <InputLabel>{{ user.email ? user.email : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="電話番号" />
                    <InputLabel>{{ user.tel ? user.tel : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="性別" />
                    <InputLabel>
                        {{ user.sex === 0 ? '男性' : user.sex === 1 ? '女性' : user.sex === 2 ? '答えたくない' : 'データなし' }}
                    </InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="居住地" />
                    <InputLabel>{{ user.prefectures ? user.prefectures : 'データなし' }}</InputLabel>
                    </div>
                </div>
                
                <div>
                    <InputLabel value="最終学歴" />

                    <div class="flex gap-4">
                    <InputLabel value="学校区分" />
                    <InputLabel>{{ user.academic_bg?.school_classification ? user.academic_bg.school_classification : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="学校名" />
                    <InputLabel>{{ user.academic_bg?.school_name ? user.academic_bg.school_name : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="学部学科" />
                    <InputLabel>{{ user.academic_bg?.department ? user.academic_bg.department : 'データなし' }}</InputLabel>
                    </div>
                </div>

                <div>
                    <InputLabel value="職歴" />

                    <div class="flex gap-4">
                    <InputLabel value="会社名" />
                    <InputLabel>{{ user.job_bg?.company_name ? user.job_bg.company_name : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="事業内容" />
                    <InputLabel>{{ user.job_bg?.company_business ? user.job_bg.company_business : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="入社時期" />
                    <InputLabel>{{ user.job_bg?.start_enrollment_year ? user.job_bg.start_enrollment_year : 'データなし' }}年{{ user.job_bg?.start_enrollment_month ? user.job_bg.start_enrollment_month : 'データなし' }}月</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel v-if="user.job_bg?.currently_working === 1">
                        現職中
                    </InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="退社時期" />
                    <InputLabel>{{ user.job_bg?.end_enrollment_year ? user.job_bg.end_enrollment_year : 'データなし' }}年{{ user.job_bg?.end_enrollment_month ? user.job_bg.end_enrollment_month : 'データなし' }}月</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="具体的な仕事内容" />
                    <InputLabel>{{ user.job_bg?.business_other ? user.job_bg.business_other : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="在職時の役職" />
                    <InputLabel>{{ user.job_bg?.company_post ? user.job_bg.company_post : 'データなし' }}</InputLabel>
                    </div>

                    <div class="flex gap-4">
                    <InputLabel value="在職時の給料" />
                    <InputLabel>{{ user.job_bg?.company_pay_type ? user.job_bg.company_pay_type : 'データなし' }} {{ user.job_bg?.company_pay ? user.job_bg.company_pay : 'データなし' }}万円</InputLabel>
                    </div>
                </div>

                <div>
                    <InputLabel value="こだわり条件" />
                    <div v-if="user.job_requirements && user.job_requirements.length > 0">
                    <div v-for="requirement in user.job_requirements" :key="requirement.id">
                        <div class="flex gap-4">
                        <InputLabel value="希望勤務地" />
                        <InputLabel>{{ requirement.prefecture ? requirement.prefecture : 'データなし' }} {{ requirement.dutyStation ? requirement.dutyStation : 'データなし' }}</InputLabel>
                        </div>
                    </div>
                    </div>
                    <div v-else>
                    なし
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>