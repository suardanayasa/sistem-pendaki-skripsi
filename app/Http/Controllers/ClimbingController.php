<?php

namespace App\Http\Controllers;

use App\Models\Climbing;
use App\Models\Ticket;
use App\Models\Group;
use Illuminate\Http\Request;

class ClimbingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM DOMESTIK
    |--------------------------------------------------------------------------
    */

    public function createDomestic()
    {
        $groups = Group::all();
        return view('climbing.domestic', compact('groups'));
    }

    public function storeDomestic(Request $request)
    {
        $ticket = Ticket::where('name', 'Domestik')->firstOrFail();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'residence'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20', 
            'group_id'     => 'nullable|exists:groups,id',
        ]);

        Climbing::create([
            'name'              => $validated['name'],
            'residence'         => $validated['residence'],
            'phone_number'      => $validated['phone_number'], 
            'ticket_id'         => $ticket->id,
            'group_id'          => $validated['group_id'],
            'status'            => 'climbing',
            'check_in_date'     => now(), // Mengisi jam naik otomatis
            'check_out_date'    => null,
            'ticket_counter_id' => null,
        ]);

        return back()->with('success', 'Registrasi Domestik berhasil!');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM MANCANEGARA
    |--------------------------------------------------------------------------
    */

    public function createForeign()
    {
        $groups = Group::all();
        return view('climbing.foreign', compact('groups'));
    }

    public function storeForeign(Request $request)
    {
        $ticket = Ticket::where('name', 'Mancanegara')->firstOrFail();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'residence'    => 'required|string|max:255',
            'phone_number' => 'required|string|max:20', 
            'group_id'     => 'nullable|exists:groups,id',
        ]);

        Climbing::create([
            'name'              => $validated['name'],
            'residence'         => $validated['residence'],
            'phone_number'      => $validated['phone_number'], 
            'ticket_id'         => $ticket->id,
            'group_id'          => $validated['group_id'],
            'status'            => 'climbing',
            'check_in_date'     => now(), // Mengisi jam naik otomatis
            'check_out_date'    => null,
            'ticket_counter_id' => null,
        ]);

        return back()->with('success', 'Registrasi Mancanegara berhasil!');
    }
}