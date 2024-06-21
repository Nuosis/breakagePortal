<?php
use App\Http\Controllers\BreakageController;
use Illuminate\Support\Facades\Route;

Route::get('/lookup', [BreakageController::class, 'showLookupForm']);
Route::post('/lookup', [BreakageController::class, 'lookupBreakage']);
Route::get('/submit', [BreakageController::class, 'showSubmitForm']);
Route::post('/submit', [BreakageController::class, 'submitBreakage']);

