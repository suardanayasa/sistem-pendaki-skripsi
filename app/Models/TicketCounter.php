<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class TicketCounter extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel sesuai phpMyAdmin kamu.
     */
    protected $table = 'ticket_counters';

    /**
     * Primary Key otomatis menggunakan 'id' (sesuai image_ff6644.jpg).
     * Kita tidak perlu lagi menuliskan protected $primaryKey = 'pengenal';
     */

    /**
     * Daftar kolom yang boleh diisi (Fillable).
     * SESUAIKAN: Menggunakan nama kolom bahasa Inggris sesuai gambar terbaru kamu.
     */
    protected $fillable = [
        'name',           // Kolom name (Baris 2)
        'email',          // Kolom email (Baris 3)
        'address',        // Kolom address (Baris 4)
        'date_of_birth',  // Kolom date_of_birth (Baris 5)
        'password',       // Kolom password (Baris 6)
        'last_login_at', 
        'last_logout_at' 
    ];

    /**
     * Karena di gambar terbaru kolomnya sudah standar (created_at & updated_at),
     * kita tidak perlu lagi mengarahkan ke 'dibuat pada'. 
     * Laravel akan otomatis mengisinya.
     */

    /**
     * Kolom yang disembunyikan saat data dipanggil.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data agar Laravel mengenali format tanggal dan hash.
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'last_logout_at' => 'datetime',
    ];

    /**
     * Jika kolom password kamu sudah bernama 'password', fungsi getAuthPassword 
     * di bawah ini sebenarnya sudah tidak wajib, tapi aman untuk tetap ada.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Relasi: 1 TicketCounter (Penjaga Tiket) menangani banyak Climbing (Pendakian).
     */
    public function climbings()
    {
        return $this->hasMany(Climbing::class, 'ticket_counter_id');
    }
}