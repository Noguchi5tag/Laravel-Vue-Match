<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import FooterMenu from '../Components/Button/FotterMenu.vue';
import NavLink from '@/Components/NavLink.vue';

const { props } = usePage();
const isLoggedIn = props.auth.user !== null;
</script>

<template>
    <p class="text-center text-xs">© 2024 FIVE TAG PLUS</p>

    <template v-if="isLoggedIn">
        <div class="pb-12"></div>
    </template>
    
    <FooterMenu />
</template>