<script setup>
import { Head, Link } from '@inertiajs/vue3';

import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <BasePage>
        <SiteTitle>Welcome</SiteTitle>

        <div class="my-10 text-center">
            <nav v-if="canLogin" class="">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    ダッシュボードへ
                </Link>

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
                        class="bg-[#31adff] rounded-md px-3 py-2 text-white"
                    >
                        新規登録
                    </Link>
                </template>
            </nav>
        </div>

    </BasePage>
</template>
