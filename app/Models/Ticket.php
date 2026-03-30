<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    // Relasi: 1 Ticket punya banyak Climbing
    public function climbings()
    {
        return $this->hasMany(Climbing::class);
    }
}