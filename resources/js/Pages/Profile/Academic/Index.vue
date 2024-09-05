<script setup>
import { Head  } from '@inertiajs/vue3';
import BaseLayouts from '../../../Layouts/BaseLayouts.vue';
import AcademicEdit from './Edit.vue';

const props = defineProps({
    academic_bgs: Array,
})
</script>

<template>
    <Head title="学歴一覧" />
    <BaseLayouts>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">学歴一覧</h2>
        </template>

        <AcademicEdit :academic_bgs="academic_bgs" />

    </BaseLayouts>
</template>