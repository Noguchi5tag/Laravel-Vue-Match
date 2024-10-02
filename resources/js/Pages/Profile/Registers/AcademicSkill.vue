<script setup>
import { Head } from '@inertiajs/vue3';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm, usePage, router  } from '@inertiajs/vue3';
import { SchoolClass } from '@/data';
import { ref, computed, reactive } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    user: Object,
})
console.log(props.user);

const form = reactive({
    school_classification: null,
    school_name: null,
    department: null,
    matriculation: null,
    graduation: null,
    undergraduate: false,
});

// 保存処理
const profileUpdate = () => {
    console.log(form);

    const today = dayjs().format('YYYY-MM-DD');
    if (form.graduation && form.graduation > today) {
        alert('卒業日は本日以前の日付を選択してください');
        return;
    }

    Inertia.post(route('academic.store'),{
        user_id: props.user.id,
        school_classification: form.school_classification,
        school_name: form.school_name,
        department: form.department,
        matriculation: form.matriculation,
        graduation: form.graduation,
        undergraduate: form.undergraduate,
    });
};

const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});
</script>

<template>
    <Head title="利用登録・経歴・スキル" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">経歴・スキル</SiteTitle>
        <div class="flex justify-around items-center bg-baseColor">
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">1.個人情報</div>
            <div class="w-full py-2 text-center text-sm font-bold border-black border-b-2">2.経歴・スキル</div>
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">3.応募条件</div>
        </div>
        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの学歴・職務経歴等を入力します。ここで入力した情報はいつでも修正・削除ができます。ここで入力した情報は求職者一覧にて企業側に情報が開示されます。
            </div>

            <form @submit.prevent="profileUpdate" class="mt-6 flex flex-col gap-6">
                <div>
                    <InputLabel value="最終学歴を入力" />
                    <select
                        id="school_classification"
                        :class="inputClasses"
                        v-model="form.school_classification"
                        required
                        autofocus
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
                        autofocus
                        placeholder="学校名を入力"
                    />
                    
                    <TextInput
                        id="department"
                        type="text"
                        :class="inputClasses"
                        v-model="form.department"
                        required
                        autofocus
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
                        autofocus
                        placeholder="入学した年月"
                    />

                    <p class="mt-2 text-xs leading-normal tracking-wider">卒業した年月</p>
                    <TextInput
                        id="graduation"
                        type="date"
                        :class="inputClasses"
                        v-model="form.graduation"
                        autofocus
                        placeholder="卒業した年月"
                    />

                    <div class="mt-2  flex justify-start items-center gap-2">
                        <TextInput
                        id="undergraduate"
                        type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500"
                        v-model="form.undergraduate"
                        autofocus
                        />
                        <p class="text-xs leading-normal tracking-wider">在学中の方のみチェック</p>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-4 border-t-2 border-baseColor py-4">
                    <PrimaryButton>保存して応募条件等を入力する</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm ">保存しました。</p>
                    </Transition>
                </div>
            </form>
        </SectionInner>
    </BaseLayouts>
</template>