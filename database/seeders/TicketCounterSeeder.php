<?php

namespace Database\Seeders;

use App\Models\TicketCounter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TicketCounterSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Petugas Loket 1
        TicketCounter::create([
            'name'          => 'Petugas Loket 1',
            'email'         => 'loket1@example.com',
            'address'       => 'Basecamp Utama',
            'date_of_birth' => Carbon::create(1995, 4, 10),
            'password'      => Hash::make('password123'),
        ]);

        // Petugas Loket 2
        TicketCounter::create([
            'name'          => 'Petugas Loket 2',
            'email'         => 'loket2@example.com',
            'address'       => 'Basecamp Selatan',
            'date_of_birth' => Carbon::create(1998, 7, 15),
            'password'      => Hash::make('password123'),
        ]);
    }
}