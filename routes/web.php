<?php
use App\Http\Controllers\BreakageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BreakageController::class, 'showLookupForm']); // remove in production
Route::get('/lookup', [BreakageController::class, 'showLookupForm'])->name('lookup');
Route::post('/lookup', [BreakageController::class, 'lookupBreakage']);
Route::get('/submit', [BreakageController::class, 'showSubmitForm']);
Route::post('/submit', [BreakageController::class, 'submitBreakage']);
Route::get('/confirmation', function () {
  return view('confirmation');
})->name('confirmation');
