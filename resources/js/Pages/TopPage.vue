<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import BasePage from '../Layouts/BaseLayouts.vue';
import { ref, onMounted } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { prefectures } from '@/data';

//ログインしているかどうかの処理
const isAdmin = ref(false);
onMounted(() => {
    const currentUrl = window.location.pathname;
    isAdmin.value = currentUrl.includes('/admin/');
});

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    inertiaJob: Object,
    news: Object,
});

const form = useForm({
    name: '',
    email: '',
    tel: '',
    sex: '',
    birth: '',
    postal: '',
    prefectures: '',
    city: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Home" />

    <BasePage>
        <div v-if="canLogin || !isAdmin">
            <template v-if="$page.props.auth.user">
                <div class="my-4">
                    <!-- ここにおすすめ求人を表示 -->
                    <h1 class="text-center">おすすめ求人</h1>
                    <div v-if="inertiaJob.data.length" >
                        <template v-for="job in inertiaJob.data" :key="job.id">
                            <div class="rounded-lg bg-gray-100 my-6 mx-2 py-6 " v-if="job.status === 1">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyName" class="leading-7 text-sm ">会社名</label>
                                        <div id="companyName" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyName }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="WantedTitles" class="leading-7 text-sm ">募集タイトル</label>
                                        <div id="WantedTitles" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.WantedTitles }}</div>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyAddress" class="leading-7 text-sm ">会社の住所</label>
                                        <div id="companyAddress" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ job.companyAddress }}</div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="p-2 w-full">
                        <Link as="button" :href="route('company.index')" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">もっと見る</Link>
                    </div>
                </div>

                <!-- お知らせ一覧 -->
                <section class=" body-font">
                    <div class="container px-5 py-6 mx-auto">
                        <h2 class="text-gray-900 text-lg title-font font-medium text-center">お知らせ</h2>
                        <div v-if="news.data.length" class="flex flex-col flex-wrap py-6">
                            <div v-for="n in news.data" :key="n.id">
                                <div class="flex flex-col mb-10 lg:items-start items-center">
                                    <div class="flex-grow">
                                        <h2 class=" text-gray-900 text-lg title-font font-medium">
                                            {{ n.title }}
                                        </h2>
                                        <NavLink href="/news">
                                            <p>詳しく見る</p>
                                        </NavLink>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-8 w-full flex justify-center">
                            <Link href="/news" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">お知らせ一覧</Link>
                        </div>
                    </div>
                </section>
            </template>

            <div v-else class="mb-10">
                <div class="">
                    <img src="../../../public/images/top-image.jpg" alt="">
                </div>
                
                <form @submit.prevent="submit">
                    <div class="max-w-7xl mx-auto my-12 px-6 space-y-6">
                        <div class="mt-6 text-center">
                            <Link
                                :href="route('login')"
                                as:button
                                class="relative z-0 h-12 rounded-full bg-blue-500 p-4 text-neutral-50 after:absolute after:left-0 after:top-0 after:-z-10 after:h-full after:w-full after:rounded-full after:bg-blue-500 hover:after:scale-x-125 hover:after:scale-y-150 hover:after:opacity-0 hover:after:transition hover:after:duration-500">すでにアカウントをお持ちですか？
                            </Link>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <InputLabel for="name" value="名前" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>
            
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
            
                        <div class="mt-4">
                            <div class="flex items-center">
                                <InputLabel for="email" value="メールアドレス" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>
            
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

                        <!-- ここに追加 -->
                        <div>
                            <div class="flex items-center">
                                <InputLabel for="tel" value="電話番号（ハイフンなし）" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>

                            <TextInput
                                id="tel"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.tel"
                                required
                                autofocus
                                autocomplete="tel"
                                pattern="\d*"
                                maxlength="11"
                            />

                            <InputError class="mt-2" :message="form.errors.tel" />
                        </div>

                        <div>
                            <div class="flex items-center">
                                <InputLabel for="sex" value="性別" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>

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
                            <div class="flex items-center">
                                <InputLabel for="birth" value="生年月日" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>

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
                            <div class="flex items-center">
                                <InputLabel for="postal" value="郵便番号（ハイフンなし）" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>

                            <TextInput
                                id="postal"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.postal"
                                required
                                autofocus
                                autocomplete="postal"
                                placeholder="8501122"
                            />

                            <InputError class="mt-2" :message="form.errors.postal" />
                        </div>

                        <div>
                            <div class="flex items-center">
                                <InputLabel for="prefectures" value="都道府県" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>

                            <select
                                id="prefectures"
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
                            <div class="flex items-center">
                                <InputLabel for="city" value="市町村" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>

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
            
                        <div class="mt-4">
                            <div class="flex items-center">
                                <InputLabel for="password" value="パスワード" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>
            
                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />
            
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
            
                        <div class="mt-4">
                            <div class="flex items-center">
                                <InputLabel for="password_confirmation" value="パスワードを再入力" />
                                <span class="bg-red-500 text-white text-sm px-1 py-0.5 rounded ml-2">必須</span>
                            </div>
            
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />
            
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
            
                        <div class="text-center">
                            <Link
                                :href="route('rules')"
                                class="underline text-sm  hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                利用規約
                            </Link>
                            と
                            <Link
                                :href="route('Privacy')"
                                class="underline text-sm  hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                プライバシーポリシー
                            </Link>
                            に
                            <PrimaryButton class="my-1 ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                同意して登録
                            </PrimaryButton>
                        </div>
                    </div>
                </form>

                <div class="flex justify-center">
                    <Link
                        v-if="canRegister"
                        :href="route('admin.login')"
                        class="bg-[#232] rounded-md px-3 py-2 text-white"
                    >
                        管理者ページへ
                    </Link>
                </div>

            </div>
        </div>
    </BasePage>
</template>
