<script setup>
import { ref, computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import NavLink from '@/Components/NavLink.vue';

const page = usePage();
const applicants = page.props.applicants;
const news = page.props.news;
const user = page.props.auth.user;

const isMenuOpen = ref(false);
const closeMenu = () => {
    isMenuOpen.value = false;
}

const isReadCount = ref(0);
const isBellOpen = ref(false);

// applicantsとnewsを結合し、updated_atで降順にソート
const combinedData = computed(() => {
    const combined = [...applicants, ...news].map(item => ({
        ...item,
        isRead: false
    }));
    return combined.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
});

// 通知数に表示
const likedCount = computed(() => {
    const likedApplicantsCount = applicants.filter(applicant => applicant.liked === 1).length;
    const newsCount = news.length;
    return likedApplicantsCount + newsCount - isReadCount.value;
});

// 日付フォーマット関数
function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = ('0' + (date.getMonth() + 1)).slice(-2); // 月は0から始まるため +1
    const day = ('0' + date.getDate()).slice(-2);
    
    return `${year}年${month}月${day}日`;
}

const isApplicantPopupOpen = ref(false);
const isNewsPopupOpen = ref(false);
const selectedApplicant = ref(null); // 選択された応募者のデータ
const selectedNews = ref(null); // 選択された応募者のデータ

// マッチング情報表示処理
function matchView(applicant) {
    // 選択された応募者のデータをセット
    selectedApplicant.value = applicant; 
    selectedNews.value = null;
    isApplicantPopupOpen.value = true; // ポップアップを表示

    const clickedItem = combinedData.value.find(item => item.id === applicant.id);
    if (clickedItem) {
        clickedItem.isRead = true;
        isReadCount.value = isReadCount.value + 1;
    }
}
// ニュース表示処理
function newsView(newsItem) {
    selectedNews.value = newsItem;
    selectedApplicant.value = null;
    isNewsPopupOpen.value = true;

    const clickedItem = combinedData.value.find(item => item.id === newsItem.id);
    if (clickedItem) {
        clickedItem.isRead = true;
        isReadCount.value = isReadCount.value + 1;
    }
}

const closePopup = () => {
    isApplicantPopupOpen.value = false;
    isNewsPopupOpen.value = false;
    selectedApplicant.value = null;
    selectedNews.value = null;
}

