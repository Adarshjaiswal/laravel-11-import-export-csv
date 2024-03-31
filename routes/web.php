<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/getContacts', [ContactController::class, 'getContacts']);

Route::middleware('auth')->group(function () {
    Route::get('/import-export', [ContactController::class, 'index'])->name('importexport');
    Route::get('/contact-view', [ContactController::class, 'contactview'])->name('contacts-view');
    Route::post('/import', [ContactController::class, 'import'])->name('import.customers');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
