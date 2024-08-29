## 開発環境

PHP 8.2.21<br>
Laravel 11.14.0（Sail使用）<br>
Breeze（認証機能）<br>
Vue3（compositionAPI）<br>
Inertia.js

## クローン後の初期設定
sail をインストール<br>
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs


## DB 初期化

sail artisan migrate

ストレージへのパスを公開する<br>
sail artisan storage:link

.envファイル作成（環境により変更を行うこと）

Package.jsonのインストール<br>
npm install

## 立ち上げ

sail up -d

開発時フロントエンドのホットリロード<br>
sail npm run dev

フロントエンドのビルド<br>
sail npm run build

## 終了

sail down

## テストデータの追加

sail artisan migrate:fresh --seed<br>
デフォルトログインユーザー<br>
求人<br>
お知らせ

デフォルトログイン<br>
test@test.com<br>
password

## 変数名の定義

//仕事<br>
companyName : 会社名<br>
WantedTitles : 募集タイトル<br>
Occupation : 職種<br>
companyAddress : 会社の住所<br>
companyPay : 給料<br>
dutyStation : 勤務地<br>
workDescription : 仕事内容<br>
payDescription : 給与詳細<br>
travelExpenses : 交通費<br>
Welfare : 福利厚生<br>
startWork : 勤務開始時間<br
endWork : 勤務終了時間<br>
workDays : 出勤日<br>
freeDays : 休日<br>
NearestStation : 最寄り駅<br>
workOther : その他<br>
status : 公開か非公開か<br>


'image1', // 画像1<br>
'image2', // 画像2<br>
'image3', // 画像3<br>
'image4', // 画像4<br>
'image5', // 画像5

//登録情報<br>
name : 名前<br>
email：メールアドレス<br>
tel : 電話番号<br>
sex : 性別（男・女・どちらでもない）<br>
birth : 生年月日<br>
postal : 郵便番号<br>
prefectures : 都道府県<br>
city : 市町村<br>
password : パスワード<br>

------------------------------------------------------
## 権限

エンドユーザー

閲覧のみ<br>
登録した企業<br>
閲覧、登録した情報の編集<br>
<br>
<br>
管理者<br>
閲覧、登録、編集、削除

------------------------------------------------------
## データベース

http://localhost:8080

------------------------------------------------------

## よくあるエラー

- **[@inertiajs_inertia.js?v=27e72e94:1558 Uncaught (in promise) TypeError: this.resolveComponent is not a function]** <br>
→sail npm run buildして、立ち上げ直したらOK

------------------------------------------------------