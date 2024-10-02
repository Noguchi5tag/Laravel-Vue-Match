<script setup>
import { Head } from '@inertiajs/vue3';
import BaseLayouts from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';


import { ref, computed } from 'vue';

// 質問データの準備（例）
const questions = ref([
  { id: 1, text: '質問1' },
  { id: 2, text: '質問2' },
  { id: 3, text: '質問3' },
  { id: 4, text: '質問4' },
  { id: 5, text: '質問5' },
  { id: 6, text: '質問6' },
  { id: 7, text: '質問7' },
  { id: 8, text: '質問8' },
  { id: 9, text: '質問9' },
  { id: 10, text: '質問10' },
  { id: 11, text: '質問11' },
  { id: 12, text: '質問12' },
  { id: 13, text: '質問13' },
  { id: 14, text: '質問14' },
  { id: 15, text: '質問15' },
  { id: 16, text: '質問16' },
  { id: 17, text: '質問17' },
  { id: 18, text: '質問18' },
  { id: 19, text: '質問19' },
  { id: 20, text: '質問20' }
]);

const currentPage = ref(1);
const itemsPerPage = 5;

// ページごとの質問データを計算
const paginatedQuestions = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return questions.value.slice(start, end);
});

// 総ページ数を計算
const totalPages = computed(() => Math.ceil(questions.value.length / itemsPerPage));

// 次のページへ移動
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

// 前のページへ移動
const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};
</script>

<template>
    <Head title="Test" />

    <BaseLayouts>
        <SiteTitle>テスト</SiteTitle>

        <div>
            <!-- 質問の表示 -->
            <div v-for="question in paginatedQuestions" :key="question.id" class="p-2">
            <p>{{ question.text }}</p>
            </div>

            <!-- ページネーションコントロール -->
            <div class="flex justify-center mt-4">
            <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-300 rounded-l">
                前へ
            </button>
            <span class="px-4 py-2 bg-gray-100">{{ currentPage }} / {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-gray-300 rounded-r">
                次へ
            </button>
            </div>
        </div>

    </BaseLayouts>
</template>
