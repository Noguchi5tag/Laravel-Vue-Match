<script setup>
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NavLink from '@/Components/NavLink.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    hasSkill: {
        type: Boolean,
    },
    hasAcademicBg: {
        type: Boolean,
    },
    hasJobBg: {
        type: Boolean,
    },
    userAuth: {
        type: Object,
    },
});

//現在のURL（クエリパラメータなし）
const currentUrl =  window.location.pathname;

const query = new URLSearchParams(window.location.search);
const companyName = query.get('companyName');
const jobId = query.get('job_id');

function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}年${month}月${day}日`;
}

const form = useForm({
    birth: props.userAuth.birth ? formatDate(props.userAuth.birth) : '',
});


const jobSubmit = (jobId) => {
    Inertia.post(route('job.apply', jobId), {
        job_id: jobId,
        company_name: companyName,
    });
};

</script>

<template>
        <Head title="簡単応募" />
        <BaseLayouts>

            <h1 class="mt-4 text-lg text-center">{{ companyName }}</h1>

            <div class="m-4 px-4 border-2 rounded-lg ">
                <!-- 基本情報 -->
                <div v-if="userAuth">
                    <div class="my-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="名前" />

                            <div id="name" class="mt-1 block w-full">{{ props.userAuth.name }}</div>
                        </div>

                        <div>
                            <InputLabel for="email" value="メールアドレス" />
                            <div id="email" class="mt-1 block w-full">{{ props.userAuth.email }}</div>
                        </div>

                        <div>
                            <InputLabel for="tel" value="電話番号（ハイフンなし）" />
                            <div id="tel" class="mt-1 block w-full">{{ props.userAuth.tel }}</div>
                        </div>

                        <div>
                            <InputLabel for="sex" value="性別" />
                            <div id="sex" class="mt-1 block w-full">
                                <template v-if="props.userAuth.sex === 0">男性</template>
                                <template v-else-if="props.userAuth.sex === 1">女性</template>
                                <template v-else>どちらでもない</template>
                            </div>
                        </div>

                        <div>
                            <InputLabel for="birth" value="生年月日" />
                            <div id="birth" class="mt-1 block w-full">{{ form.birth }}</div>
                        </div>

                        <div class="">
                            <InputLabel value="住所" />
                        </div>

                        <div>
                            <InputLabel for="postal" value="郵便番号" />
                            <div id="postal" class="mt-1 block w-full">{{ props.userAuth.postal }}</div>
                        </div>

                        <div>
                            <InputLabel for="prefectures" value="都道府県" />
                            <div id="prefectures" class="mt-1 block w-full">{{ props.userAuth.prefectures }}</div>
                        </div>

                        <div>
                            <InputLabel for="city" value="市町村" />
                            <div id="city" class="mt-1 block w-full">{{ props.userAuth.city }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-4 mb-6">
                        <template v-if="props.hasAcademicBg === false && props.hasJobBg === false">
                            <NavLink href="/profile" as:button class="text-red-500">学歴と職歴を登録してください</NavLink>
                        </template>
                        <template v-if="props.hasAcademicBg === false && props.hasJobBg === true">
                            <Link href="/academic" as:button>学歴を登録する</Link>
                        </template>
                        <template v-else-if="props.hasJobBg === false && props.hasAcademicBg === true">
                            <Link href="/jobbg/create" as:button>職歴を登録する</Link>
                        </template>
                        <template v-else-if="currentUrl === '/job-contact' && props.hasAcademicBg === true && props.hasJobBg === true">
                            <PrimaryButton @click="() => jobSubmit(jobId, companyName)">応募する</PrimaryButton>
                        </template>
                    </div>
                </div>
            </div>
            
        </BaseLayouts>
</template>