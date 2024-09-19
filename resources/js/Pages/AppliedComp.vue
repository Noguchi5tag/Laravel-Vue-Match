<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BaseLayouts from '../Layouts/BaseLayouts.vue';
</script>

<template>
    <Head title="応募完了" />
    <BaseLayouts>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">応募完了</h2>

            <Link as="button" :href="route('company.index')" class="">トップへ</Link>
    </BaseLayouts>
</template>