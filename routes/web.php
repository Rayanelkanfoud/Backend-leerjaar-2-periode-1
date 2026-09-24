<?php

use App\Http\Controllers\MagazijnController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::get(
    '/magazijn',
    [MagazijnController::class, 'index']
)->name('magazijn');

Route::get(
    '/magazijn/{id}/leverantie',
    [MagazijnController::class, 'leverantie']
)->name('magazijn.leverantie');

Route::get(
    '/magazijn/{id}/allergenen',
    [MagazijnController::class, 'allergenen']
)->name('magazijn.allergenen');

require __DIR__.'/settings.php';