<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Guide;
use Carbon\Carbon;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $guides = Guide::all();

        foreach ($guides as $guide) {
            Group::create([
                'guide_id' => $guide->id,
                'climbing_date' => Carbon::now()->addDays(rand(1, 10)),
            ]);
        }
    }
}