const dutyStations = [
    { value: '長崎市', label: '長崎市' },
    { value: '島原市', label: '島原市' },
    { value: '雲仙市', label: '雲仙市' },
    { value: '南島原市', label: '南島原市' },
    { value: '諫早市', label: '諫早市' },
    { value: '西海市', label: '西海市' },
    { value: '五島市', label: '五島市' },
    { value: '平戸市', label: '平戸市' },
    { value: '壱岐市', label: '壱岐市' },
    { value: '対馬市', label: '対馬市' },
    { value: '松浦市', label: '松浦市' },
    { value: '新上五島市', label: '新上五島市' },
];

const Occupations = [
    { value: '営業', label: '営業' },
    { value: '事務', label: '事務' },
    { value: 'エンジニア', label: 'エンジニア' },
    { value: 'デザイナー', label: 'デザイナー' },
    { value: 'その他', label: 'その他' },
];

const companyPays = [
    { value: '150000', label: '~150,000円' },
    { value: '200000', label: '150,000円~' },
    { value: '250000', label: '200,000円~' },
    { value: '300000', label: '250,000円~' },
    { value: '300001', label: '300,000円~' },
];

const SchoolClass = [
    { value: '大学院', label: '大学院' },
    { value: '大学', label: '大学' },
    { value: '高校', label: '高校' },
    { value: '中学校', label: '中学校' },
]

const prefectures = [
    '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
    '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
    '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
    '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
    '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
    '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
    '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
];

const requirements = [
    { 
        label: '営業', 
        value: [
            { label: '法人営業', value: 'b2b_sales' },
            { label: '個人営業', value: 'b2c_sales' },
            { label: 'ルート営業', value: 'route_sales' },
            { label: '新規開拓営業', value: 'new_business_sales' },
            { label: '代理店営業', value: 'agency_sales' },
            { label: '海外営業', value: 'overseas_sales' },
            { label: '技術営業（テクニカルセールス）', value: 'technical_sales' },
            { label: 'コンサルティング営業', value: 'consulting_sales' },
            { label: '企画営業', value: 'planning_sales' },
            { label: 'インサイドセールス', value: 'inside_sales' },
            { label: 'フィールドセールス', value: 'field_sales' },
            { label: 'ソリューション営業', value: 'solution_sales' },
            { label: '金融営業', value: 'finance_sales' }
        ]
    },
    { 
        label: '医療・福祉', 
        value: [
            { label: '医師', value: 'doctor' },
            { label: '歯科医師', value: 'dentist' },
            { label: '歯科技工士', value: 'dental_technician' },
            { label: '看護師', value: 'nurse' },
            { label: '准看護師', value: 'assistant_nurse' },
            { label: '薬剤師', value: 'pharmacist' },
            { label: '医療事務', value: 'medical_office_worker' },
            { label: '管理栄養士', value: 'nutritionist' },
            { label: '介護職', value: 'care_worker' },
            { label: '臨床検査技師', value: 'clinical_laboratory_technician' },
            { label: '獣医師', value: 'veterinarian' }
        ]
    },
    { 
        label: 'ITエンジニア', 
        value: [
            { label: 'システムエンジニア（SE）', value: 'system_engineer' },
            { label: 'プログラマー（PG）', value: 'programmer' },
            { label: 'ネットワークエンジニア', value: 'network_engineer' },
            { label: 'インフラエンジニア', value: 'infrastructure_engineer' },
            { label: 'フロントエンドエンジニア', value: 'frontend_engineer' },
            { label: 'バックエンドエンジニア', value: 'backend_engineer' },
            { label: 'データベースエンジニア', value: 'database_engineer' },
            { label: 'セキュリティエンジニア', value: 'security_engineer' },
            { label: 'クラウドエンジニア', value: 'cloud_engineer' },
            { label: 'プロジェクトマネージャー', value: 'project_manager' },
            { label: 'ITコンサルタント', value: 'it_consultant' }
        ]
    },
    { 
        label: 'クリエイティブ', 
        value: [
            { label: 'グラフィックデザイナー', value: 'graphic_designer' },
            { label: 'Webデザイナー', value: 'web_designer' },
            { label: 'アートディレクター', value: 'art_director' },
            { label: '映像クリエイター', value: 'video_creator' },
            { label: 'ゲームクリエイター', value: 'game_creator' },
            { label: 'UI/UXデザイナー', value: 'ui_ux_designer' },
            { label: 'イラストレーター', value: 'illustrator' },
            { label: 'フォトグラファー', value: 'photographer' },
            { label: 'コピーライター', value: 'copywriter' },
            { label: '編集者', value: 'editor' },
            { label: '音響エンジニア', value: 'sound_engineer' },
            { label: 'ファッションデザイナー', value: 'fashion_designer' }
        ]
    },
    { 
        label: '美容・ブライダル・ホテル・交通', 
        value: [
            { label: '美容師', value: 'hairdresser' },
            { label: 'エステティシャン', value: 'esthetician' },
            { label: 'ネイリスト', value: 'nail_technician' },
            { label: 'メイクアップアーティスト', value: 'makeup_artist' },
            { label: 'ウェディングプランナー', value: 'wedding_planner' },
            { label: 'ブライダルコーディネーター', value: 'bridal_coordinator' },
            { label: 'ホテルスタッフ', value: 'hotel_staff' },
            { label: 'フロントスタッフ', value: 'front_desk_staff' },
            { label: 'ベルスタッフ', value: 'bell_staff' },
            { label: '客室清掃員', value: 'housekeeping_staff' },
            { label: 'ツアーコンダクター', value: 'tour_conductor' },
            { label: 'バスガイド', value: 'bus_guide' },
            { label: 'ドライバー', value: 'driver' },
            { label: 'パイロット', value: 'pilot' },
            { label: 'キャビンアテンダント', value: 'cabin_attendant' }
        ]
    }
];

