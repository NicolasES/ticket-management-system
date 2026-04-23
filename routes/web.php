<?php

use App\Http\Controllers\SimulateSystemController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});


// Route::get('/', SimulateSystemController::class)->name('home');
Route::get('/simulate', SimulateSystemController::class)->name('simulate');


require __DIR__.'/settings.php';
