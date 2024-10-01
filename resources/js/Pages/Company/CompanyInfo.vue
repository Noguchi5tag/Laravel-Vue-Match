<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import { defineProps } from 'vue';

const props = defineProps({
    managers: Object,
});
</script>

<template>
    <div v-if="managers" class="mt-6">
        <div class="bg-stone-50 -mx-4 py-4">
            <InputLabel class="pl-4">企業情報</InputLabel>
            <div class="mx-4 my-2 px-4 bg-white">
                <template v-for="manager in managers" :key="manager.id">
                    <div class="flex gap-4 py-4 border-b-2 border-stone-50">
                        <img class="w-12 h-12 object-cover rounded-full" :src="`/storage/storages/${ manager.image_manager }`" alt="プロフィール画像">
                        <div class="flex flex-col justify-center">
                            <h3 class="text-base font-bold">{{ manager.name }}</h3>
                            <a v-if="manager.manager_url" :href="manager.manager_url" class="text-sm" target="_blank">{{ manager.manager_url }}</a>
                        </div>
                    </div>
                    <div class="py-4 flex flex-col gap-2">
                        <div class="">
                            <InputLabel>名称</InputLabel>
                            <p class="text-xs leading-loose">{{ manager.name }}</p>
                        </div>
                        <div class="">
                            <InputLabel>所在地</InputLabel>
                            <p class="text-xs leading-loose">〒{{ manager.manager_address_number }}　{{ manager.manager_address }}</p>
                        </div>
                        <div class="">
                            <InputLabel>電話番号</InputLabel>
                            <p class="text-xs leading-loose">{{ manager.tel_manager }}</p>
                        </div>
                        <div class="">
                            <InputLabel>事業内容</InputLabel>
                            <p class="text-xs leading-loose">{{ manager.business }}</p>
                        </div>
                        <div class="">
                            <InputLabel>採用担当</InputLabel>
                            <p class="text-xs leading-loose">{{ manager.recruit_manager }}</p>
                        </div>
                        <div class="">
                            <InputLabel>その他</InputLabel>
                            <p class="text-xs leading-loose">{{ manager.other_manager }}</p>
                        </div>
                    </div>

                </template>
            </div>
        </div>
    </div>
</template>

<style>

</style>