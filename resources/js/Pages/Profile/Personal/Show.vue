<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { prefectures } from '@/data';
import { ref, computed, onMounted  } from 'vue';

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

//inputのスタイル
const inputClasses = computed(() => {
    return "mt-2 block w-full bg-gray-50 border-1 border-gray-200 text-sm rounded-md";
});

const publicLabel = computed(() => {
    return "text-red-500 font-bold bg-red-200 py-0.5 px-2 rounded-lg text-xs";
})
</script>

<template>
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
</template>