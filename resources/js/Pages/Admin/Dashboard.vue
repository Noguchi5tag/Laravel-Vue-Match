<script setup>
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});


</script>

<template>
    <Head title="管理者情報" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ form.name }}</h2>
        </template>

        <!-- フラッシュメッセージ -->
        <div v-if="$page.props.flash.message" class="bg-blue-300">
            {{ $page.props.flash.message }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">管理者でログイン</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
