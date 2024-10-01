<script setup>
import { reactive } from 'vue';
import { Head  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';

const form = reactive({
    title: '',
    content: '',
});

//登録処理
const submitFunction = () => {
    Inertia.post(route('admin.news.store'), form);
}
</script>

<template>
<Head title="お知らせ登録" />
    <AuthenticatedLayout>
        <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">お知らせ登録</h2>
    </template>
    <!-- フラッシュメッセージ -->
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>
        <div class="py-6">
            <form @submit.prevent="submitFunction">
                <section class=" body-font relative">
                    <div class="container px-4 py-24 mx-auto">
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="title" class="leading-7 text-sm ">タイトル</InputLabel>
                                        <TextInput type="text" name="title" id="title" v-model="form.title" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <InputLabel for="content" class="leading-7 text-sm ">内容</InputLabel>
                                        <textarea name="content" id="content" v-model="form.content" required class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
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
    </AuthenticatedLayout>
</template>