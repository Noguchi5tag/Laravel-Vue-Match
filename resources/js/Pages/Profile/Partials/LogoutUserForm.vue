<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const confirmLogout = (event) => {
    if (!confirm("本当にログアウトしますか？")) {
        event.preventDefault();
    } else {
        Inertia.post(route('logout'));
    }
};
</script>

<template>
    <section>
        <button 
            @click="confirmLogout"
            class="inline-flex items-center text-sm uppercase tracking-widest transition ease-in-out duration-15">
            ログアウトする
        </button>
    </section>
</template>