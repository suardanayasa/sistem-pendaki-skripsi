<?php

namespace App\Http\Controllers;

use App\Models\Climbing;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCounterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AUTH SECTION
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('ticketCounter.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('ticket_counter')->attempt($credentials)) {
            
            // --- TAMBAHAN UNTUK MONITORING ADMIN ---
            $user = Auth::guard('ticket_counter')->user();
            $user->update([
                'last_login_at' => now() // Mencatat jam masuk petugas
            ]);
            // ----------------------------------------

            $request->session()->regenerate();
            return redirect()->route('ticket.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        // --- TAMBAHAN UNTUK MONITORING ADMIN ---
        $user = Auth::guard('ticket_counter')->user();
        if ($user) {
            $user->update([
                'last_logout_at' => now() // Mencatat jam keluar petugas
            ]);
        }
        // ----------------------------------------

        Auth::guard('ticket_counter')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('ticket.login');
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SECTION
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        // Menampilkan yang masih mendaki di urutan paling atas
        $climbings = \App\Models\Climbing::with(['ticket', 'group', 'ticketCounter'])
            ->orderByRaw('check_out_date IS NOT NULL ASC') 
            ->latest()
            ->get();

        $guides = \App\Models\Guide::all();
        
        $income = Ticket::withCount('climbings')->get()->map(function ($ticket) {
            return [
                'name' => $ticket->name,
                'income' => $ticket->price * $ticket->climbings_count,
            ];
        });

        return view('ticketCounter.dashboard', compact('climbings', 'guides', 'income'));
    }

    /*
    |--------------------------------------------------------------------------
    | FINISH SECTION (PENYESUAIAN)
    |--------------------------------------------------------------------------
    */
    public function finish($id)
    {
        $climbing = Climbing::findOrFail($id);

        $climbing->update([
            'status' => 'finished',
            'check_out_date' => now(), // Mencatat jam turun WITA otomatis
            // Menambahkan ID petugas yang login untuk audit trail di skripsi
            'ticket_counter_id' => Auth::guard('ticket_counter')->id(), 
        ]);

        return back()->with('success', 'Pendaki ' . $climbing->name . ' berhasil dikonfirmasi turun.');
    }
}