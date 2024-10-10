<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted  } from 'vue';

const props = defineProps({
    academic_bg: {
        type: Object,
    },
});

const form = useForm({
    academic_id: props.academic_bg?.user_id || '',
    school_classification: props.academic_bg?.school_classification || '',
    school_name: props.academic_bg?.school_name || '',
    department: props.academic_bg?.department || '',
    matriculation: props.academic_bg?.matriculation || '',
    graduation: props.academic_bg?.graduation || '',
    undergraduate: props.academic_bg?.undergraduate || false,
});


const publicLabel = computed(() => {
    return "text-red-500 font-bold bg-red-200 py-0.5 px-2 rounded-lg text-xs";
})
</script>

<template>
    <div v-if="form.academic_id" class="mt-20">
        <div class="flex items-center justify-between">
            <div class="text-base font-bold mb-2">学歴</div>
            <Link as:button :href="route('academic.edit', form.academic_id)" class="border-2 border-black rounded-full text-sm py-1 px-4">修正する</Link>
        </div>

        <div class="my-2 border-b-2 border-baseColor pb-4">
            <div class="flex items-center gap-2">
                <InputLabel value="最終学歴" />
                <span :class="publicLabel">公開</span>
            </div>
            <div class="text-xs mt-2">{{ form.school_classification }}</div>
        </div>
        <div class="my-2 border-b-2 border-baseColor pb-4">
            <InputLabel value="学校名・大学名" />
            <div class="text-xs mt-2">{{ form.school_name }}</div>
        </div>
        <div class="my-2 border-b-2 border-baseColor pb-4">
            <InputLabel value="学部・学科" />
            <div class="text-xs mt-2">{{ form.department }}</div>
        </div>
        <div class="my-2">
            <div class="flex items-center gap-2">
                <InputLabel value="卒業年月" />
                <span :class="publicLabel">公開</span>
            </div>
            <div v-if="form.graduation !== null">
                <div class="text-xs mt-2">{{ form.graduation }}</div>
            </div>
            <div v-else class="text-xs mt-2">
                在学中
            </div>
        </div>
    </div>
    <div v-else class="mt-6 flex items-center gap-4">
        <p class="text-sm font-bold text-red-400">学歴が未登録です。</p>
        <Link :href="route('academic.create')" class="block px-8 py-2 text-sky-400 border-2 border-sky-400 rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">登録する</Link>
    </div>
</template>