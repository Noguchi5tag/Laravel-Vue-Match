<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import LogoutUserForm from './Partials/LogoutUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import SkillCreate from './Partials/SkillCreate.vue';
import SkillUpdate from './Partials/SkillUpdate.vue';
import AcademicCreate from './Partials/AcademicCreate.vue';
import AcademicUpdate from './Partials/AcademicUpdate.vue';
import JobBgCreate from './Partials/JobBgCreate.vue';
import JobBgUpdate from './Partials/JobBgUpdate.vue';
import { Head, Link } from '@inertiajs/vue3';

import BasePage from '../../Layouts/BaseLayouts.vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    hasSkill: {
        type: Boolean,
    },
    userAuth: {
        type: Object,
    },
    hasAcademicBg: {
        type: Boolean,
    },
    hasJobBg: {
        type: Boolean,
    },
});
console.log(props.hasJobBg);
</script>

<template>
    <Head title="プロフィール" />

    <BasePage>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">プロフィール</h2>
        </template>

        <!-- フラッシュメッセージ -->
        <div v-if="$page.props.flash.message" class="bg-blue-300">
            {{ $page.props.flash.message }}
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-6 space-y-2">

                <template v-if="props.hasSkill === false">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <SkillCreate class="max-w-xl" />
                    </div>
                </template>
                <template v-else>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <SkillUpdate class="max-w-xl" />
                    </div>
                </template>

                <template v-if="props.hasAcademicBg === false">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <AcademicCreate class="max-w-xl" />
                    </div>
                </template>
                <template v-else>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <AcademicUpdate class="max-w-xl" />
                    </div>
                </template>

                <template v-if="props.hasJobBg === false">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <JobBgCreate class="max-w-xl" />
                    </div>
                </template>
                <template v-else>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <JobBgUpdate class="max-w-xl" />
                    </div>
                </template>

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
