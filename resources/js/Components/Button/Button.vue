<template>
    <!-- 子コンポーネントで、slug="/リンク先指定" -->
    <router-link :to="slug" class="block w-56 text-center my-0 mx-auto rounded-xl bg-sky-400 text-white py-2"><slot></slot></router-link>
</template>

<script setup>
defineProps(['slug'])

</script>