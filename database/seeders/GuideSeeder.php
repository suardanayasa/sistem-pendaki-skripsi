<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;
use Carbon\Carbon;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        Guide::create([
            'name' => 'Wayan Arta',
            'email' => 'wayan@example.com',
            'phone' => '081234567890',
            'description' => 'Senior mountain guide with strong knowledge of tracking routes.',
            'date_of_birth' => Carbon::create(1990, 5, 10),
        ]);

        Guide::create([
            'name' => 'Made Surya',
            'email' => 'made@example.com',
            'phone' => '081298765432',
            'description' => 'Expert in emergency response and survival techniques.',
            'date_of_birth' => Carbon::create(1988, 8, 15),
        ]);
    }
}