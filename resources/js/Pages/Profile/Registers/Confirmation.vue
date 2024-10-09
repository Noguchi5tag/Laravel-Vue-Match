<script setup>
import { Head, router } from '@inertiajs/vue3';
import DeleteUserForm from '../Partials/DeleteUserForm.vue';
import LogoutUserForm from '../Partials/LogoutUserForm.vue';
import UpdatePasswordForm from '../Partials/UpdatePasswordForm.vue';
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
    academic_bg: {
        type: Object,
    },
    job_bg: {
        type : Object,
    }
});

const user = usePage().props.auth.user;
const form = useForm({
    id: user.id,
    name: user.name,
    kana: user.kana,
    email: user.email,
    tel: user.tel,
    sex: user.sex,
    birth: user.birth ? formatDate(user.birth) : '',
    postal: user.postal,
    prefectures: user.prefectures,
    city: user.city,
    privacy: user.privacy,

    academic_id: props.academic_bg?.user_id || '',
    school_classification: props.academic_bg?.school_classification || '',
    school_name: props.academic_bg?.school_name || '',
    department: props.academic_bg?.department || '',
    matriculation: props.academic_bg?.matriculation || '',
    graduation: props.academic_bg?.graduation || '',
    undergraduate: props.academic_bg?.undergraduate || false,

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
    form.put(route('profile.update'));
};

const privacyChecked = ref(false);

const handleRegistration = () => {
    form.privacy = 1;
    form.put(route('profile.update'), {
        onSuccess: () => {
            alert('登録が完了しました。');
            router.visit(route('company.index'));
        },
        onError: (errors) => {
            console.error('エラーが発生しました:', errors);
        }
    });
};

//inputのスタイル
const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});

const publicLabel = computed(() => {
    return "text-red-500 font-bold bg-red-200 py-0.5 px-2 rounded-lg text-xs";
})
</script>

