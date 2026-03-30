<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',          // TAMBAHKAN INI: Agar nama group bisa disimpan
        'description',   // TAMBAHKAN INI: Agar keterangan bisa disimpan
        'guide_id',
        'climbing_date',
    ];

    protected $casts = [
        'climbing_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Relasi ke Guide
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    // Relasi ke Climbing
    public function climbings()
    {
        return $this->hasMany(Climbing::class);
    }
}