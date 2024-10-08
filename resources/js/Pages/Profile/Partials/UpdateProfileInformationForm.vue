<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NavLink from '@/Components/NavLink.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { prefectures } from '@/data';
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
});

const user = usePage().props.auth.user;

// 日付を yyyy-MM-dd 形式に変換する関数
function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

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
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">登録情報</h2>
        </header>

        <form class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="名前" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="kana" value="フリガナ" />

                <TextInput
                    id="kana"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.kana"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.kana" />
            </div>

            <div>
                <InputLabel for="email" value="メールアドレス" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="tel" value="電話番号（ハイフンなし）" />

                <TextInput
                    id="tel"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                    required
                    autofocus
                    autocomplete="tel"
                    maxlength="11"
                />

                <InputError class="mt-2" :message="form.errors.tel" />
            </div>

            <div>
                <InputLabel for="sex" value="性別" />

                <div class="mt-1">
                    <label class="">
                        <input
                            type="radio"
                            name="sex"
                            value="0"
                            v-model="form.sex"
                            required
                        />
                        男性
                    </label>
                    <label class="">
                        <input
                            type="radio"
                            name="sex"
                            value="1"
                            v-model="form.sex"
                            required
                        />
                        女性
                    </label>
                    <label class="">
                        <input
                            type="radio"
                            name="sex"
                            value="2"
                            v-model="form.sex"
                            required
                        />
                        どちらでもない
                    </label>
                </div>

                <InputError class="mt-2" :message="form.errors.sex" />
            </div>

            <div>
                <InputLabel for="birth" value="生年月日" />

                <TextInput
                    id="birth"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.birth"
                    required
                    autofocus
                    autocomplete="birth"
                />

                <InputError class="mt-2" :message="form.errors.birth" />
            </div>

            <div class="">
                <InputLabel value="住所" />
            </div>

            <div>
                <InputLabel for="postal" value="郵便番号" />

                <TextInput
                    id="postal"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.postal"
                    required
                    autofocus
                    autocomplete="postal"
                    placeholder="テスト850-1122"
                />

                <InputError class="mt-2" :message="form.errors.postal" />
            </div>

            <div>
                <InputLabel for="prefectures" value="都道府県" />

                <select
                    id="prefectures"
                    class="mt-1 block w-full"
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
                <InputLabel for="city" value="市町村" />

                <TextInput
                    id="city"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                    required
                    autofocus
                    autocomplete="address-level2"
                    placeholder="長崎市万屋町12-2"
                />
                
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton @click="profileUpdate" :disabled="form.processing">保 存</PrimaryButton>

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
    </section>
</template>
