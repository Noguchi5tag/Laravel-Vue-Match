<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\InertiaJob;
use App\Models\News;
use App\Models\Manager;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(1)->create();
        Admin::factory(1)->create();
        Manager::factory(1)->create();
        InertiaJob::factory(10)->create();
        News::factory(3)->create();
    }
}
