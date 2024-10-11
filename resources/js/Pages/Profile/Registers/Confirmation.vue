<script setup>
import { Head, router } from '@inertiajs/vue3';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted  } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import DeleteUserForm from '../Partials/DeleteUserForm.vue';
import LogoutUserForm from '../Partials/LogoutUserForm.vue';
import UpdatePasswordForm from '../Partials/UpdatePasswordForm.vue';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';
import SectionInner from '@/Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

import PersonalShow from '../Personal/Show.vue';
import AcademicShow from '../Academic/Show.vue';
import JobsShow from '../Jobs/Show.vue';
import RequirementsShow from '../Requirements/Show.vue';

const user = usePage().props.auth.user;

const props = defineProps({
    academic_bg: {
        type: Object,
    },
    job_bg: {
        type : Object,
    },
    job_requirements: {
        type : Object,
    },
});

const form = useForm({
    privacy: user.privacy
});


const privacyChecked = ref(false);

const handleRegistration = () => {
    form.privacy = 1;
    form.put(route('profile.update'), {
        onSuccess: () => {
            alert('登録が完了しました。');
            router.visit(route('company.index'));
        },
        onError: (errors) => {
            console.error('エラーが発生しました:', errors);
        }
    });
};
</script>

<template>
    <Head title="内容確認" />
    <BaseLayouts>
        <SiteTitle class="bg-baseColor">利用登録の入力内容確認</SiteTitle>
        
        <FlashMessage v-if="$page.props.flash.message" >
            {{ $page.props.flash.message }}
        </FlashMessage>

        <SectionInner class="my-6 px-4">

            <PersonalShow />

            <AcademicShow :academic_bg="academic_bg" />

            <JobsShow :job_bg="job_bg" :academic_bg="academic_bg" />

            <RequirementsShow :job_requirements="job_requirements" />

            <div class="flex flex-col gap-4 my-4 border-t-2 border-baseColor pt-4">
                <UpdatePasswordForm />
    
                <LogoutUserForm />
    
                <DeleteUserForm />
            </div>

            <template v-if="form.privacy === 0">
                <div class="bg-baseColor p-4 mt-4 rounded-lg">
                    <div class="text-xs font-bold mb-4">利用登録に関する個人情報保護方針・利用規約</div>
                    <div class="h-36 overflow-y-auto">
                        <div class="mb-4">
                            <div class="mb-2 text-xs font-bold" >1.個人情報保護法に関するコンプライアンス・プログラムの策定</div>
                            <div class="text-xs opacity-50">
                                当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざんおよび漏洩などのリスクを防衛し、個人情報の適切な取り扱いと運用のための基準、ルール、手順などを定めたコンプライアンス・プログラムを策定し、実施します。
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="mb-2 text-xs font-bold" >1.個人情報保護法に関するコンプライアンス・プログラムの策定</div>
                            <div class="text-xs opacity-50">
                                当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざんおよび漏洩などのリスクを防衛し、個人情報の適切な取り扱いと運用のための基準、ルール、手順などを定めたコンプライアンス・プログラムを策定し、実施します。
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="mb-2 text-xs font-bold" >1.個人情報保護法に関するコンプライアンス・プログラムの策定</div>
                            <div class="text-xs opacity-50">
                                当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざんおよび漏洩などのリスクを防衛し、個人情報の適切な取り扱いと運用のための基準、ルール、手順などを定めたコンプライアンス・プログラムを策定し、実施します。
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="my-2 flex justify-center items-center gap-2 mt-4">
                    <input 
                        type="checkbox" 
                        name="currently_working" 
                        id="currently_working" 
                        v-model="privacyChecked"
                        class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                    <p class="text-xs leading-normal tracking-wider">上記の個人情報保護方針に同意する</p>
                </div> 
    
                <div v-if="privacyChecked === true " class="flex flex-col items-center gap-4 py-2">
                    <PrimaryButton @click="handleRegistration">この内容で利用登録</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                    </Transition>
                </div>
            </template>

        </SectionInner>
    </BaseLayouts>
</template>