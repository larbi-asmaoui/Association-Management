<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdherantController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //---------- Adherants ----------//
    Route::prefix('/adherants')->group(function () {
        Route::get('/', [AdherantController::class, 'index'])->name('adherants.index');
    });

    //---------- Groupes ----------//
    Route::prefix('/groupes')->group(function () {
        Route::get('/', [GroupeController::class, 'index'])->name('groupes.index');
        // Route::get('/editMe', function () {
        //     return Inertia::render('Welcome');
        // });
    });
});
