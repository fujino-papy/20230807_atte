<?php

use App\Http\Controllers\StampController;
use App\Http\Controllers\RestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;
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


Route::get('/dashboard', function () {
    $stampController = new StampController();
    $restController = new RestController();

    // StampController の home アクションを呼び出し
    $stampResponse = $stampController->home();

    // RestController の home アクションを呼び出し
    $restResponse = $restController->home();

    // StampController の home アクションがリダイレクトを返す場合
    if ($stampResponse instanceof RedirectResponse) {
        return $stampResponse;
    }

    // RestController の home アクションがリダイレクトを返す場合
    if ($restResponse instanceof RedirectResponse) {
        return $restResponse;
    }

    // どちらのアクションもリダイレクトを返さない場合、/stamp/home にリダイレクト
    return redirect()->route('stamp.home');

})->name('home');

    // StampController ルーティング
    Route::get('/stamp/home', [StampController::class, 'home'])->name('stamp.home');
    Route::post('/stamp/start', [StampController::class, 'startWork'])->name('stamp.start');
    Route::post('/stamp/end', [StampController::class, 'endWork'])->name('stamp.end');
    Route::get('/stamp/list', [StampController::class, 'list'])->name('list');

    // RestController ルーティング
    Route::get('/rest/home', [RestController::class, 'home'])->name('rest.home');
    Route::post('/rest/start', [RestController::class, 'startRest'])->name('rest.start');
    Route::post('/rest/end', [RestController::class, 'endRest'])->name('rest.end');

require __DIR__.'/auth.php';
