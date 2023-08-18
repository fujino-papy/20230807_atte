<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\RestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    });

//Route::get('/stamp/home', function () {return view('stamp');});//

Route::post('/stamp/start', [StampController::class, 'startWork']);
Route::post('/stamp/end', [StampController::class, 'endWork']);

Route::post('/rest/start', [RestController::class, 'startRest']);
Route::post('/rest/end', [RestController::class, 'endRest']);

Route::get('/stamp/home', [StampController::class, 'home'])->name('stamp.home');
Route::post('/stamp/start', [StampController::class, 'startWork'])->name('stamp.start');
Route::post('/stamp/end', [StampController::class, 'endWork'])->name('stamp.end');

// RestController ルーティング
Route::get('/rest/home', [RestController::class, 'home'])->name('rest.home');
Route::post('/rest/start', [RestController::class, 'startRest'])->name('rest.start');
Route::post('/rest/end', [RestController::class, 'endRest'])->name('rest.end');
//Route::get('/stamp/home', [StampController::class, 'home'])->middleware(['auth'])->name('home');//

Route::get('/dashboard', function () {
    return view('/stamp');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
