<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';

const page = usePage();
const applicants = page.props.applicants;
console.log(applicants);

const isMenuOpen = ref(false);
const closeMenu = () => {
    isMenuOpen.value = false;
}

const isBellOpen = ref(false);

// 日付フォーマット関数
function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = ('0' + (date.getMonth() + 1)).slice(-2); // 月は0から始まるため +1
    const day = ('0' + date.getDate()).slice(-2);
    
    return `${year}年${month}月${day}日`;
}

const isPopupOpen = ref(false);
const selectedApplicant = ref(null); // 選択された応募者のデータ
// マッチング情報表示処理
function matchView(applicant) {
    selectedApplicant.value = applicant; // 選択された応募者のデータをセット
    isPopupOpen.value = true; // ポップアップを表示
}

const closePopup = () => {
    isPopupOpen.value = false;
}
</script>

<template>
    <div class="fixed top-0 left-1/2 -translate-x-1/2 z-10 w-full max-w-sm">
        <div class= "bg-baseColor p-2 flex justify-between items-center">
            <button class="w-10 h-10 py-3 px-2 relative" @click="isMenuOpen = !isMenuOpen">
                <div class="w-full h-full flex flex-col justify-between items-center">
                    <span class="block w-full h-[2px] bg-black"></span>
                    <span class="block w-full h-[2px] bg-black"></span>
                    <span class="block w-full h-[2px] bg-black"></span>
                </div>
            </button>
            <NavLink href="/">JobMatch</NavLink>
            <div @click="isBellOpen = !isBellOpen" class="w-5 h-5">
                <font-awesome-icon :icon="['far', 'bell']" class="w-full h-full" />
            </div>
        </div>
        <!-- ハンバーガー -->
        <div v-if="isMenuOpen" class="fixed top-0 left-0 w-full h-screen bg-white z-50 shadow-lg flex flex-col p-6 transition-all duration-200">
            <div class="flex justify-end">
                <button @click="closeMenu" class="text-customBlue text-3xl font-bold">&times;</button>
            </div>
            <ul class="text-base space-y-2 mt-6">
                <li><NavLink as="button" href="/questions" class="pt-3 pb-3 border-t-2 border-baseColor font-bold">よくある質問</NavLink></li>
                <li><NavLink as="button" href="/site-details" class="pt-3 pb-3 border-t-2 border-baseColor font-bold">このサイトについて</NavLink></li>
                <li><NavLink as="button" href="/rules" class="pt-3 pb-3 border-baseColor font-bold">利用規約</NavLink></li>
                <li><NavLink as="button" href="/privacy" class="pt-3 pb-3 border-baseColor font-bold">プライバシーポリシー</NavLink></li>
                <li><NavLink as="button" href="/jobpostings" class="pt-3 pb-3 border-baseColor font-bold">求人掲載をお考えの方へ</NavLink></li>
                <li><NavLink as="button" href="/contact" class="pt-3 pb-3 border-baseColor font-bold">お問い合わせ</NavLink></li>
            </ul>
        </div>

        <!-- ベル -->
        <div v-if="isBellOpen" class="fixed h-screen top-14 right-0 w-full  bg-white flex flex-col transition-all duration-200">
            <div class="text-sm text-center font-bold py-4 bg-baseColor shadow-md">お知らせ</div>
            <div class="flex-1 overflow-y-auto">
                <ul class="text-base space-y-2">
    
                    <li v-for="(applicant, index) in applicants" :key="applicant.id" @click="matchView(applicant)" class="p-2 cursor-pointer border-b-2 border-baseColor">
    
                        <div v-if="applicant.liked !== 0" class="flex gap-4 items-center">
                            <img class="w-16 h-16 object-cover rounded-lg border-2 border-baseColor" :src="`/storage/storages/jobs/${ applicant?.job.image1 }`" alt="求人画像">
                            <div class="">
                                <span class="text-xs">{{ formatDate(applicant.updated_at) }}</span>
                                <p class="text-sm font-bold">{{ applicant.company_name }}とマッチングしました！</p>
                                <span class="text-xs">求人タイトル：{{ applicant.job.WantedTitles }}</span>
                            </div>
                        </div>
                        <div v-else>
                            <div class="text-sm text-center">マッチング無し</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ポップアップ -->
        <div v-if="isPopupOpen" class="fixed inset-0 h-screen bg-black bg-opacity-50 z-50 flex  flex-col justify-center items-center">
            <div class="w-4/5 bg-white p-2 pt-6 rounded-lg shadow-lg">
                <div class="flex flex-col justify-center items-center">
                    <p class="text-xs font-bold">{{ selectedApplicant?.company_name }}</p>
                    <img class="w-16 h-16 mt-2 object-cover rounded-full" :src="`/storage/storages/jobs/${ selectedApplicant?.job.image1 }`" alt="プロフィール画像">
                    <p class="text-xs font-bold mt-2">{{ selectedApplicant?.job.WantedTitles }}</p>
                    <h2 class="mt-4 text-sky-400 font-bold text-2xl">お互いのいいね！</h2>
                    <p class="font-bold text-base">が成立しました。</p>

                    <div class="bg-sky-100 mt-4 w-full p-4 rounded-b-lg">
                        <p class="font-bold text-center text-base">マッチングした企業に<br>早速メッセージを送ってみましょう！</p>
                        <Link href="#" class="rounded-full bg-green-500 flex items-center justify-center mt-4">
                            <img class="w-10 h-10" src="../../../public/images/logo/LINE_logo.png" alt="LINE">
                            <p class="text-white text-sm">友達追加してメッセージを送る</p>
                        </Link>
                        <div class="mt-4 flex flex-col gap-4">
                            <p class="text-xs text-center">- 他の方法で連絡をする -</p>
                            <div class="flex justify-around items-center">
                                <div class="text-xs rounded-full bg-white py-1 w-24 text-center border-2 border-gary-200">電話をかける</div>
                                <div class="text-xs rounded-full bg-white py-1 w-24 text-center border-2 border-gary-200">メールを送る</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="rounded-full border-2 border-white text-center mx-auto mt-4 px-8 py-2 text-xs text-white" @click="closePopup">閉じる</button>
        </div>
    </div>
</template>