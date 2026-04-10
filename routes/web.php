<?php

use App\Http\Controllers\AllergieController;
use App\Http\Controllers\LeverancierController;
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

Route::get('/allergieen', [AllergieController::class, 'index'])->name('allergie.index');
Route::get('/allergieen/gezin/{gezinId}', [AllergieController::class, 'showGezin'])->name('allergie.gezin.show');
Route::get('/allergieen/persoon/{persoonId}/wijzig', [AllergieController::class, 'editPersoon'])->name('allergie.persoon.edit');
Route::put('/allergieen/persoon/{persoonId}', [AllergieController::class, 'updatePersoon'])->name('allergie.persoon.update');
