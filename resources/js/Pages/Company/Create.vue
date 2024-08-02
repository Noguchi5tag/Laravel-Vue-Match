<script setup>
import { reactive } from 'vue';
import { router, Link  } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const form = reactive({
    companyName: '',
    WantedTitles: '',
    Occupation: '',
    companyAddress: '',
    companyPay: '',
    dutyStation: '',
    workDescription: '',
    payDescription: '',
    travelExpenses: '',
    Welfare: '',
    startWork: '',
    endWork: '',
    workDays: '',
    freeDays: '',
    NearestStation: '',
    workOther: ''
});

const submitFunction = () => {
    Inertia.post('/company/job', form);
}
</script>

<template>
    <h1 class="text-xl">登録フォーム</h1>
    <div class="py-6">
        <form @submit.prevent="submitFunction">
            <label for="companyName">会社名:</label>
            <input type="text" id="companyName" v-model="form.companyName" /><br>
    
            <label for="WantedTitles">募集タイトル:</label>
            <input type="text" id="WantedTitles" v-model="form.WantedTitles" /><br>
    
            <label for="Occupation">職種:</label>
            <input type="text" id="Occupation" v-model="form.Occupation" /><br>
    
            <label for="companyAddress">会社の住所:</label>
            <input type="text" id="companyAddress" v-model="form.companyAddress" /><br>
    
            <label for="companyPay">給料:</label>
            <input type="number" id="companyPay" v-model="form.companyPay" /><br>
    
            <label for="dutyStation">勤務地:</label>
            <input type="text" id="dutyStation" v-model="form.dutyStation" /><br>
    
            <label for="workDescription">仕事内容:</label>
            <input type="text" id="workDescription" v-model="form.workDescription" /><br>
    
            <label for="payDescription">給与詳細:</label>
            <input type="text" id="payDescription" v-model="form.payDescription" /><br>
    
            <label for="travelExpenses">交通費:</label>
            <input type="number" id="travelExpenses" v-model="form.travelExpenses" /><br>
    
            <label for="Welfare">福利厚生:</label>
            <input type="text" id="Welfare" v-model="form.Welfare" /><br>
            
            <label for="startWork">勤務開始時間:</label>
            <input type="number" id="startWork" v-model="form.startWork" /><br>
    
            <label for="endWork">勤務終了時間:</label>
            <input type="number" id="endWork" v-model="form.endWork" /><br>
    
            <label for="workDays">出勤日:</label>
            <input type="text" id="workDays" v-model="form.workDays" /><br>
    
            <label for="freeDays">休日:</label>
            <input type="text" id="freeDays" v-model="form.freeDays" /><br>
    
            <label for="NearestStation">最寄り駅:</label>
            <input type="text" id="NearestStation" v-model="form.NearestStation" /><br>
    
            <label for="workOther">その他:</label>
            <input type="text" id="workOther" v-model="form.workOther" /><br>
    
            <button type="submit">登録する</button>
        </form>

        <Link href="/company/index">戻る</Link>
    </div>
</template>