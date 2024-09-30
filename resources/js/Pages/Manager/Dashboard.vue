<script setup>
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    tel_manager: user.tel_manager,
    manager_address_number: user.manager_address_number,
    manager_address: user.manager_address,
    business: user.business,
    recruit_manager: user.recruit_manager,
    other_manager: user.other_manager,
});
</script>

<template>
    <Head title="マネージャー情報" />

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
                    <div class="p-6 text-gray-900">
                        <div class="py-2">
                            <InputLabel>名称</InputLabel>
                            <p>{{ form.name }}</p>
                        </div>
                        <div class="py-2">
                            <InputLabel>所在地</InputLabel>
                            <p>〒{{ form.manager_address_number }} {{ form.manager_address }}</p>
                        </div>
                        <div class="py-2">
                            <InputLabel>電話番号</InputLabel>
                            <p>{{ form.tel_manager }}</p>
                        </div>
                        <div class="py-2">
                            <InputLabel>事業内容</InputLabel>
                            <p>{{ form.business }}</p>
                        </div>
                        <div class="py-2">
                            <InputLabel>採用担当</InputLabel>
                            <p>{{ form.recruit_manager }}</p>
                        </div>
                        <InputLabel>その他</InputLabel>
                        <p>{{ form.other_manager }}</p>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
