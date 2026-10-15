<?php

use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\LeveringController;
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

Route::middleware('auth')->group(function () {
    Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
    Route::get('/leveranciers/{leverancierId}/producten', [LeverancierController::class, 'producten'])
        ->whereNumber('leverancierId')->name('leveranciers.producten');
    Route::get('/leveranciers/{leverancierId}/producten/{productId}/levering', [LeveringController::class, 'create'])
        ->whereNumber(['leverancierId', 'productId'])->name('leveringen.create');
    Route::post('/leveranciers/{leverancierId}/producten/{productId}/levering', [LeveringController::class, 'store'])
        ->whereNumber(['leverancierId', 'productId'])->name('leveringen.store');
});
