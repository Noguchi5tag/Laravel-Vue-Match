<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\InertiaJob;
use App\Models\News;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(1)->create();
        InertiaJob::factory(10)->create();
        News::factory(3)->create();

    }
}
