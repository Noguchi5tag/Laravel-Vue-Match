<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted  } from 'vue';

const props = defineProps({
    job_requirements: {
        type : Array,
    },
});

const form = useForm({
    id: props.job_requirements[0]?.id || '',
    user_id: props.job_requirements[0]?.user_id || '',
    job_category: props.job_requirements[0]?.job_category || '',
    prefecture: props.job_requirements[0]?.prefecture || '',
    dutyStation: props.job_requirements[0]?.dutyStation || '',
    relocation: props.job_requirements[0]?.relocation || false,
    job_join: props.job_requirements[0]?.job_join || '',
    employment_type: props.job_requirements[0]?.employment_type || '',
    salary_type: props.job_requirements[0]?.salary_type || '',
    salary_amount: props.job_requirements[0]?.salary_amount || '',
    particular_type: props.job_requirements[0]?.particular_type || '',
});


const relocationStatus = computed(() => {
    return form.relocation ? '可' : '不可';
});

const publicLabel = computed(() => {
    return "text-red-500 font-bold bg-red-200 py-0.5 px-2 rounded-lg text-xs";
})
</script>

<template>
    <div v-if="form.user_id" class="my-20">
        <div class="flex items-center justify-between">
            <div class="text-base font-bold mb-2">こだわり条件</div>
            <Link as:button :href="route('requirements.edit', form.id)" class="border-2 border-black rounded-full text-sm py-1 px-4">修正する</Link>
        </div>

        <div class="mt-4">
            <div class="mt-4 border-b-2 border-baseColor pb-4">
                <InputLabel value="希望職種" />
                <div class="text-xs">{{ form.job_category }}</div>
            </div>

            <div class="my-4 border-b-2 border-baseColor pb-4">
                <InputLabel value="希望勤務地" />
                <div class="text-xs">{{ form.prefecture }}{{ form.dutyStation }}</div>
            </div>

            <div class="my-4 border-b-2 border-baseColor pb-4">
                <InputLabel value="転勤有でも可" />
                <div class="flex items-center gap-2">
                    <div class="text-xs">
                    {{ relocationStatus }}
                    </div>
                </div>
            </div>
            <div class="my-4 border-b-2 border-baseColor pb-4">
                <InputLabel value="希望入社時期" />
                <div class="text-xs">{{ form.job_join }}</div>
            </div>
            <div class="my-4 border-b-2 border-baseColor pb-4">
                <InputLabel value="希望雇用形態" />
                <div class="text-xs">{{ form.employment_type }}</div>
            </div>
            <div class="my-4 border-b-2 border-baseColor pb-4">
                <InputLabel value="希望年収または月収" />
                <div class="text-xs">{{ form.salary_type }}：{{ form.salary_amount }}円</div>
            </div>
            <div class="my-4">
                <InputLabel value="こだわり条件" />
                <div class="text-xs">{{ form.particular_type }}</div>
            </div>
        </div>
    </div>
    <div v-else class="mt-6 flex items-center gap-4">
        <p class="text-sm font-bold text-red-400">こだわり条件が未登録です。</p>
        <Link :href="route('requirements.create')" class="block px-8 py-2 text-sky-400 border-2 border-sky-400 rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">登録する</Link>
    </div>
</template>