<template>
    <Head title="内容確認" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">利用登録の入力内容確認</SiteTitle>
        
        <SectionInner class="my-6 px-4">
            <!-- <div v-if="$page.props.flash.message" class="bg-blue-300">
                {{ $page.props.flash.message }}
            </div> -->
            <div>
                <div class="flex items-center justify-between">
                    <div class="text-base font-bold mb-2">個人情報</div>
                    <button @click="profileUpdate" class="border-2 border-black rounded-full text-sm py-1 px-4">修正する</button>
                </div>
                <div class="text-xs leading-normal tracking-wider border-b-2 border-baseColor py-4">
                    <span :class="publicLabel">公開</span>の表示は企業側が求職者検索をした際に公開する項目です。<br>
                    生年月日は年齢表記となります。<br>
                    例：2000年生まれであれば2024年現在は 20代 と表示。
                </div>
                <div class="flex items-center gap-4 py-4 border-b-2 border-baseColor pb-4">
                    <div class="w-14 h-14 flex-shrink-0 overflow-hidden rounded-full bg-gray-200">
                        <img class="w-full h-full object-cover" :src="`/storage/storages/testAAAA.jpg`" alt="プロフィール画像">
                    </div>
                    <div class="flex flex-col justify-center w-full">
                        <div>
                            <InputLabel>氏名</InputLabel>
                            <TextInput
                                id="name"
                                type="text"
                                :class="inputClasses"
                                class="w-full"
                                v-model="form.name"
                                required
                                autocomplete="username"
                            />
                        </div>
                    </div>
                </div>

                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <InputLabel>フリガナ</InputLabel>
                    <TextInput
                        id="kana"
                        type="text"
                        :class="inputClasses"
                        v-model="form.kana"
                        required
                    />
                </div>
                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <InputLabel>性別</InputLabel>
                    <div class="mt-1 flex justify-start items-center gap-2">
                        <label class="bg-gray-50 px-4 py-1 border-2 border-gray-100 rounded-lg text-sm">
                            <input
                                type="radio"
                                name="sex"
                                value="0"
                                v-model="form.sex"
                                required
                            />
                            男性
                        </label>
                        <label class="bg-gray-50 px-4 py-1 border-2 border-gray-100 rounded-lg text-sm">
                            <input
                                type="radio"
                                name="sex"
                                value="1"
                                v-model="form.sex"
                                required
                            />
                            女性
                        </label>
                        <label class="bg-gray-50 px-4 py-1 border-2 border-gray-100 rounded-lg text-sm">
                            <input
                                type="radio"
                                name="sex"
                                value="2"
                                v-model="form.sex"
                                required
                            />
                            回答しない
                        </label>
                    </div>
                </div>
                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <div class="flex items-center gap-2">
                        <InputLabel for="birth" value="生年月日" />
                        <span :class="publicLabel">公開</span>
                    </div>
    
                    <TextInput
                        id="birth"
                        type="date"
                        :class="inputClasses"
                        v-model="form.birth"
                        required
                        autocomplete="birth"
                    />
                </div>
                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <InputLabel>電話番号</InputLabel>
                    <TextInput
                        id="tel"
                        type="tel"
                        :class="inputClasses"
                        v-model="form.tel"
                        autocomplete="tel"
                        maxlength="11"
                        required
                    />
                </div>
                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <InputLabel>メールアドレス</InputLabel>
                    <TextInput
                        id="email"
                        type="email"
                        :class="inputClasses"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                </div>
                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <InputLabel>住所（郵便番号）</InputLabel>
                    <TextInput
                        id="postal"
                        type="number"
                        :class="inputClasses"
                        v-model="form.postal"
                        required
                        autocomplete="postal"
                    />
                </div>
                <div class="my-2 border-b-2 border-baseColor pb-4">
                    <InputLabel>住所（都道府県）</InputLabel>
                    <select
                        id="prefectures"
                        :class="inputClasses"
                        v-model="form.prefectures"
                        required
                        autocomplete="address-level1"
                    >
                        <option value="" disabled>都道府県を選択してください</option>
                        <option v-for="prefecture in prefectures" :key="prefecture" :value="prefecture">
                            {{ prefecture }}
                        </option>
                    </select>
                </div>
                <div class="my-2">
                    <InputLabel>住所（市町村・番地等）</InputLabel>
                    <TextInput
                        id="city"
                        type="text"
                        :class="inputClasses"
                        v-model="form.city"
                        required
                        autocomplete="address-level2"
                    />
                </div>
            </div>

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

            <div v-if="form.job_bg_id" class="mt-20">
                <div class="flex items-center justify-between">
                    <div class="text-base font-bold mb-2">職務履歴</div>
                    <Link as:button :href="route('jobbg.edit', form.academic_id)" class="border-2 border-black rounded-full text-sm py-1 px-4">修正する</Link>
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
                                <div v-if="form.end_enrollment_year !== '' || form.end_enrollment_month === 0 ">
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

            <div class="flex flex-col gap-4 my-4 border-t-2 border-baseColor pt-4">
                <UpdatePasswordForm />
    
                <LogoutUserForm />
    
                <DeleteUserForm />
            </div>

            <template v-if="form.privacy === 0">
                <div class="bg-baseColor p-4 mt-4 rounded-lg">
                    <div class="text-xs font-bold mb-4">利用登録に関する個人情報保護方針・利用規約</div>
                    <div class="h-36 overflow-y-auto">
                        <div class="mb-4">
                            <div class="mb-2 text-xs font-bold" >1.個人情報保護法に関するコンプライアンス・プログラムの策定</div>
                            <div class="text-xs opacity-50">
                                当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざんおよび漏洩などのリスクを防衛し、個人情報の適切な取り扱いと運用のための基準、ルール、手順などを定めたコンプライアンス・プログラムを策定し、実施します。
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="mb-2 text-xs font-bold" >1.個人情報保護法に関するコンプライアンス・プログラムの策定</div>
                            <div class="text-xs opacity-50">
                                当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざんおよび漏洩などのリスクを防衛し、個人情報の適切な取り扱いと運用のための基準、ルール、手順などを定めたコンプライアンス・プログラムを策定し、実施します。
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="mb-2 text-xs font-bold" >1.個人情報保護法に関するコンプライアンス・プログラムの策定</div>
                            <div class="text-xs opacity-50">
                                当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざんおよび漏洩などのリスクを防衛し、個人情報の適切な取り扱いと運用のための基準、ルール、手順などを定めたコンプライアンス・プログラムを策定し、実施します。
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="my-2 flex justify-center items-center gap-2 mt-4">
                    <input 
                        type="checkbox" 
                        name="currently_working" 
                        id="currently_working" 
                        v-model="privacyChecked"
                        class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                    <p class="text-xs leading-normal tracking-wider">上記の個人情報保護方針に同意する</p>
                </div> 
    
                <div v-if="privacyChecked === true " class="flex flex-col items-center gap-4 py-2">
                    <PrimaryButton @click="handleRegistration">この内容で利用登録</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                    </Transition>
                </div>
            </template>

        </SectionInner>
    </BaseLayouts>
</template>