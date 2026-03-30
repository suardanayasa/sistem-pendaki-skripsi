<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClimbingController;
use App\Http\Controllers\TicketCounterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Manajemen Pendakian
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// =========================================================================
// ROUTE KHUSUS ADMIN
// =========================================================================
Route::prefix('admin')->group(function () {
    // Login - Menggunakan satu nama 'admin.login' agar konsisten
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Area yang harus Login sebagai Admin
    Route::middleware('auth:admin')->group(function () {
        
        // --- DASHBOARD UTAMA ---
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // --- STATISTIK (Hanya Grafik) ---
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('admin.statistik');

        // --- KEUANGAN (Laporan Pendapatan) ---
        Route::get('/keuangan', [AdminController::class, 'keuangan'])->name('admin.keuangan');
        
        // --- REKAP BULANAN (TAMBAHAN BARU) ---
        Route::get('/rekap-bulanan', [AdminController::class, 'rekapBulanan'])->name('admin.rekap');
        Route::get('/rekap-bulanan/excel', [AdminController::class, 'exportRekapExcel'])->name('admin.rekap.excel');
        Route::get('/rekap-bulanan/pdf', [AdminController::class, 'exportRekapPdf'])->name('admin.rekap.pdf');
        
        // --- MANAJEMEN PENJAGA TIKET (LOKET TIKET) ---
        Route::get('/ticket-counters', [AdminController::class, 'ticketCounter'])->name('admin.ticket-counter.index');
        Route::post('/ticket-counters', [AdminController::class, 'storeTicketCounter'])->name('admin.ticket-counter.store');
        Route::put('/ticket-counters/{id}', [AdminController::class, 'updateTicketCounter'])->name('admin.ticket-counter.update');
        Route::delete('/ticket-counters/{id}', [AdminController::class, 'destroyTicketCounter'])->name('admin.ticket-counter.destroy');

        // --- FITUR EXPORT LAPORAN ---
        Route::get('/report/excel', [AdminController::class, 'exportExcel'])->name('admin.report.excel');
        Route::get('/report/pdf', [AdminController::class, 'exportPdf'])->name('admin.report.pdf');

        // --- LOGOUT ADMIN ---
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // --- ROUTE CLIMBING ---
        Route::get('/climbing', [AdminController::class, 'climbing'])->name('admin.climbing');
        Route::delete('/climbing/{id}', [AdminController::class, 'destroyClimbing'])->name('admin.climbing.destroy');

        // --- ROUTE TIKET ---
        Route::get('/tiket', [AdminController::class, 'tiket'])->name('admin.tiket');

        // --- ROUTE GROUPS ---
        Route::get('/groups', [AdminController::class, 'group'])->name('admin.group.index');
        Route::post('/groups', [AdminController::class, 'storeGroup'])->name('admin.group.store');

        // --- ROUTE GUIDE ---
        Route::get('/guide', [AdminController::class, 'guide'])->name('admin.guide.index'); 
        Route::post('/guide', [AdminController::class, 'storeGuide'])->name('admin.guide.store'); 
        Route::get('/guide/{id}/edit', [AdminController::class, 'editGuide'])->name('admin.guide.edit'); 
        Route::put('/guide/{id}', [AdminController::class, 'updateGuide'])->name('admin.guide.update'); 
        Route::delete('/guide/{id}', [AdminController::class, 'destroyGuide'])->name('admin.guide.destroy'); 
    });
});

// =========================================================================
// ROUTE KHUSUS TICKET COUNTER (PETUGAS LOKET)
// =========================================================================
Route::prefix('ticket-counter')->group(function () {
    // Login Petugas
    Route::get('/login', [TicketCounterController::class, 'showLogin'])->name('ticket.login');
    Route::post('/login', [TicketCounterController::class, 'login'])->name('ticket.login.post');
    Route::post('/logout', [TicketCounterController::class, 'logout'])->name('ticket.logout');

    // Area yang harus Login sebagai Petugas
    Route::middleware('auth:ticket_counter')->group(function () {
        Route::get('/dashboard', [TicketCounterController::class, 'dashboard'])->name('ticket.dashboard');
        
        // Selesaikan Pendakian (Tombol Finish)
        Route::patch('/climbing/{id}/finish', [TicketCounterController::class, 'finish'])->name('climbing.finish');
    });
});

// =========================================================================
// ROUTE FORM PENDAFTARAN PENDAKI (UNTUK USER/UMUM)
// =========================================================================
Route::prefix('climbing')->group(function () {
    // Form Domestik
    Route::get('/domestic', [ClimbingController::class, 'createDomestic'])->name('climbing.domestic');
    Route::post('/domestic', [ClimbingController::class, 'storeDomestic'])->name('climbing.domestic.store');

    // Form Mancanegara
    Route::get('/foreign', [ClimbingController::class, 'createForeign'])->name('climbing.foreign');
    Route::post('/foreign', [ClimbingController::class, 'storeForeign'])->name('climbing.foreign.store');
});