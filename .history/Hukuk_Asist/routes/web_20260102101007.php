<?php

use App\Http\Controllers\EventAnalysisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ana sayfa - Olay analiz formu
Route::get('/', [EventAnalysisController::class, 'index'])->name('event-analysis.index');

// Olay analizi
Route::post('/analyze', [EventAnalysisController::class, 'analyze'])->name('event-analysis.analyze');