// noticed を 0 から 1 にする
function updateNoticed(applicantId) {
    Inertia.post(`/applicants/${applicantId}/noticed`, {
        noticed: 1
    }, {
        onSuccess: () => {
            closePopup(); // ポップアップを閉じる
        },
        onError: (errors) => {
            console.error('通知の更新に失敗しました', errors);
        }
    });
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
            <div v-if="user && user.privacy !== 0" @click="isBellOpen = !isBellOpen" class="relative w-5 h-5 mr-1">
                <font-awesome-icon :icon="['far', 'bell']" class="w-full h-full cursor-pointer" />
                <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                    {{ likedCount }}
                </span>
            </div>
            <div v-else class="relative w-5 h-5 mr-1">
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
                <ul class="text-base">
                    <li 
                        v-for="(item, index) in combinedData" 
                        :key="item.id" 
                        @click="item.job ? matchView(item) : newsView(item)" 
                        :class="['p-2 cursor-pointer border-b-2 border-baseColor', { 'bg-yellow-50': !item.isRead }]"
                    >
                        <!-- 応募者の場合 -->
                        <div v-if="item.job" class="flex gap-4 items-center">
                            <img class="w-16 h-16 object-cover rounded-lg border-2 border-baseColor" :src="`/storage/storages/jobs/${ item?.job.image1 }`" alt="求人画像">
                            <div>
                            <span class="text-xs">{{ formatDate(item.updated_at) }}</span>
                            <p class="text-sm font-bold">{{ item.company_name }}とマッチングしました！</p>
                            <span class="text-xs">求人タイトル：{{ item.job.WantedTitles }}</span>
                            </div>
                        </div>

                        <!-- ニュースの場合 -->
                        <div v-else-if="!item.job" class="flex gap-4 items-center">
                            <div>
                            <span class="text-xs">{{ formatDate(item.updated_at) }}</span>
                            <p class="text-sm font-bold">{{ item.title }}</p>
                            <span class="text-xs">{{ item.content.length > 50 ? item.content.slice(0, 50) + '...' : item.content }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ポップアップ -->
        <div v-if="isApplicantPopupOpen" class="fixed inset-0 h-screen bg-black bg-opacity-50 z-50 flex  flex-col justify-center items-center">
            <div class="w-4/5 bg-white p-2 pt-6 rounded-lg shadow-lg">
                <div class="flex flex-col justify-center items-center">
                    <p class="text-xs font-bold">{{ selectedApplicant?.company_name }}</p>
                    <img v-if="selectedApplicant.manager.image_manager" class="w-16 h-16 mt-2 object-cover rounded-full" :src="`/storage/storages/manager/${ selectedApplicant?.manager.image_manager }`" alt="プロフィール画像">
                    <p class="text-xs font-bold mt-2">募集タイトル<br>{{ selectedApplicant?.job.WantedTitles }}</p>
                    <h2 class="mt-4 text-sky-400 font-bold text-2xl">お互いのいいね！</h2>
                    <p class="font-bold text-base">が成立しました。</p>

                    <div class="bg-sky-100 mt-4 w-full p-4 rounded-b-lg">
                        <p class="font-bold text-center text-base">マッチングした企業に<br>早速メッセージを送ってみましょう！</p>
                        <template v-if="selectedApplicant.manager.line_url">
                            <a 
                                :href=" selectedApplicant.manager.line_url " 
                                target="_blank"
                                class="rounded-full bg-green-500 flex items-center justify-center mt-4"
                            >
                                <img class="w-10 h-10" src="../../../public/images/logo/LINE_logo.png" alt="LINE">
                                <p class="text-white text-sm">友達追加してメッセージを送る</p>
                            </a>
                        </template>
                        <div class="mt-4 flex flex-col gap-4">
                            <p class="text-xs text-center">- 他の方法で連絡をする -</p>
                            <div class="flex justify-around items-center">
                                <a 
                                    v-if="selectedApplicant.manager.tel_manager" 
                                    :href="`tel:${selectedApplicant.manager.tel_manager}`"
                                    class="text-xs rounded-full bg-white py-1 w-24 text-center border-2 border-gary-200">
                                    電話をかける
                                </a>
                                <a 
                                    v-if="selectedApplicant.manager.email"
                                    :href="`mailto:${selectedApplicant.manager.email}`" 
                                    class="text-xs rounded-full bg-white py-1 w-24 text-center border-2 border-gary-200">
                                    メールを送る
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-6 mt-4">
                <button class="rounded-full border-2 border-white text-center mx-auto px-8 py-2 text-xs text-white" @click="updateNoticed(selectedApplicant.id)">通知から削除</button>
                <button class="rounded-full border-2 border-white text-center mx-auto px-8 py-2 text-xs text-white" @click="closePopup">閉じる</button>
            </div>
        </div>

        <!-- ニュースポップアップ -->
        <div v-if="isNewsPopupOpen" class="fixed inset-0 h-screen bg-black bg-opacity-50 z-50 flex  flex-col justify-center items-center">
            <div class="w-4/5 bg-white p-4 pt-4 rounded-lg shadow-lg">
                <div class="flex flex-col gap-2 justify-center items-center">
                    <p class="text-base font-bold">{{ selectedNews?.title }}</p>
                    <p class="text-xs">{{ formatDate(selectedNews?.updated_at) }}</p>
                    <p class="text-sm">{{ selectedNews?.content }}</p>
                </div>
            </div>

            <div class="flex gap-6 mt-4">
                <button class="rounded-full border-2 border-white text-center mx-auto px-8 py-2 text-xs text-white" @click="closePopup">閉じる</button>
            </div>
        </div>
    </div>
</template>