<script setup>
import { reactive, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';

const props = defineProps({
    applicants: Array,
});

// 年齢の計算
function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    return age;
}

// 応募者の数を取得
const applicantCount = Array.isArray(props.applicants) ? props.applicants.length : 1;

// いいねの処理
function likeApplicant(applicantId) {
    Inertia.post(`/manager/applicants/${applicantId}/like`, {
        liked: 1,
    }, {
        onSuccess: () => {
            console.log('Liked successfully');
        },
        onError: (errors) => {
            console.error('Error liking applicant', errors);
        }
    });
    alert('いいね！しました');
}
</script>

<template>
    <Head title="応募リスト" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">応募リスト</h2>
            <p>応募数：{{ applicantCount }}件</p>
        </template>

        <div class="py-6 max-w-screen-lg mx-auto">
            <div v-if="applicants.length > 0">
                <table class="min-w-full border-collapse border border-gray-300 bg-white">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">#</th>
                            <th class="border border-gray-300 px-4 py-2">いいね！する</th>
                            <th class="border border-gray-300 px-4 py-2">募集タイトル</th>
                            <th class="border border-gray-300 px-4 py-2">氏名</th>
                            <th class="border border-gray-300 px-4 py-2">メールアドレス</th>
                            <th class="border border-gray-300 px-4 py-2">電話番号</th>
                            <th class="border border-gray-300 px-4 py-2">性別</th>
                            <th class="border border-gray-300 px-4 py-2">年齢</th>
                            <th class="border border-gray-300 px-4 py-2">最終学歴（学校名）</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(applicant, index) in applicants" :key="index">
                            <!-- 順番番号 -->
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ index + 1 }}</td>
                        
                            <!-- いいね -->
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <button @click="likeApplicant(applicant.id)" v-if="applicant.liked === 0">
                                    <font-awesome-icon :icon="['fas', 'thumbs-up']"  class="w-5 h-5" />
                                </button>
                                <div v-else>いいね！済み</div>
                            </td>

                            <!-- 募集タイトル -->
                            <td class="border border-gray-300 px-4 py-2">{{ applicant.job.WantedTitles }}</td>

                            <!-- 氏名 -->
                            <td class="border border-gray-300 px-4 py-2">{{ applicant.user.name }}</td>

                            <!-- メールアドレス -->
                            <td class="border border-gray-300 px-4 py-2">{{ applicant.user.email }}</td>

                            <!-- 電話番号 -->
                            <td class="border border-gray-300 px-4 py-2">{{ applicant.user.tel }}</td>

                            <!-- 性別 -->
                            <td class="border border-gray-300 px-4 py-2">
                                <template v-if="applicant.user.sex === 1">男</template>
                                <template v-else-if="applicant.user.sex === 2">女</template>
                                <template v-else>その他</template>
                            </td>

                            <!-- 年齢 -->
                            <td class="border border-gray-300 px-4 py-2">満{{ calculateAge(applicant.user.birth) }}歳</td>

                            <!-- 学歴（学校名） -->
                            <td class="border border-gray-300 px-4 py-2">{{ applicant.user.academic_bg.school_name }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <p>応募者なし</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
    text-align: center;
}

td {
    text-align: center;
}
</style>
