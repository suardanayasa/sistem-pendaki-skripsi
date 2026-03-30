<?php

namespace App\Http\Controllers;

use App\Models\Climbing;
use App\Models\Ticket;
use App\Models\Guide; 
use App\Models\Group; 
use App\Models\TicketCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class AdminController extends Controller
{
    // =====================
    // LOGIN FORM
    // =====================
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // =====================
    // MANAJEMEN PENJAGA TIKET (CRUD & LOGS)
    // =====================
    public function ticketCounter()
    {
        // Mengambil semua data dari tabel ticket_counters
        $counters = \App\Models\TicketCounter::all();
        
        // Data pendukung agar layout/sidebar tidak error
        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('created_at', '>=', now()->subDays(13))
            ->groupBy('date')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')->get();

        return view('admin.ticket_counters', compact('counters', 'overdueClimbers', 'notifCount', 'dailyData', 'monthlyData'));
    }

    public function storeTicketCounter(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        // PENYESUAIAN: Nama kolom disamakan dengan struktur image_ff6644.jpg
        \App\Models\TicketCounter::create([
            'name'           => $request->nama,           // Kolom 'name' di DB
            'email'          => $request->email,          // Kolom 'email' di DB
            'password'       => bcrypt($request->password), 
            'address'        => $request->alamat,         // Kolom 'address' di DB
            'date_of_birth'  => $request->tanggal_lahir, // Kolom 'date_of_birth' di DB
            
            // Log login
            'last_login_at'  => null,
            'last_logout_at' => null,
        ]);

        return back()->with('success', 'Penjaga tiket berhasil ditambahkan!');
    }

    public function destroyTicketCounter($id)
    {
        // Mencari data berdasarkan Primary Key (id) dan menghapusnya
        \App\Models\TicketCounter::findOrFail($id)->delete();
        
        return back()->with('success', 'Data penjaga tiket berhasil dihapus!');
    }

    // =====================
    // FITUR EXPORT LAPORAN (TAMBAHAN BARU)
    // =====================
    public function exportExcel()
    {
        $climbings = \App\Models\Climbing::with('ticket')->get();
        
        // Header agar browser mendownload file sebagai Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Pendapatan_Tiket_".date('d-m-Y').".xls");
        
        echo "No\tNama Pendaki\tKategori\tHarga Tiket\tWaktu Naik\n";
        
        foreach($climbings as $key => $data) {
            $harga = $data->ticket->price ?? 0;
            $waktu = $data->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i');
            echo ($key+1)."\t".$data->name."\t".($data->ticket->name ?? '-')."\t".$harga."\t".$waktu."\n";
        }
        exit;
    }

    public function exportPdf()
    {
        // Ambil data untuk tabel
        $climbings = \App\Models\Climbing::with(['ticket', 'group'])->get();
        $totalIncome = $climbings->sum(fn($c) => $c->ticket->price ?? 0);

        // PENYESUAIAN WITA: Grafik Harian (14 hari terakhir)
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        // Ambil data untuk Grafik Bulanan (Tahun ini)
        $monthlyData = \App\Models\Climbing::selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(MIN(created_at))'), 'asc')->get();

        // Memanggil view khusus cetak
        return view('admin.reports.print_pendaki', compact('climbings', 'totalIncome', 'dailyData', 'monthlyData'));
    }

    // ==========================================
    // EXPORT EXCEL KHUSUS REKAP BULANAN
    // ==========================================
    public function exportRekapExcel()
    {
        $rekap = \App\Models\Climbing::selectRaw("
                MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as total_pendaki,
                SUM(CASE WHEN EXISTS (SELECT 1 FROM tickets WHERE tickets.id = climbings.ticket_id AND tickets.name = 'Domestik') THEN 1 ELSE 0 END) as total_domestik,
                SUM(CASE WHEN EXISTS (SELECT 1 FROM tickets WHERE tickets.id = climbings.ticket_id AND tickets.name = 'Mancanegara') THEN 1 ELSE 0 END) as total_mancanegara,
                SUM((SELECT COALESCE(tickets.price, 0) FROM tickets WHERE tickets.id = climbings.ticket_id)) as total_pendapatan
            ")
            ->groupBy('tahun', 'bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Rekap_Bulanan_Pendaki_".date('Y').".xls");
        
        echo "No\tPeriode\tTotal Pendaki\tDomestik\tMancanegara\tTotal Pendapatan\n";
        foreach($rekap as $i => $row) {
            $bulan = \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->translatedFormat('F Y');
            echo ($i+1)."\t".$bulan."\t".$row->total_pendaki."\t".$row->total_domestik."\t".$row->total_mancanegara."\t".$row->total_pendapatan."\n";
        }
        exit;
    }

    // ==========================================
    // EXPORT PDF KHUSUS REKAP BULANAN (BARU)
    // ==========================================
    public function exportRekapPdf()
    {
        $rekap = \App\Models\Climbing::selectRaw("
                MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as total_pendaki,
                SUM(CASE WHEN EXISTS (SELECT 1 FROM tickets WHERE tickets.id = climbings.ticket_id AND tickets.name = 'Domestik') THEN 1 ELSE 0 END) as total_domestik,
                SUM(CASE WHEN EXISTS (SELECT 1 FROM tickets WHERE tickets.id = climbings.ticket_id AND tickets.name = 'Mancanegara') THEN 1 ELSE 0 END) as total_mancanegara,
                SUM((SELECT COALESCE(tickets.price, 0) FROM tickets WHERE tickets.id = climbings.ticket_id)) as total_pendapatan
            ")
            ->groupBy('tahun', 'bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        $totalIncomeAll = $rekap->sum('total_pendapatan');

        return view('admin.reports.rekap_bulanan_pdf', compact('rekap', 'totalIncomeAll'));
    }

    // =====================
    // DATA PENDAFTARAN (Halaman Pendaki - Biru)
    // =====================
    public function climbing()
    {
        $climbings = \App\Models\Climbing::with(['ticket', 'group.guide', 'guide', 'ticketCounter'])
            ->orderBy('created_at', 'desc')
            ->get();

        $guides = \App\Models\Guide::all();
        $groups = \App\Models\Group::all(); 
        
        $totalTiket = $climbings->count();
        $totalDomestik = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Domestik')->count();
        $totalMancanegara = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Mancanegara')->count();
        $income = $climbings->sum(fn($c) => $c->ticket->price ?? 0);

        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.climbings', compact(
            'climbings', 'groups', 'guides', 'income', 'totalTiket', 'totalDomestik', 'totalMancanegara',
            'dailyData', 'monthlyData', 'overdueClimbers', 'notifCount'
        ));
    }

    // =====================
    // HAPUS DATA PENDAKI ← TAMBAHAN
    // =====================
    public function destroyClimbing($id)
    {
        \App\Models\Climbing::findOrFail($id)->delete();
        return redirect()->route('admin.climbing')->with('success', 'Data pendaki berhasil dihapus.');
    }

    // =====================
    // GROUPS MANAGEMENT
    // =====================
    public function group()
    {
        $groups = \App\Models\Group::all();
        $guides = \App\Models\Guide::all(); 
        $climbings = \App\Models\Climbing::all();
        $totalTiket = $climbings->count();
        $income = $climbings->sum(fn($c) => optional($c->ticket)->price ?? 0);

        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.groups', compact('groups', 'guides', 'climbings', 'totalTiket', 'income', 'dailyData', 'monthlyData', 'overdueClimbers', 'notifCount'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guide_id' => 'required|exists:guides,id',
            'description' => 'nullable|string'
        ]);

        \App\Models\Group::create([
            'name' => $request->name,
            'guide_id' => $request->guide_id,
            'description' => $request->description,
            'climbing_date' => now(), 
        ]);

        return back()->with('success', 'Group pendakian berhasil ditambahkan!');
    }

    // =====================
    // DASHBOARD (Tabel Dashboard & Grafik)
    // =====================
    public function dashboard()
    {
        // PENYESUAIAN: Mengutamakan yang belum turun (NULL) dan yang baru mendaftar (DESC)
        $climbings = \App\Models\Climbing::with(['ticket', 'group.guide', 'guide', 'ticketCounter'])
            ->orderByRaw('check_out_date IS NULL DESC')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $guides = \App\Models\Guide::all();
        $totalTiket = $climbings->count();
        $totalDomestik = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Domestik')->count();
        $totalMancanegara = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Mancanegara')->count();
        $income = $climbings->sum(fn($c) => $c->ticket->price ?? 0);

        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.dashboardAdmin', compact(
            'climbings', 'guides', 'income', 'totalTiket', 'totalDomestik', 'totalMancanegara',
            'dailyData', 'monthlyData', 'overdueClimbers', 'notifCount'
        ));
    }

    // =====================
    // HALAMAN STATISTIK (Hanya Grafik)
    // =====================
    public function statistik()
    {
        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        $totalPendaki = \App\Models\Climbing::count();
        $totalBulanIni = \App\Models\Climbing::whereMonth('created_at', date('m'))->count();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.statistik', compact('dailyData', 'monthlyData', 'totalPendaki', 'totalBulanIni', 'overdueClimbers', 'notifCount'));
    }

    // =====================
    // HALAMAN KEUANGAN (Detail Pendapatan)
    // =====================
    public function keuangan()
    {
        $climbings = \App\Models\Climbing::with(['ticket'])->get();
        
        $totalIncome = $climbings->sum(fn($c) => optional($c->ticket)->price ?? 0);
        $incomeDomestik = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Domestik')->sum(fn($c) => $c->ticket->price ?? 0);
        $incomeMancanegara = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Mancanegara')->sum(fn($c) => $c->ticket->price ?? 0);

        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('created_at', '>=', now()->subDays(13))->groupBy('date')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_pendaki')->whereYear('created_at', date('Y'))->groupBy('month')->get();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.keuangan', compact('totalIncome', 'incomeDomestik', 'incomeMancanegara', 'climbings', 'dailyData', 'monthlyData', 'overdueClimbers', 'notifCount'));
    }

    // =====================
    // REKAP BULANAN
    // =====================
    public function rekapBulanan()
    {
        $rekap = \App\Models\Climbing::selectRaw("
                MONTH(created_at)  as bulan,
                YEAR(created_at)   as tahun,
                COUNT(*)           as total_pendaki,
                SUM(CASE WHEN EXISTS (
                    SELECT 1 FROM tickets
                    WHERE tickets.id = climbings.ticket_id
                    AND tickets.name = 'Domestik'
                ) THEN 1 ELSE 0 END) as total_domestik,
                SUM(CASE WHEN EXISTS (
                    SELECT 1 FROM tickets
                    WHERE tickets.id = climbings.ticket_id
                    AND tickets.name = 'Mancanegara'
                ) THEN 1 ELSE 0 END) as total_mancanegara,
                SUM((
                    SELECT COALESCE(tickets.price, 0)
                    FROM tickets
                    WHERE tickets.id = climbings.ticket_id
                )) as total_pendapatan
            ")
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        // Data pendukung layout/sidebar
        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')
            ->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        return view('admin.Rekap_bulanan', compact(
            'rekap', 'overdueClimbers', 'notifCount', 'dailyData', 'monthlyData'
        ));
    }

    // =====================
    // HALAMAN KHUSUS TIKET
    // =====================
    public function tiket() {
        $climbings = \App\Models\Climbing::with(['ticket'])->get();
        $guides = \App\Models\Guide::all(); 
        $totalTiket = $climbings->count(); 
        $totalDomestik = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Domestik')->count();
        $totalMancanegara = $climbings->filter(fn($c) => optional($c->ticket)->name == 'Mancanegara')->count();
        $income = $climbings->sum(fn($c) => $c->ticket->price ?? 0);

        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.tiket', compact('climbings', 'guides', 'totalTiket', 'totalDomestik', 'totalMancanegara', 'income', 'dailyData', 'monthlyData', 'overdueClimbers', 'notifCount'));
    }

    // =====================
    // LOGIN PROCESS
    // =====================
    public function login(Request $request) {
        $credentials = $request->validate(['username' => 'required', 'password' => 'required']);
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    // =====================
    // GUIDE MANAGEMENT
    // =====================
    public function guide() { 
        $guides = \App\Models\Guide::all(); 
        $climbings = \App\Models\Climbing::all(); 
        
        // PENYESUAIAN WITA:
        $dailyData = \App\Models\Climbing::selectRaw("DATE(CONVERT_TZ(climbings.created_at, '+00:00', '+08:00')) as date, COUNT(*) as count")
            ->where('climbings.created_at', '>=', now()->subDays(13))
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $monthlyData = \App\Models\Climbing::selectRaw('MONTH(climbings.created_at) as month_num, MONTHNAME(climbings.created_at) as month, COUNT(*) as total_pendaki')
            ->whereYear('climbings.created_at', date('Y'))
            ->groupBy('month_num', 'month')->orderBy('month_num', 'asc')->get();

        $overdueClimbers = \App\Models\Climbing::whereNull('check_out_date')->where('created_at', '<=', now()->subHours(30))
            ->get();
        $notifCount = $overdueClimbers->count();

        return view('admin.guide', compact('guides', 'climbings', 'dailyData', 'monthlyData', 'overdueClimbers', 'notifCount')); 
    }

    public function storeGuide(Request $request) { 
        $request->validate(['name' => 'required', 'phone' => 'required', 'date_of_birth' => 'nullable|date']); 
        \App\Models\Guide::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'phone' => $request->phone, 
            'description' => $request->description, 
            'date_of_birth' => $request->date_of_birth
        ]); 
        return back()->with('success', 'Guide berhasil ditambahkan!'); 
    }

    public function editGuide($id) { $guide = \App\Models\Guide::findOrFail($id); return view('admin.guide-edit', compact('guide')); }
    public function updateGuide(Request $request, $id) { $guide = \App\Models\Guide::findOrFail($id); $guide->update($request->all()); return redirect()->route('admin.guide.index')->with('success', 'Data guide diperbarui!'); }
    public function destroyGuide($id) { $guide = \App\Models\Guide::findOrFail($id); $guide->delete(); return back()->with('success', 'Guide berhasil dihapus!'); }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request) { 
        Auth::guard('admin')->logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect()->route('admin.login'); 
    }

    public function index() {}
}