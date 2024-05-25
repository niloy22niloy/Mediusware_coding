<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/deposit', [AccountController::class, 'deposit'])->name('deposit');
    Route::post('/deposit', [AccountController::class, 'deposit_post'])->name('deposit');

    Route::get('/withdraw', [AccountController::class, 'withdraw_list'])->name('withdraw');
    
    Route::post('/withdraw', [AccountController::class, 'withdraw'])->name('withdraw');
    

   

});

require __DIR__.'/auth.php';
