<script setup>
import { Head } from '@inertiajs/vue3';

import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';

</script>

<template>
    <Head title="Test" />

    <BasePage>
        <SiteTitle>テスト</SiteTitle>

    </BasePage>
</template>
