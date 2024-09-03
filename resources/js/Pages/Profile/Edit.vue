<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import LogoutUserForm from './Partials/LogoutUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import Skill from './Partials/Skill.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, Link } from '@inertiajs/vue3';
import BasePage from '../../Layouts/BaseLayouts.vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: Object,
    hasSkill: Boolean,
})

console.log(props);

const routeName = props.hasSkill ? 'skill.edit' : 'skill.create';
const routeParams = props.hasSkill ? { skill: skillId } : {};
// console.log(routeParams);
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

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="space-y-6">
                        <Link :href="route(routeName, routeParams)" as="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-15">
                            スキル登録・編集
                        </Link>
                    </section>
                </div>

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
