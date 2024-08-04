<?php

use App\Http\Controllers\TrixController;
use Illuminate\Support\Facades\Route;

Route::get('trix', [TrixController::class, 'index']);
Route::post('trix/upload', [TrixController::class, 'upload'])->name('trix.upload');
