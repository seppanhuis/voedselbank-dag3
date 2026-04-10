<?php

use App\Http\Controllers\AllergieController;
use App\Http\Controllers\KlantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/allergieen', [AllergieController::class, 'index'])->name('allergie.index');
Route::get('/allergieen/gezin/{gezinId}', [AllergieController::class, 'showGezin'])->name('allergie.gezin.show');
Route::get('/allergieen/persoon/{persoonId}/wijzig', [AllergieController::class, 'editPersoon'])->name('allergie.persoon.edit');
Route::put('/allergieen/persoon/{persoonId}', [AllergieController::class, 'updatePersoon'])->name('allergie.persoon.update');

Route::get('/klanten', [KlantController::class, 'index'])->name('klant.index');
Route::get('/klanten/{id}', [KlantController::class, 'show'])->name('klant.show');
Route::get('/klanten/{id}/wijzig', [KlantController::class, 'edit'])->name('klant.edit');
Route::put('/klanten/{id}', [KlantController::class, 'update'])->name('klant.update');
