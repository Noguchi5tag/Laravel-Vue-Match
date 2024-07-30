<template>
    <!-- 子コンポーネントで、slug="/リンク先指定" -->
    <Link :href="slug" class="block w-56 text-center my-0 mx-auto rounded-xl bg-sky-400 text-white py-2"><slot /></Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps(['slug'])

</script>