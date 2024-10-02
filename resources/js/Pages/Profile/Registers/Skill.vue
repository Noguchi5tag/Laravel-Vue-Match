<script setup>
import { reactive, computed } from 'vue';
import { Link, Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    user: Object,
})

const form = reactive({
    skill_name: null,
    skill_experience: null,
});

//登録処理
const submitFunction = () => {
    Inertia.post(route('skill.store'),{
        skill_name: form.skill_name,
        skill_experience: form.skill_experience,
        user_id: props.user.id,
    });
};

const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});

const months = [
    1,2,3,4,5,6,7,8,9,10,11,12
]
</script>

<template>
<Head title="利用登録・職務履歴" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">職務履歴</SiteTitle>
        <div class="flex justify-around items-center bg-baseColor">
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">1.個人情報</div>
            <div class="w-full py-2 text-center text-sm font-bold border-black border-b-2">2.経歴・職務履歴</div>
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">3.応募条件</div>
        </div>
        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの学歴・職務経歴等を入力します。ここで入力した情報はいつでも修正・削除ができます。ここで入力した情報は求職者一覧にて企業側に情報が開示されます。
            </div>

            <form @submit.prevent="submitFunction" class="mt-6 flex flex-col gap-6">

                <InputLabel value="職務履歴を入力" />
                <div>
                    <InputLabel value="職務履歴１（直近）" />
                    <TextInput
                        id=""
                        type="text"
                        :class="inputClasses"
                        v-model="form.skill_name"
                        autofocus
                        placeholder="勤務先名"
                    />

                    <TextInput
                        id=""
                        type="text"
                        :class="inputClasses"
                        v-model="form.skill_name"
                        autofocus
                        placeholder="勤務先の事業内容"
                    />
                </div>
                <div>
                    <InputLabel value="勤務年数を入力" />
                    <InputLabel value="入社日" />
                    <div class="flex items-center gap-4 mb-4">
                        <TextInput
                            id=""
                            type="number"
                            :class="inputClasses"
                            class="w-2/3"
                            v-model="form.skill_name"
                            autofocus
                            placeholder="年を入力"
                        />
                        <select
                            id="school_classification"
                            :class="inputClasses"
                            class="w-1/3"
                            v-model="form.school_classification"
                            autocomplete="address-level1"
                        >
                            <option value="" disabled selected>月を入力</option>
                            <option v-for="item in months" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                    <InputLabel value="退社日" />
                    <div class="flex items-center gap-4">
                        <TextInput
                            id=""
                            type="number"
                            :class="inputClasses"
                            class="w-2/3"
                            v-model="form.skill_name"
                            autofocus
                            placeholder="年を入力"
                        />
                        <select
                            id="school_classification"
                            :class="inputClasses"
                            class="w-1/3"
                            v-model="form.school_classification"
                            autocomplete="address-level1"
                        >
                            <option value="" disabled selected>月を入力</option>
                            <option v-for="item in months" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <TextArea
                            id=""
                            type="text"
                            :class="inputClasses"
                            v-model="form.other_manager"
                            placeholder="仕事内容を入力（配置部署・役職経験の有無など詳細に記載）"
                        />
                    </div>
                </div>
                <div>
                    <InputLabel value="在籍時の役職を入力" />
                    <select
                        id="school_classification"
                        :class="inputClasses"
                        class="w-1/3"
                        v-model="form.school_classification"
                        autocomplete="address-level1"
                    >
                        <option value="" disabled selected>月を入力</option>
                        <option v-for="item in months" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div>
                    <InputLabel value="在籍時の給与を入力（任意）" />
                    <div class="flex items-end gap-2">
                        <select
                            id="school_classification"
                            :class="inputClasses"
                            class="w-1/4"
                            v-model="form.school_classification"
                            autocomplete="address-level1"
                        >
                            <option value="" disabled selected>月を入力</option>
                            <option v-for="item in months" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <TextInput
                            id=""
                            type="number"
                            :class="inputClasses"
                            class="w-1/3"
                            v-model="form.skill_name"
                            autofocus
                            placeholder="300"
                        />
                        <p class="text-sm">万円</p>
                    </div>
                </div>
                <button class="flex justify-center gap-4 py-6 text-sm font-bold bg-sky-100 rounded-lg">
                    職務履歴を追加（任意）
                </button>
                <div class="flex flex-col items-center gap-4 border-t-2 border-baseColor py-4">
                    <PrimaryButton>保存して応募条件を入力する</PrimaryButton>
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