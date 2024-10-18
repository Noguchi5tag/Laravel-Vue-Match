<script setup>
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const props = defineProps({
    managers: Array,
});
console.log(props.managers);

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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full table-auto m-4 border-collapse border border-gray-600 bg-white">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2"></th>
                                <th class="border px-4 py-2">会社名</th>
                                <th class="border px-4 py-2">メールアドレス</th>
                                <th class="border px-4 py-2">HP</th>
                                <th class="border px-4 py-2">LINE</th>
                                <th class="border px-4 py-2">電話番号</th>
                                <th class="border px-4 py-2">郵便番号</th>
                                <th class="border px-4 py-2">会社住所</th>
                                <th class="border px-4 py-2">事業</th>
                                <th class="border px-4 py-2">採用担当者</th>
                                <th class="border px-4 py-2">具体的な事業内容</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="mem in props.managers" :key="mem.id" class="whitespace-nowrap">
                                <td class="border px-4 py-2">
                                    <div class="w-16 h-16">
                                        <img v-if="mem.image_manager" class="w-full h-full object-cover rounded-full" :src="`/storage/storages/manager/${mem.image_manager}`" alt="プロフィール画像">
                                        <div v-else class="test-xs">画像無し</div>
                                    </div>
                                </td>
                                <td class="border px-4 py-2">{{ mem.name ? mem.name : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.email ? mem.email : 'データなし' }}</td>
                                <td class="border px-4 py-2"><a :href="`${mem.manager_url}`" target="_blank">{{ mem.manager_url ? mem.manager_url : 'データなし' }}</a></td>
                                <td class="border px-4 py-2">{{ mem.line_url ? mem.line_url : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.tel_manager ? mem.tel_manager : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.manager_address_number ? mem.manager_address_number : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.manager_address ? mem.manager_address : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.business ? mem.business : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.recruit_manager ? mem.recruit_manager : 'データなし' }}</td>
                                <td class="border px-4 py-2">{{ mem.other_manager ? mem.other_manager : 'データなし' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
