<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

Route::get('/getContacts', [ContactController::class, 'getContacts']);
Route::get('/exportData', [ContactController::class, 'exportData']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
