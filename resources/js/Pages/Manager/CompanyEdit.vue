
<script setup>
import { Link, Head, useForm, router  } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/ManagerAuthenticatedLayout.vue';
import { dutyStations } from '@/data';
import { Occupations } from '@/data';

const props = defineProps({
    id: String,
    inertiaJob: Object,
})

const form = useForm({
    id: props.inertiaJob.id,
    companyName: props.inertiaJob.companyName,
    WantedTitles: props.inertiaJob.WantedTitles,
    Occupation: props.inertiaJob.Occupation,
    companyAddress: props.inertiaJob.companyAddress,
    companyPay: props.inertiaJob.companyPay,
    dutyStation: props.inertiaJob.dutyStation,
    workDescription: props.inertiaJob.workDescription,
    payDescription: props.inertiaJob.payDescription,
    travelExpenses: props.inertiaJob.travelExpenses,
    Welfare: props.inertiaJob.Welfare,
    startWork: props.inertiaJob.startWork,
    endWork: props.inertiaJob.endWork,
    workDays: props.inertiaJob.workDays,
    freeDays: props.inertiaJob.freeDays,
    NearestStation: props.inertiaJob.NearestStation,
    workOther: props.inertiaJob.workOther,
    search_keywords: props.inertiaJob.search_keywords,
    status: props.inertiaJob.status,

    image1: null,
    registerd_image1: props.inertiaJob.image1,
    image2: null,
    registerd_image2: props.inertiaJob.image2,
    image3: null,
    registerd_image3: props.inertiaJob.image3,
    image4: null,
    registerd_image4: props.inertiaJob.image4,
    image5: null,
    registerd_image5: props.inertiaJob.image5,

    imageDeleteFlag: {
        image1: false,
        image2: false,
        image3: false,
        image4: false,
        image5: false,
    },
});
// console.log(form.startWork.split(':').slice(0, 2).join(':'));

const deleteImage = (imageKey) => {
    form[imageKey] = null;
    form.imageDeleteFlag[imageKey] = true;
}

const updateFunction = () => {
    // console.log(form);

    router.post(route('manager.company.update', props.inertiaJob.id), {
        _method: 'put',
        companyName: form.companyName,
        WantedTitles: form.WantedTitles,
        Occupation: form.Occupation,
        companyAddress: form.companyAddress,
        companyPay: form.companyPay,
        dutyStation: form.dutyStation,
        workDescription: form.workDescription,
        payDescription: form.payDescription,
        travelExpenses: form.travelExpenses,
        Welfare: form.Welfare,
        startWork: form.startWork,
        endWork: form.endWork,
        workDays: form.workDays,
        freeDays: form.freeDays,
        NearestStation: form.NearestStation,
        workOther: form.workOther,
        search_keywords: form.search_keywords,
        status: form.status,

        image1: form.image1,
        registerd_image1: form.registerd_image1,
        image2: form.image2,
        registerd_image2: form.registerd_image2,
        image3: form.image3,
        registerd_image3: form.registerd_image3,
        image4: form.image4,
        registerd_image4: form.registerd_image4,
        image5: form.image5,
        registerd_image5: form.registerd_image5,

        imageDeleteFlag: form.imageDeleteFlag,
    });
}

const status = form.status;

</script>

