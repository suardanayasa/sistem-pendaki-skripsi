<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        Ticket::create([
            'name' => 'Domestik',
            'price' => 150000
        ]);

        Ticket::create([
            'name' => 'Domestik',
            'price' => 200000
        ]);

        Ticket::create([
            'name' => 'Mancanegara',
            'price' => 300000
        ]);
    }
}