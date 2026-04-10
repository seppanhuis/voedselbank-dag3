<?php

use App\Http\Controllers\AllergieController;
use App\Http\Controllers\KlantController;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\VoedselpakketController;
use App\Http\Controllers\VoedselpakketDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leverancier.index');
Route::get('/leveranciers/{leverancierId}/producten', [LeverancierController::class, 'showProducten'])
    ->name('leverancier.producten');
Route::get('/leveranciers/product/{productPerLeverancierId}/wijzig', [LeverancierController::class, 'editProduct'])
    ->name('leverancier.product.edit');
Route::put('/leveranciers/product/{productPerLeverancierId}', [LeverancierController::class, 'updateProduct'])
    ->name('leverancier.product.update');

Route::get('/voedselpakketten', [VoedselpakketController::class, 'index'])->name('voedselpakket.index');
Route::get('/voedselpakketten/{gezinId}', [VoedselpakketDetailController::class, 'show'])
    ->name('voedselpakket.details');
Route::get('/voedselpakketten/{pakketId}/wijzig', [VoedselpakketDetailController::class, 'edit'])
    ->name('voedselpakket.edit');
Route::post('/voedselpakketten/{pakketId}', [VoedselpakketDetailController::class, 'update'])
    ->name('voedselpakket.update');

Route::get('/allergieen', [AllergieController::class, 'index'])->name('allergie.index');
Route::get('/allergieen/gezin/{gezinId}', [AllergieController::class, 'showGezin'])->name('allergie.gezin.show');
Route::get('/allergieen/persoon/{persoonId}/wijzig', [AllergieController::class, 'editPersoon'])->name('allergie.persoon.edit');
Route::put('/allergieen/persoon/{persoonId}', [AllergieController::class, 'updatePersoon'])->name('allergie.persoon.update');

Route::get('/klanten', [KlantController::class, 'index'])->name('klant.index');
Route::get('/klanten/{id}', [KlantController::class, 'show'])->name('klant.show');
Route::get('/klanten/{id}/wijzig', [KlantController::class, 'edit'])->name('klant.edit');
Route::put('/klanten/{id}', [KlantController::class, 'update'])->name('klant.update');
