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
import { useForm, usePage, router, Link  } from '@inertiajs/vue3';
import { prefectures } from '@/data';
import { ref, computed } from 'vue';

const user = usePage().props.auth.user;
const form = useForm({
    name: user.name,
    kana: user.kana,
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
    <Head title="利用登録・個人情報" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">利用登録</SiteTitle>
        <div class="flex justify-around items-center bg-baseColor">
            <div class="w-full py-2 text-center text-sm font-bold border-black border-b-2">
                <Link as:button :href="route('personal.register')">1.個人情報</Link>
            </div>
            <div class="w-full py-2 text-center text-sm font-bold opacity-50">
                <Link as:button :href="route('academic.create')">2.学歴・職務履歴</Link>
            </div>
            <!-- <div class="w-full py-2 text-center text-sm font-bold opacity-50">3.応募条件</div> -->
        </div>
        <SectionInner class="my-6 px-4">
            <div class="text-xs opacity-50 leading-normal tracking-wider">
                あなたの氏名・電話番号・メールアドレス等を入力します。ここで入力した情報はいつでも修正・削除ができます。企業とマッチングするまで、年代を除き、その他の個人情報が開示されることはありません。
            </div>

            <form class="mt-6 flex flex-col gap-6">
                <div>
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

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <TextInput
                        id="kana"
                        type="text"
                        :class="inputClasses"
                        v-model="form.kana"
                        required
                        autofocus
                        placeholder="フリガナを入力"
                    />

                    <InputError class="mt-2" :message="form.errors.kana" />
                </div>

                <div>
                    <InputLabel for="sex" value="性別を入力" />

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

                    <InputError class="mt-2" :message="form.errors.sex" />
                </div>

                <div>
                    <InputLabel for="birth" value="生年月日を入力" />

                    <TextInput
                        id="birth"
                        type="date"
                        :class="inputClasses"
                        v-model="form.birth"
                        required
                        autofocus
                        autocomplete="birth"
                    />

                    <InputError class="mt-2" :message="form.errors.birth" />
                </div>

                <div>
                    <InputLabel value="連絡先を入力" />
                    <div>
                        <TextInput
                            id="tel"
                            type="tel"
                            :class="inputClasses"
                            v-model="form.tel"
                            required
                            autofocus
                            autocomplete="tel"
                            maxlength="11"
                            placeholder="電話番号を入力"
                        />
                        <InputError class="mt-2" :message="form.errors.tel" />
                    </div>
                    <div>
                        <TextInput
                        id="email"
                        type="email"
                        :class="inputClasses"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="メールアドレスを入力"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>

                <div>
                    <InputLabel for="postal" value="住所を入力" />

                    <div>
                        <TextInput
                            id="postal"
                            type="number"
                            :class="inputClasses"
                            v-model="form.postal"
                            required
                            autofocus
                            autocomplete="postal"
                            placeholder="郵便番号を入力"
                        />
                        <p class="text-xs opacity-50 leading-normal tracking-wider">※ハイフンなしで入力</p>
    
                        <InputError class="mt-2" :message="form.errors.postal" />
                    </div>
                    <div>
                        <select
                            id="prefectures"
                            :class="inputClasses"
                            v-model="form.prefectures"
                            required
                            autofocus
                            autocomplete="address-level1"
                        >
                            <option value="" disabled>都道府県を選択してください</option>
                            <option v-for="prefecture in prefectures" :key="prefecture" :value="prefecture">
                                {{ prefecture }}
                            </option>
                        </select>
    
                        <InputError class="mt-2" :message="form.errors.prefectures" />
                    </div>
                    <div>
                        <TextInput
                            id="city"
                            type="text"
                            :class="inputClasses"
                            v-model="form.city"
                            required
                            autofocus
                            autocomplete="address-level2"
                            placeholder="市町村・番地まで入力"
                        />
                        <p class="mt-1 text-xs opacity-50 leading-normal tracking-wider">アパート・マンション等にお住まいの方は、番地以降にスペースを入れて建物名・部屋番号を続けて入力してください。</p>
                        <InputError class="mt-2" :message="form.errors.city" />
                    </div>
                </div>

                <div class="flex flex-col items-center gap-4 border-t-2 border-baseColor py-4">
                    <PrimaryButton @click="profileUpdate" :disabled="form.processing">保存して経歴・職務履歴を入力する</PrimaryButton>
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