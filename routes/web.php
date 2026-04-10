<?php

use App\Http\Controllers\AllergieController;
use App\Http\Controllers\VoedselpakketController;
use App\Http\Controllers\VoedselpakketDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/allergieen', [AllergieController::class, 'index'])->name('allergie.index');
Route::get('/allergieen/gezin/{gezinId}', [AllergieController::class, 'showGezin'])->name('allergie.gezin.show');
Route::get('/allergieen/persoon/{persoonId}/wijzig', [AllergieController::class, 'editPersoon'])->name('allergie.persoon.edit');
Route::put('/allergieen/persoon/{persoonId}', [AllergieController::class, 'updatePersoon'])->name('allergie.persoon.update');
Route::get('/voedselpakketten', [VoedselpakketController::class, 'index'])->name('voedselpakket.index');
Route::get('/voedselpakketten/gezin/{gezinId}', [VoedselpakketDetailController::class, 'show'])->name('voedselpakket.details');
Route::get('/voedselpakketten/pakket/{pakketId}/edit', [VoedselpakketDetailController::class, 'edit'])->name('voedselpakket.edit');
Route::put('/voedselpakketten/pakket/{pakketId}', [VoedselpakketDetailController::class, 'update'])->name('voedselpakket.update');
Route::get('/voedselpakketten/pakket/{pakketId}', [VoedselpakketDetailController::class, 'show'])->name('voedselpakket.show');
