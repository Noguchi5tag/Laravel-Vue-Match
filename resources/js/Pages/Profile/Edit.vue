<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import LogoutUserForm from './Partials/LogoutUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, Link } from '@inertiajs/vue3';

import BasePage from '../../Layouts/BaseLayouts.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="プロフィール" />

    <BasePage>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">プロフィール</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-6 space-y-2">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <LogoutUserForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </BasePage>
</template>
