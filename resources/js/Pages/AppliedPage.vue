<script setup>
import { reactive } from 'vue';
import { Head, useForm  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';


const props = defineProps({
    applicants: Array,
})
console.log(props.applicants);

//生年月日のフォーマット
function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}年${month}月${day}日`;
}

//年齢の計算
function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();

    // 誕生日の月がまだ来ていない、または同じ月でも誕生日がまだ来ていない場合は年齢を1歳引く
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    return age;
}

</script>


<template>
    <Head title="応募リスト" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">応募リスト</h2>
        </template>

        <div class="py-6 max-w-screen-md mx-auto">

            <div v-if="applicants.length > 0">
                <ul v-for="(applicant, index) in applicants" :key="index">
                    <h2>応募者の情報</h2>
                    <p>氏名: {{ applicant.user.name }}</p>
                    <p>メールアドレス: {{ applicant.user.email }}</p>
                    <p>電話番号: {{ applicant.user.tel }}</p>

                    <p>性別: 
                        <template v-if="applicant.user.sex === 1">男</template>
                        <template v-else-if="applicant.user.sex === 2">女</template>
                        <template v-else>その他</template>
                    </p>

                    <p>生年月日: {{ formatDate(applicant.user.birth) }}</p>
                    <p>年齢: 満{{ calculateAge(applicant.user.birth) }}歳</p>

                    <h2 class="mt-10">学歴</h2>
                    <p>学校名: {{ applicant.user.academic_bg.school_name }}</p>
                    <p>学部・学科: {{ applicant.user.academic_bg.department }}</p>
                    <p>在学中かどうか: 
                        <template v-if="applicant.user.academic_bg.undergraduate === 0">卒業</template>
                        <template v-else>在学中</template>
                    </p>

                    <h2 class="mt-10">職務履歴</h2>
                    <!-- job_bgが配列の場合 -->
                    <template v-if="Array.isArray(applicant.user.job_bg)">
                        <ul>
                            <li v-for="(job_bg, job_bgIndex) in applicant.user.job_bg" :key="job_bgIndex">
                                <p>職種: {{ job_bg.job_title }}</p>
                                <p>会社名: {{ job_bg.company_name }}</p>
                                <p>入社日: {{ formatDate(job_bg.start_enrollment) }}</p>
                                <p>退社日: 
                                    <template v-if="job_bg.currently_working === 0">
                                        {{ formatDate(job_bg.end_enrollment) }}
                                    </template>
                                    <template v-else>
                                        現在勤務中
                                    </template>
                                </p>
                            </li>
                        </ul>
                    </template>

                    <!-- job_bgがオブジェクトの場合 -->
                    <template v-else>
                        <p>職種: {{ applicant.user.job_bg.job_title }}</p>
                        <p>会社名: {{ applicant.user.job_bg.company_name }}</p>
                        <p>入社日: {{ formatDate(applicant.user.job_bg.start_enrollment) }}</p>
                        <p>退社日: 
                            <template v-if="applicant.user.job_bg.currently_working === 0">
                                {{ formatDate(applicant.user.job_bg.end_enrollment) }}
                            </template>
                            <template v-else>
                                現在勤務中
                            </template>
                        </p>
                    </template>

                    <h2 class="mt-10">資格について</h2>
                    <!-- skillsが配列の場合 -->
                    <template v-if="Array.isArray(applicant.user.skills)">
                        <ul>
                            <li v-for="(skill, skillIndex) in applicant.user.skills" :key="skillIndex">
                                <p>資格名: {{ skill.skill_name }}</p>
                                <p>取得日: {{ formatDate(skill.skill_experience) }}</p>
                            </li>
                        </ul>
                    </template>

                    <h2 class="mt-10">資格について</h2>
                    <!-- 配列の場合 -->
                    <template v-if="Array.isArray(applicant.user.skills)">
                        <ul>
                            <li v-for="(skill, skillIndex) in applicant.user.skills" :key="skillIndex">
                                <p>資格名: {{ skill.skill_name }}</p>
                                <p>取得日: {{ formatDate(skill.skill_experience) }}</p>
                            </li>
                        </ul>
                    </template>
                    <template v-else>
                        <li>
                            <p>資格名: {{ applicant.user.skills.skill_name }}</p>
                            <p>取得日: {{ formatDate(applicant.user.skills.skill_experience) }}</p>
                        </li>
                    </template>

                </ul>
            </div>
            <div v-else>
                <p>応募者なし</p>
            </div>

        </div>
    </AuthenticatedLayout>
</template>