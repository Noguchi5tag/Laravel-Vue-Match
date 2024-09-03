<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">スキル編集・更新</h2>
        </header>
        <Link :href="route('skill.index')" as="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-15">
            スキル編集・更新
        </Link>
    </section>
</template>