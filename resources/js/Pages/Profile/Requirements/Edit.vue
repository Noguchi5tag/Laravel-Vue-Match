<script setup>
import { reactive, computed, onMounted } from 'vue';
import { Link, Head, useForm  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { SchoolClass } from '@/data';
import dayjs from 'dayjs';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    job_requirements: Array,
})

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

const updateFunction = () => {
    form.put(route('requirements.update', form.id));
};

const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});
</script>

<template>
    <Head title="こだわり条件変更" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">こだわり条件更新</SiteTitle>

        <SectionInner class="my-6 px-4">

            <form @submit.prevent="updateFunction" class="mt-6 flex flex-col gap-6">
                <div>
                    <InputLabel value="希望職種" />
                    <select
                        id="school_classification"
                        :class="inputClasses"
                        v-model="form.school_classification"
                        required
                        
                        autocomplete="address-level1"
                    >
                        <option value="" disabled selected>学校区分</option>
                        <option v-for="item in SchoolClass" :key="item.value" :value="item.value">
                            {{ item.value }}
                        </option>
                    </select>

                    <TextInput
                        id="school_name"
                        type="text"
                        :class="inputClasses"
                        v-model="form.school_name"
                        required
                        
                        placeholder="学校名を入力"
                    />
                    
                    <TextInput
                        id="department"
                        type="text"
                        :class="inputClasses"
                        v-model="form.department"
                        required
                        
                        placeholder="学部・学科名を入力"
                    />
                </div>

                <div>
                    <InputLabel value="卒業区分を入力" />

                    <p class="mt-2 text-xs leading-normal tracking-wider">入学した年月</p>
                    <TextInput
                        id="matriculation"
                        type="date"
                        :class="inputClasses"
                        v-model="form.matriculation"
                        required
                        
                        placeholder="入学した年月"
                    />

                    <p class="mt-2 text-xs leading-normal tracking-wider">卒業した年月</p>
                    <TextInput
                        id="graduation"
                        type="date"
                        :class="inputClasses"
                        v-model="form.graduation"
                        
                        placeholder="卒業した年月"
                    />

                    <div class="mt-2  flex justify-start items-center gap-2">
                        <input 
                            type="checkbox" 
                            name="undergraduate" 
                            id="undergraduate" 
                            v-model="isUndergraduate" 
                            class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <p class="text-xs leading-normal tracking-wider">在学中の方のみチェック</p>
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