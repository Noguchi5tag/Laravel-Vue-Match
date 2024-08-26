<script setup>
import { Head } from '@inertiajs/vue3';
import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';

</script>

<template>
    <Head title="利用規約" />
    <BasePage>
        <SiteTitle>利用規約</SiteTitle>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 pb-24 mx-auto">
                <p>ここに利用規約を明記</p>
            </div>
        </section>
    </BasePage>
</template>