<template>
    <Head title="編集フォーム" />
    <AuthenticatedLayout>
        <div class="py-6 max-w-screen-md mx-auto">
            <form @submit.prevent="updateFunction(form.id)" enctype="multipart/form-data">
                <section class=" body-font relative">
                    <div class="container px-4 py-24 mx-auto">
                        <div class="flex flex-col text-center w-full mb-12">
                            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">編集フォーム</h1>
                        </div>
                        <div class="mx-auto">
                            <div class="-m-2">
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyName" class="leading-7 text-sm ">会社名</label>
                                        <input type="text" name="companyName" id="companyName" v-model="form.companyName" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="WantedTitles" class="leading-7 text-sm ">募集タイトル</label>
                                        <input type="text" name="WantedTitles" id="WantedTitles" v-model="form.WantedTitles" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="Occupation" class="leading-7 text-sm ">職種</label>
                                        <select name="Occupation" id="Occupation" v-model="form.Occupation">
                                        <option v-for="occupation in Occupations" :value="occupation.value" :key="occupation.value">
                                            {{ occupation.label }}
                                        </option>
                                    </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyAddress" class="leading-7 text-sm ">会社の住所</label>
                                        <input type="text" name="companyAddress" id="companyAddress" v-model="form.companyAddress" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="companyPay" class="leading-7 text-sm ">給料</label>
                                        <input type="number" name="companyPay" id="companyPay" v-model="form.companyPay" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="dutyStation" class="leading-7 text-sm ">勤務地</label>
                                        <select name="dutyStation" id="dutyStation" v-model="form.dutyStation">
                                            <option v-for="dutyStation in dutyStations" :value="dutyStation.value" :key="dutyStation.value">
                                                {{ dutyStation.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="workDescription" class="leading-7 text-sm ">仕事内容</label>
                                        <input type="text" name="workDescription" id="workDescription" v-model="form.workDescription" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="payDescription" class="leading-7 text-sm ">給与詳細</label>
                                        <input type="text" name="payDescription" id="payDescription" v-model="form.payDescription" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="travelExpenses" class="leading-7 text-sm ">交通費</label>
                                        <input type="number" name="travelExpenses" id="travelExpenses" v-model="form.travelExpenses" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="Welfare" class="leading-7 text-sm ">福利厚生</label>
                                        <input type="text" name="Welfare" id="Welfare" v-model="form.Welfare" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="startWork" class="leading-7 text-sm ">勤務開始時間</label>
                                        <input type="time" name="startWork" id="startWork" v-model="form.startWork" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="endWork" class="leading-7 text-sm ">勤務終了時間</label>
                                        <input type="time" name="endWork" id="endWork" v-model="form.endWork" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="workDays" class="leading-7 text-sm ">出勤日</label>
                                        <input type="text" name="workDays" id="workDays" v-model="form.workDays" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="freeDays" class="leading-7 text-sm ">休日</label>
                                        <input type="text" name="freeDays" id="freeDays" v-model="form.freeDays" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="NearestStation" class="leading-7 text-sm ">最寄り駅</label>
                                        <input type="text" name="NearestStation" id="NearestStation" v-model="form.NearestStation" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="workOther" class="leading-7 text-sm ">その他</label>
                                        <textarea name="workOther" id="workOther" v-model="form.workOther" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="search_keywords" class="leading-7 text-sm ">検索キーワード（カンマ区切り）</label>
                                        <textarea name="search_keywords" id="search_keywords" v-model="form.search_keywords" class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                    </div>
                                </div>

                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="status" class="leading-7 text-sm ">ステータス</label>
                                        <div class="">
                                            <label class="">
                                                <input type="radio" name="status" id="status" value="0" v-model="form.status" required>非公開
                                            </label>
                                            <label class="">
                                                <input type="radio" name="status" id="status" value="1" v-model="form.status" required>公開
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 画像の変更など -->
                                <div v-for="index in 5" :key="`image${index}`" class="p-2 w-full">
                                    <div class="relative">
                                        <label :for="`image${index}`" class="leading-7 text-sm ">サムネ画像{{ index }}</label>
                                        
                                        <template v-if="form[`registerd_image${index}`]">
                                            <div class="mb-2">
                                                <div class="flex justify-between items-center p-2">
                                                    <p>現在設定しているサムネイル画像{{ index }}</p>
                                                    <!-- index が 1 でない場合のみ削除ボタンを表示 -->
                                                    <DangerButton v-if="index !== 1" @click="deleteImage(`image${index}`)">削 除</DangerButton>
                                                </div>
                                                <img :src="`/images/` + form[`registerd_image${index}`]">
                                                <input type="hidden" v-model="form[`registerd_image${index}`]">
                                            </div>
                                        </template>
                                        
                                        <input 
                                            type="file" 
                                            :name="`image${index}`" 
                                            :id="`image${index}`" 
                                            @input="form[`image${index}`] = $event.target.files[0]" 
                                            class="w-full rounded border border-gray-300 focus:border-indigo-500 bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                
                                <div class="p-2 w-full">
                                    <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                </div>
                                <div class="p-2 w-full">
                                    <Link as="button" href="/jobs" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">戻る</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </AuthenticatedLayout>
</template>