<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Climbing;
use App\Models\Ticket;
use App\Models\Group;
use App\Models\TicketCounter;
use App\Models\Guide; // TAMBAHKAN INI
use Carbon\Carbon;

class ClimbingSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::all();
        $groups = Group::all();
        $counters = TicketCounter::all();
        $guides = Guide::all(); // AMBIL DATA GUIDE

        // Pastikan ada guide di database sebelum jalankan seeder
        if ($guides->isEmpty()) {
            Guide::create([
                'name' => 'Pande Suardana',
                'phone' => '08123456789',
            ]);
            $guides = Guide::all();
        }

        foreach ($groups as $group) {
            // Setiap group kita isi 3 pendaki
            for ($i = 1; $i <= 3; $i++) {
                Climbing::create([
                    'name' => 'Pendaki ' . $i . ' Group ' . $group->id,
                    'residence' => 'Denpasar',
                    'phone_number' => '089' . rand(100, 999) . rand(100, 999), // Tambahkan HP biar lengkap
                    'ticket_id' => $tickets->random()->id,
                    'group_id' => $group->id,
                    'guide_id' => $guides->random()->id, // TAMBAHKAN GUIDE ID DISINI
                    'status' => 'climbing',
                    'check_in_date' => $group->climbing_date,
                    'check_out_date' => Carbon::parse($group->climbing_date)->addDays(2),
                    'ticket_counter_id' => $counters->random()->id,
                ]);
            }
        }
    }
}