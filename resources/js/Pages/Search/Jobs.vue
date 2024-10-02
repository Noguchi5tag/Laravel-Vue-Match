<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import BaseLayouts from '../../Layouts/BaseLayouts.vue';
import SectionInner from '../../Layouts/SectionInner.vue';
import SiteTitle from '@/Components/SiteTitle.vue';
import { Occupations } from '@/data';

const Occupation = ref([]);

const saveJobs = () => {
    localStorage.setItem('selectedOccupations', JSON.stringify(Occupation.value));
    window.history.back();
};
</script>

<template>
    <Head title="職種選択" />
    <BaseLayouts>
        <SiteTitle>職業選択</SiteTitle>
        <SectionInner>
            <div id="Occupation" class="flex flex-wrap">
                <div v-for="occupation in Occupations" :key="occupation.value" class="mr-4 mb-2">
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            :value="occupation.value" 
                            v-model="Occupation" 
                            class="form-checkbox h-5 w-5 transition duration-150 ease-in-out"
                        />
                        <span class="ml-2">{{ occupation.label }}</span>
                    </label>
                </div>
            </div>
            <div class="mt-4">
                <button @click="saveJobs" class="bg-blue-500 text-white py-2 px-4 rounded">
                    保存して戻る
                </button>
            </div>
        </SectionInner>
    </BaseLayouts>
</template>
