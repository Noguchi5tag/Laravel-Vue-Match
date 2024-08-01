<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    inertiaJobs: Array,
})
</script>

<template>
    テンプレ：company/index

    <div v-if="inertiaJobs">
        <div v-for="n in inertiaJobs" :key="n.id">
            <p>ID：{{ n.id }}</p>
            <h1>会社名：{{ n.companyName }}</h1>
            <p>募集タイトル：{{ n.WantedTitles }}</p>
            <p>職種：{{ n.Occupation }}</p>
            <p>会社の住所：{{ n.companyAddress }}</p>
            <p>給料：{{ n.companyPay }}</p>
            <p>勤務地：{{ n.dutyStation }}</p>
            <p>仕事内容：{{ n.workDescription }}</p>
            <p>給与詳細：{{ n.payDescription }}</p>
            <p>交通費：{{ n.travelExpenses }}</p>
            <p>福利厚生：{{ n.Welfare }}</p>
            <p>勤務時間：{{ n.startWork }}～{{ n.endWork }}</p>
            <p>出勤日：{{ n.workDays }}</p>
            <p>休日：{{ n.freeDays }}</p>
            <p>最寄り駅：{{ n.NearestStation }}</p>
            <p>その他：{{ n.workOther }}</p>
            <Link :href="route('company.show', { inertiaJob: n })">詳細へ</Link>
            <hr>
        </div>
    </div>
</template>