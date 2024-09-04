<script setup>
import { reactive } from 'vue';
import { Link, Head, useForm  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import BaseLayouts from '../../../Layouts/BaseLayouts.vue';

const props = defineProps({
    skills: Array,
})
console.log(props);

const updateSkill = (skill) => {
    const form = useForm({
        id: skill.id,
        skill_name: skill.skill_name,
        skill_experience: skill.skill_experience,
    });

    form.put(route('skill.update', { skill: skill.id }));
};

const deleteSkill = (skillId) => {
    if (confirm('本当に削除しますか？')) {
        Inertia.delete(route('skill.destroy', { skill: skillId }), {
            onSuccess: () => {
                console.log('Skill deleted successfully');
            },
            onError: () => {
                console.log('There was an error deleting the skill');
            },
        });
    }
};
</script>

<template>
    <Head title="スキル一覧" />
    <BaseLayouts>
            <!-- フラッシュメッセージ -->
            <div v-if="$page.props.flash.message" class="bg-blue-300">
                {{ $page.props.flash.message }}
            </div>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">スキル一覧</h2>
        </template>

        
        <section class="text-gray-600 body-font relative">
            <div class="container px-4 py-10 mx-auto">
                <div class="mx-auto">
                    <div v-for="(skill, index) in props.skills" :key="index" class="-m-2">
                        <div class="p-2 w-full">
                            <hr>
                            <div class="relative mt-2">
                                <label :for="'skill_name_' + index" class="leading-7 text-sm text-gray-600">スキル名</label>
                                <input type="text" :name="'skill_name_' + index" :id="'skill_name_' + index" v-model="skill.skill_name" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>
                        <div class="p-2 w-full mb-2">
                            <div class="relative">
                                <label :for="'skill_experience_' + index" class="leading-7 text-sm text-gray-600">経験年数</label>
                                <input type="number" :name="'skill_experience_' + index" :id="'skill_experience_' + index" v-model="skill.skill_experience" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>
                        <div class="p-2 w-full mb-2 flex justify-between">
                            <button @click.prevent="updateSkill(skill)" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                            <button @click.prevent="deleteSkill(skill.id)" class="flex text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                        </div>
                    </div>
                </div>
                <hr>
                <Link as="button" :href="route('skill.create')" class="flex mx-auto my-2 text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">新しく追加する</Link>
            </div>
        </section>
    </BaseLayouts>
</template>
