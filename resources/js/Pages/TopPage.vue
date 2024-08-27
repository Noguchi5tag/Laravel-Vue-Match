<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import { ref, onMounted } from 'vue';

//ログインしているかどうかの処理
const isAdmin = ref(false);
onMounted(() => {
    const currentUrl = window.location.pathname;
    isAdmin.value = currentUrl.includes('/admin/');
});

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Home" />

    <BasePage>
        <SiteTitle>ホーム</SiteTitle>

        <div class="my-10 text-center">
            <nav v-if="canLogin || !isAdmin" class="">
                <div
                    v-if="$page.props.auth.user"
                    class=""
                >
                    <div class="">
                    <!-- ここにおすすめの企業を表示 -->
                    </div>

                    <!-- お知らせ一覧 -->
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-6 mx-auto">
                            <h2 class="text-gray-900 text-lg title-font font-medium">お知らせ</h2>
                            <div class="flex flex-col flex-wrap py-6 text-left">
                                <div class="flex flex-col mb-10 lg:items-start items-center">
                                    <div class="flex-grow">
                                        <NavLink href="/news">
                                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">新機能「スキップマッチング」登場！</h2>
                                        </NavLink>
                                    </div>
                                </div>
                                <div class="flex flex-col mb-10 lg:items-start items-center">
                                    <div class="flex-grow">
                                        <NavLink href="/news">
                                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3"> オンラインキャリア相談会「あなたのキャリアを一緒に考えよう！」</h2>
                                        </NavLink>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-8 w-full flex justify-center">
                                <Link href="/news" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">お知らせ一覧</Link>
                            </div>
                        </div>
                    </section>
                </div>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="bg-[#FF2D20] rounded-md px-3 py-2 mr-2 text-white"
                    >
                        ログイン
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-[#31adff] rounded-md px-3 py-2 mr-2 text-white"
                    >
                        新規登録
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('admin.login')"
                        class="bg-[#232] rounded-md px-3 py-2 text-white"
                    >
                        管理者ページ
                    </Link>
                </template>
            </nav>
        </div>

    </BasePage>
</template>
