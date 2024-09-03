<script setup>
import { reactive } from 'vue';
import { Link, Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '../../../Layouts/BaseLayouts.vue';

const props = defineProps({
    user: Object,
})
// console.log(props.user);

const form = reactive({
    skill_name: null,
    skill_experience: null,
});
console.log(form);

//登録処理
const submitFunction = () => {
    Inertia.post(route('skill.store'),{
        skill_name: form.skill_name,
        skill_experience: form.skill_experience,
        user_id: props.user.id,
    });
};
</script>

<template>
<Head title="スキル登録" />
    <BaseLayouts>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">スキル登録</h2>
        </template>

        <div class="py-6">
            <form @submit.prevent="submitFunction">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-4 py-10 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <!-- 消す -->
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="user_id" class="leading-7 text-sm text-gray-600">ID</label>
                                        <input type="text" name="user_id" id="user_id" v-model="props.user.id" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <!-- 消す -->
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="skill_name" class="leading-7 text-sm text-gray-600">スキル名</label>
                                        <input type="text" name="skill_name" id="skill_name" v-model="form.skill_name" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="skill_experience" class="leading-7 text-sm text-gray-600">経験年数</label>
                                        <input type="text" name="skill_experience" id="skill_experience" v-model="form.skill_experience" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </BaseLayouts>
</template>