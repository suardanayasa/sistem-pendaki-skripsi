<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Ticket;
use App\Models\TicketCounter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Buat Akun Admin (Login pakai username)
        Admin::create([
            'name' => 'Admin Utama',
            'username' => 'admin_mantap', // Ini yang diketik di kolom login admin
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat Akun Petugas Loket (Login pakai email)
        TicketCounter::create([
            'name' => 'Petugas Loket 1',
            'email' => 'loket1@example.com',
            'address' => 'Jl. Raya Pendaki No. 10',
            'date_of_birth' => '1995-05-20',
            'password' => Hash::make('password123'),
        ]);

        // 3. Buat Data Tiket
        Ticket::create(['name' => 'Domestik', 'price' => 25000]);
        Ticket::create(['name' => 'Mancanegara', 'price' => 50000]);
    }
}