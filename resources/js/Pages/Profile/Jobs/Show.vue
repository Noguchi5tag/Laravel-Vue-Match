<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted  } from 'vue';

const props = defineProps({
    job_bg: {
        type : Object,
    },
    academic_bg: {
        type: Object,
    },
});

const form = useForm({
    academic_id: props.academic_bg?.user_id || '',
    
    job_bg_id: props.job_bg?.user_id || '',
    company_name: props.job_bg?.company_name || '',
    company_business: props.job_bg?.company_business || '',
    start_enrollment_year: props.job_bg?.start_enrollment_year || '',
    start_enrollment_month: props.job_bg?.start_enrollment_month || '',
    currently_working: props.job_bg?.currently_working || false,
    end_enrollment_year: props.job_bg?.end_enrollment_year || '',
    end_enrollment_month: props.job_bg?.end_enrollment_month || '',
    business_other: props.job_bg?.business_other || '',
    company_post: props.job_bg?.company_post || '',
    company_pay_type: props.job_bg?.company_pay_type || '',
    company_pay: props.job_bg?.company_pay || '',
});

const publicLabel = computed(() => {
    return "text-red-500 font-bold bg-red-200 py-0.5 px-2 rounded-lg text-xs";
})
</script>

<template>
    <div v-if="form.job_bg_id" class="mt-20">
        <div class="flex items-center justify-between">
            <div class="text-base font-bold mb-2">職務履歴</div>
            <Link as:button :href="route('jobbg.edit', form.academic_id)" class="border-2 border-black rounded-full text-sm py-1 px-4">更新する</Link>
        </div>

        <div class="bg-baseColor p-4 mt-4">
            <InputLabel value="職務履歴１" />
            <div class="mt-4 mb-2">
                <InputLabel value="勤務先名" />
                <div class="text-xs">{{ form.company_name }}</div>
            </div>

            <div class="my-4">
                <div class="flex items-center gap-2">
                    <InputLabel value="事業内容" />
                    <span :class="publicLabel">公開</span>
                </div>
                <div class="text-xs">{{ form.company_business }}</div>
            </div>

            <div class="my-4">
                <div class="flex items-center gap-2">
                    <InputLabel value="勤続年数" />
                    <span :class="publicLabel">公開</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="text-xs">
                    {{ form.start_enrollment_year }}年{{ form.start_enrollment_month }}月〜
                    </div>
                    <div>
                        <div class="text-xs" v-if="form.end_enrollment_year !== '' || form.end_enrollment_month === 0 ">
                            {{ form.end_enrollment_year }}年{{ form.end_enrollment_month }}月
                        </div>
                        <div v-else class="text-xs">
                            現職中
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="flex items-center gap-2">
                    <InputLabel value="仕事内容" />
                    <span :class="publicLabel">公開</span>
                </div>
                <div class="text-xs">{{ form.business_other }}</div>
            </div>
            <div class="my-4">
                <div class="flex items-center gap-2">
                    <InputLabel value="在職時の役職" />
                    <span :class="publicLabel">公開</span>
                </div>
                <div class="text-xs">{{ form.company_post }}</div>
            </div>
            <div v-if="form.company_pay === 0">
                <div class="my-4">
                    <InputLabel value="在職時の給与" />
                    <div class="text-xs">{{ form.company_pay_type }}{{ form.company_pay }}万円</div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="mt-6 flex items-center gap-4">
        <p class="text-sm font-bold text-red-400">職務履歴が未登録です。</p>
        <Link :href="route('jobbg.create')" class="block px-8 py-2 text-sky-400 border-2 border-sky-400 rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">登録する</Link>
    </div>
</template>