<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
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
    email: user.email,
    tel: user.tel,
    sex: user.sex,
    birth: user.birth ? formatDate(user.birth) : '',
    postal: user.postal,
    prefectures: user.prefectures,
    city: user.city,
});

const prefectures = [
    '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
    '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
    '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
    '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
    '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
    '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
    '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
];
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">登録情報</h2>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="名前" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
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

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    メールアドレスが未認証です。
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        こちらをクリックして認証メールを再送信してください。
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    登録したメールアドレスに新しい認証リンクが送信されました。
                </div>
            </div>

            <!-- 追記 -->
            <div>
                <InputLabel for="tel" value="電話番号（ハイフンなし）" />

                <TextInput
                    id="tel"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.tel"
                    required
                    autofocus
                    autocomplete="tel"
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
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.prefectures"
                    required
                    autofocus
                    autocomplete="prefectures"
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
                    autocomplete="city"
                    placeholder="長崎市万屋町12-2"
                />

                
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">保 存</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">保存しました。</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