const jobJoin = [
    { value: 'immediate', label: '即日' },
    { value: 'within_1_month', label: '1ヶ月以内' },
    { value: 'within_3_months', label: '3ヶ月以内' },
    { value: 'within_6_months', label: '半年以内' },
    { value: 'within_1_year', label: '1年以内' },
    { value: 'negotiable', label: 'その他（要相談）' },
    { value: 'next_april', label: '来年4月' },
    { value: 'next_october', label: '来年10月' },
    { value: 'undecided', label: '未定' }
];

const employment = [
    { value: 'full_time', label: '正社員' },
    { value: 'contract', label: '契約社員' },
    { value: 'outsourcing', label: '業務委託' },
    { value: 'temporary_dispatch', label: '一般派遣・紹介予定派遣' },
    { value: 'part_time', label: 'アルバイト・パート' },
    { value: 'medical_clerical', label: '医療事務' },
    { value: 'other_negotiable', label: 'その他（要相談）' }
];


const particulars = [
    {
        label: '募集について',
        value: [
            { label: '未経験歓迎', value: 'welcome_no_experience' },
            { label: '経験者優遇', value: 'prefer_experienced' },
            { label: '学歴不問', value: 'no_academic_background' },
            { label: '中途採用あり', value: 'mid_career_recruitment' },
            { label: '急募', value: 'urgent_recruitment' },
            { label: '女性活躍中', value: 'active_female_employees' },
            { label: '外国籍歓迎', value: 'welcome_foreigners' }
        ]
    },
    {
        label: '仕事について',
        value: [
            { label: 'シフト制', value: 'shift_system' },
            { label: '夜勤あり', value: 'night_shift' },
            { label: '残業少なめ', value: 'few_overtime_hours' },
            { label: 'リモートワーク可能', value: 'remote_work_possible' },
            { label: 'フレックスタイム制', value: 'flex_time_system' },
            { label: '出張あり', value: 'business_trip' },
            { label: '副業OK', value: 'side_job_ok' },
            { label: 'チーム制', value: 'team_system' },
            { label: '個人ノルマなし', value: 'no_individual_target' }
        ]
    },
    {
        label: '会社について',
        value: [
            { label: '新卒採用あり', value: 'new_graduate' },
            { label: '土日祝日休み', value: 'weekend_holidays' },
            { label: '年間休日120日以上', value: 'over_120_days_off' },
            { label: '育児支援あり', value: 'child_care_support' },
            { label: '介護支援あり', value: 'nursing_care_support' },
            { label: 'フラットな組織', value: 'flat_organization' },
            { label: '上場企業', value: 'listed_company' },
            { label: 'ベンチャー企業', value: 'venture_company' },
            { label: 'アットホームな職場', value: 'homey_workplace' },
            { label: '女性管理職登用実績あり', value: 'female_manager' },
            { label: '転勤なし', value: 'no_transfer' }
        ]
    },
    {
        label: '待遇、職場環境について',
        value: [
            { label: '住宅手当あり', value: 'housing_allowance' },
            { label: '交通費支給', value: 'transportation_expense' },
            { label: '社宅・家賃補助制度あり', value: 'company_housing' },
            { label: '食事補助あり', value: 'meal_allowance' },
            { label: '資格取得支援あり', value: 'qualification_support' },
            { label: '退職金制度あり', value: 'retirement_benefit' },
            { label: '家族手当あり', value: 'family_allowance' },
            { label: '社員食堂あり', value: 'employee_cafeteria' },
            { label: '健康診断あり', value: 'health_checkup' },
            { label: '在宅勤務あり', value: 'work_from_home' },
            { label: '副業・兼業可', value: 'side_job_permissible' },
            { label: '社員旅行あり', value: 'employee_trip' },
            { label: '研修制度充実', value: 'extensive_training' }
        ]
    }
];


export { dutyStations, Occupations, companyPays, SchoolClass, prefectures, requirements, jobJoin, employment, particulars, };