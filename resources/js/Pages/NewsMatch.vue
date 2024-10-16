<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';

const page = usePage();
const applicants = page.props.applicants;
console.log(applicants);
</script>

<template>
    <Head title="マッチング" />
    <BaseLayouts>
        <section class="">
            
        </section>
    </BaseLayouts>
</template>