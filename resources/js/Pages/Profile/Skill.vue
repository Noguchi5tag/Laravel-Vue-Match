<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Head, useForm, router  } from '@inertiajs/vue3';
import BaseLayouts from '@/Layouts/BaseLayouts.vue';

const props = defineProps({
    skill: Object,
})
// console.log(props.skill);

const form = useForm({
    id: props.skill.id,
    skill_name: props.skill.skill_name,
    skill_experience: props.skill.skill_experience,
});
console.log(form.id);

//登録処理
const submitFunction = () => {
    form.put(route('skill.update',  { skill: props.skill.id }));
}
</script>

<template>
<Head title="スキル" />
    <BaseLayouts>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">スキル</h2>
        </template>

        <div class="py-6">
            <form @submit.prevent="submitFunction">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="skill_name" class="leading-7 text-sm text-gray-600">スキル名</label>
                                        <input type="text" name="skill_name" id="skill_name" v-model="form.skill_name" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="skill_experience" class="leading-7 text-sm text-gray-600">経験年数</label>
                                        <input type="number" name="skill_experience" id="skill_experience" v-model="form.skill_experience" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <button type="submit" :disabled="form.processing" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </BaseLayouts>
</template>