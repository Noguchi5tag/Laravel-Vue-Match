<script setup>
function goBack() {
    window.history.back(); // 1つ前のページに戻る
}
</script>

<template>
    <div class="bg-gray-200 p-4">
        <!-- <div class="flex">
            <div class="cursor-pointer" @click="goBack">＜</div>
            <p class="">仕事マッチングサイト</p>
        </div> -->
        <div class="text-center">
            <h3>仕事マッチングサイト</h3>
        </div>
    </div>

</template>