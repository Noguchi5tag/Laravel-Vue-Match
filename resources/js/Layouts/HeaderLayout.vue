<script setup>
import NavLink from '@/Components/NavLink.vue';

</script>

<template>
    <div class="bg-baseColor p-2 flex justify-between items-center">
        <font-awesome-icon :icon="['fas', 'bars']" class="w-5 h-5" />
        <NavLink href="/">JobMatch</NavLink>
        <font-awesome-icon :icon="['far', 'bell']" class="w-5 h-5" />
    </div>
</template>