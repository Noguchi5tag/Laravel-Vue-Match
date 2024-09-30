<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

//ログインしているかどうかの処理
const { props } = usePage();
const isLoggedIn = props.auth.user !== null;

//Adminでログインしているかどうかの処理
const isAdmin = ref(false);
onMounted(() => {
    const currentUrl = window.location.pathname;
    isAdmin.value = currentUrl.includes('/admin/');
});
</script>

<template>
    <div v-if="isLoggedIn" class="py-2 shadow-tw-shadow-top bg-white fixed bottom-0 max-w-sm w-full h-auto">
        <div class="flex justify-around items-center">
            <Link as="button" href="/" class="flex flex-col items-center">
                <font-awesome-icon :icon="['fas', 'house']" class="w-5 h-5" />
            </Link>
            <Link as="button" href="/search" class="flex flex-col items-center">
                <font-awesome-icon :icon="['fas', 'magnifying-glass']"  class="w-5 h-5" />
            </Link>
            <Link as="button" href="/applied-list" class="flex flex-col items-center">
                <font-awesome-icon :icon="['fas', 'thumbs-up']"  class="w-5 h-5" />
            </Link>
            <Link as="button" href="/applied-list" class="flex flex-col items-center">
                <font-awesome-icon :icon="['far', 'bookmark']" class="w-5 h-5" />
            </Link>
            <Link as="button" href="/profile" class="flex flex-col items-center">
                <font-awesome-icon :icon="['far', 'circle-user']" class="w-5 h-5" />
            </Link>
        </div>
    </div>
</template>