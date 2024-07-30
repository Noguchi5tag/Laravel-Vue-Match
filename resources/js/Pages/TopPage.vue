<template>
    <BasePage>
        <SiteTitle>トップページ</SiteTitle>

        <div class="">
            <div class="flex">
                <img class="w-6" src="../../../public/images/company.png" alt="">
                <h2 class="">{{ companyName }}</h2>
            </div>
            <!-- スライダー画像 -->
            <div class="">
                <img src="../../../public/images/company_img.jpg" alt="">
            </div>
            <div class="">
                <span></span> <!-- いいね機能 -->
                <span></span> <!-- ブックマーク -->
                <Button slug="/job-detail">詳しく見る</Button>
            </div>
            <div class="">
                <h3>{{ WantedTitles }}</h3>
                <div class="flex">
                    <img class="w-6" src="../../../public/images/company.png" alt="">
                    <p>{{ companyAddress }}</p>
                </div>
                <div class="flex">
                    <img class="w-6" src="../../../public/images/company.png" alt="">
                    <p>月給：{{ companyPay }}～</p>
                </div>
                <div class="flex">
                    <img class="w-6" src="../../../public/images/company.png" alt="">
                    <p>{{ dutyStation }}</p>
                </div>
            </div>
        </div>
    </BasePage>
</template>


<script setup>
import { Link } from '@inertiajs/vue3';

import BasePage from './BasePage.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import Button from '../Components/Button/Button.vue';

const companyName = '株式会社ファイブタッグプラス';
const WantedTitles = 'パソコンを使ったデータ入力';
const companyAddress = 'パソコンを使ったデータ入力';
const companyPay = '160.000';
const dutyStation = '長崎県長崎市万屋町12-1';

</script>