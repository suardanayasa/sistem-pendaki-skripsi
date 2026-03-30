<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;

    // Menegaskan nama tabel di database
    protected $table = 'guides';

    // Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'date_of_birth',
    ];

    // Mengonversi string date dari database menjadi objek Carbon (Date) otomatis
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Relasi: Seorang Guide bisa memandu banyak kelompok (Group)
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}