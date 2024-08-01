
<template>
    <BasePage>

        <SiteTitle>{{ companyName }}</SiteTitle>

        <div class="border border-gray-400">
            <!-- スライダー画像 -->
            <div class="h-80 w-full">
                <img class="w-full h-full object-cover" src="../../../public/images/company_img.jpg" alt="">
            </div>
            <div class="m-3">
                <h3 class="mb-2">{{ WantedTitle }}</h3>
                <div class="mb-2">
                    <p>-職種</p>
                    <p>{{ Occupation }}</p>
                </div>
                <div class="mb-2">
                    <p>-月給</p>
                    <p>{{ companyPay }}～</p>
                </div>
                <div class="mb-2">
                    <p>-勤務地</p>
                    <p>{{ dutyStation }}</p>
                </div>
                <div class="mb-2">
                    <p>-仕事内容</p>
                    <p>{{ workDescription }}</p>
                </div>
                <div class="mb-2">
                    <p>-給与詳細</p>
                    <p>{{ payDescription }}</p>
                </div>
                <div class="mb-2">
                    <p>-交通費</p>
                    <p>{{ travelExpenses }}</p>
                </div>
                <div class="mb-2">
                    <p>-福利厚生</p>
                    <p>{{ Welfares }}</p>
                </div>
                <div class="mb-2">
                    <p>-勤務時間</p>
                    <p>{{ workHours }}</p>
                </div>
                <div class="mb-2">
                    <p>-曜日</p>
                    <p>{{ workDays }}</p>
                </div>
                <div class="mb-2">
                    <p>-最寄り駅</p>
                    <p>{{ NearestStation }}</p>
                </div>
                <div class="mb-2">
                    <p>-その他</p>
                    <p>{{ workOther }}</p>
                </div>
                <div class="mb-2">
                    <p>-会社住所</p>
                    <p>{{ companyAddress }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h1>{{ companyName }}で募集中の求人</h1>

            <div class="">
                <div class="">
                    <div class="h-80 w-full">
                        <img class="w-full h-full object-cover" src="../../../public/images/company_img.jpg" alt="">
                    </div>
                    <p>{{ companyName }}</p>
                    <h3>{{ WantedTitle }}</h3>
                    <div class="mb-2">
                        <p>-月給</p>
                        <p>{{ companyPay }}～</p>
                    </div>
                    <div class="mb-2">
                        <p>-勤務地</p>
                        <p>{{ dutyStation }}</p>
                    </div>

                </div>
            </div>
        </div>
    </BasePage>
</template>

<script setup>

import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import Button from '../Components/Button/Button.vue';

const companyName = '株式会社ファイブタッグプラス';
const Occupation = "情報技術"
const WantedTitle = 'パソコンを使ったデータ入力';
const companyAddress = '長崎県長崎市万屋町12-1';
const companyPay = '160.000';
const dutyStation = '長崎県長崎市';
const workDescription = 'ここに具体的な仕事内容が入ります。ここに具体的な仕事内容が入ります。ここに具体的な仕事内容が入ります。ここに具体的な仕事内容が入ります。';
const payDescription = '時間外手当、賞与2回、交通費規定支給（上限20,000円まで';
const travelExpenses = '規定支給（20,000円まで）';
const Welfares = '社会保険 賞与あり 資格取得支援制度';
const workHours = '9:00～18:00（休憩60分）';
const workDays = '土日祝日休み';
const NearestStation = '眼鏡橋駅';
const workOther = '経験者優遇';

</script>
