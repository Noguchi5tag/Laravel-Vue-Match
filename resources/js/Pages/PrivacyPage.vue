<script setup>
import { Head } from '@inertiajs/vue3';
import BasePage from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';

</script>

<template>
    <Head title="プライバシーポリシー" />
    <BasePage>
        <SiteTitle>プライバシーポリシー</SiteTitle>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 pb-24 mx-auto">
                <p>ここにプライバシーポリシーを明記</p>
            </div>
        </section>
    </BasePage>
</template>