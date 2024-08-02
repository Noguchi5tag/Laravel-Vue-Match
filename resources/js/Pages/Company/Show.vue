<script setup>
import { router, Link } from '@inertiajs/vue3';

const props = defineProps({
    id: String,
    inertiaJob: Object,
})

console.log('inertiaJob:', props.inertiaJob)

const deleteFunction = id => {
    console.log('id:', id)
    router.delete(`/company/delete/${id}`, {
        onBefore: () => confirm('削除しますか？')
    },)
}
</script>

<template>
    <div v-if="props.inertiaJob">
        {{ props.inertiaJob.id }}
        <h1>会社名：{{ props.inertiaJob.companyName }}</h1>
        <p>募集タイトル：{{ props.inertiaJob.WantedTitles }}</p>
        <p>職種：{{ props.inertiaJob.Occupation }}</p>
        <p>会社の住所：{{ props.inertiaJob.companyAddress }}</p>
        <p>給料：{{ props.inertiaJob.companyPay }}</p>
        <p>勤務地：{{ props.inertiaJob.dutyStation }}</p>
        <p>仕事内容：{{ props.inertiaJob.workDescription }}</p>
        <p>給与詳細：{{ props.inertiaJob.payDescription }}</p>
        <p>交通費：{{ props.inertiaJob.travelExpenses }}</p>
        <p>福利厚生：{{ props.inertiaJob.Welfare }}</p>
        <p>勤務時間：{{ props.inertiaJob.startWork }}～{{ props.inertiaJob.endWork }}</p>
        <p>出勤日：{{ props.inertiaJob.workDays }}</p>
        <p>休日：{{ props.inertiaJob.freeDays }}</p>
        <p>最寄り駅：{{ props.inertiaJob.NearestStation }}</p>
        <p>その他：{{ props.inertiaJob.workOther }}</p>
    </div>
    <div v-else>
        <p>データが見つかりません。</p>
    </div>

    <button @click="deleteFunction(props.inertiaJob.id)" class="bg-red-400">削除</button>

    <Link as="button" :href="route('company.edit', { inertiaJob: props.inertiaJob.id })" class="bg-green-200">編集する</Link>

    <Link href="/company/index">戻る</Link>

</template>