<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Climbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'residence',
        'phone_number', 
        'ticket_id',
        'group_id',
        'guide_id', // WAJIB ADA: Agar bisa menyimpan ID Guide di database
        'status',
        'check_in_date',
        'check_out_date',
        'ticket_counter_id',
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR UNTUK DURASI (TAMBAHAN UNTUK SKRIPSI)
    |--------------------------------------------------------------------------
    */

    public function getDurationAttribute()
    {
        if ($this->check_in_date && $this->check_out_date) {
            return $this->check_in_date->diffForHumans($this->check_out_date, [
                'syntax' => Carbon::DIFF_ABSOLUTE,
                'parts' => 2, 
            ]);
        }
        return 'Masih mendaki';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // RELASI KE GUIDE: Inilah yang menyambungkan ke tabel guides agar tidak error lagi
    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    // Climbing milik 1 Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Climbing milik 1 Group
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Climbing diselesaikan oleh 1 TicketCounter
    public function ticketCounter()
    {
        return $this->belongsTo(TicketCounter::class);
    }
}