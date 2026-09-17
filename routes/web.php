<?php

use App\Http\Controllers\MagazijnController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/magazijn', [MagazijnController::class, 'index'])
        ->name('magazijn');

    Route::get('/magazijn/{productId}/levering', [MagazijnController::class, 'levering'])
        ->name('magazijn.levering');

    Route::get('/magazijn/{productId}/allergenen', [MagazijnController::class, 'allergenen'])
        ->name('magazijn.allergenen');
});

require __DIR__.'/settings.php';
