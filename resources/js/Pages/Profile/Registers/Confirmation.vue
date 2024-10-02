<script setup>
import { Head } from '@inertiajs/vue3';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { prefectures } from '@/data';
import { ref, computed, onMounted  } from 'vue';

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
});

const user = usePage().props.auth.user;
const form = useForm({
    name: user.name,
    email: user.email,
    tel: user.tel,
    sex: user.sex,
    birth: user.birth ? formatDate(user.birth) : '',
    postal: user.postal,
    prefectures: user.prefectures,
    city: user.city,
});

// 日付を yyyy-MM-dd 形式に変換する関数
function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// 保存処理
const profileUpdate = () => {
    form.patch(route('profile.update'));
};

//inputのスタイル
const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});
</script>

<template>
    <Head title="内容確認" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">内容確認</SiteTitle>
        
        <SectionInner class="my-6 px-4">
            <TextInput
                id="name"
                type="text"
                :class="inputClasses"
                v-model="form.name"
                required
                autofocus
                autocomplete="username"
                placeholder="名前を入力（フルネーム）"
            />

            <button @click="profileUpdate" class="border-2 border-black rounded-full text-xs py-2 px-8">保存する</button>
        </SectionInner>
    </BaseLayouts>
</template>