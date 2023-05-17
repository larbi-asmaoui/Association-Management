<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\AdherantController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PrintController;

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

    //---------- Dashboard ----------//
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //---------- Adherants ----------//
    Route::prefix('/adherants')->group(function () {
        Route::get('/', [AdherantController::class, 'index'])->name('adherants.index');
        Route::delete('/{adherant}', [AdherantController::class, 'destroy'])->name('adherants.destroy');
        Route::get('/create', [AdherantController::class, 'create'])->name('adherants.create');
        Route::post('/', [AdherantController::class, 'store'])->name('adherants.store');
        Route::get('/{adherant}/print', [PrintController::class, 'printAdherentCard'])->name('adherants.print');
        Route::get('/{adherant}', [AdherantController::class, 'show'])->name('adherants.show');
        Route::get('/{adherant}/edit', [AdherantController::class, 'edit'])->name('adherants.edit');
        Route::put('/{adherant}', [AdherantController::class, 'update'])->name('adherants.update');
    });

    // ------------Cotisations------------//
    Route::prefix('/cotisations')->group(function () {
        Route::get('/', [CotisationController::class, 'index'])->name('cotisations.index');
        Route::delete('/{cotisation}', [CotisationController::class, 'destroy'])->name('cotisations.destroy');
        Route::get('/create', [CotisationController::class, 'create'])->name('cotisations.create');
        Route::post('/', [CotisationController::class, 'store'])->name('cotisations.store');
        Route::get('/{cotisation}', [CotisationController::class, 'show'])->name('cotisations.show');
        Route::get('/{cotisation}/edit', [CotisationController::class, 'edit'])->name('cotisations.edit');
        Route::put('/{cotisation}', [CotisationController::class, 'update'])->name('cotisations.update');
    });

    //---------- Groupes ----------//
    Route::prefix('/groupes')->group(function () {
        Route::get('/', [GroupeController::class, 'index'])->name('groupes.index');
        Route::delete('/{groupe}', [GroupeController::class, 'destroy'])->name('groupes.destroy');
        Route::get('/create', [GroupeController::class, 'create'])->name('groupes.create');
        Route::post('/', [GroupeController::class, 'store'])->name('groupes.store');
        Route::get('/{groupe}', [GroupeController::class, 'show'])->name('groupes.show');
        Route::get('/{groupe}/edit', [GroupeController::class, 'edit'])->name('groupes.edit');
        Route::put('/{groupe}', [GroupeController::class, 'update'])->name('groupes.update');
    });

    //---------- Stocks ----------//
    Route::prefix('/stocks')->group(function () {
        // All routes are defined in the StockController
        Route::get('/', [StockController::class, 'index'])->name('stocks.index');
        Route::delete('/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');
        Route::post('/', [StockController::class, 'store'])->name('stocks.store');
        Route::get('/{stock}', [StockController::class, 'show'])->name('stocks.show');
        Route::put('/{stock}', [StockController::class, 'update'])->name('stocks.update');
    });

    //---------- Evenements ----------//
    Route::prefix('/evenements')->group(function () {
        Route::get('/', [EvenementController::class, 'index'])->name('evenements.index');
        Route::get('/calendrier', [EvenementController::class, 'calender'])->name('evenements.calender');
        Route::delete('/{evenement}', [EvenementController::class, 'destroy'])->name('evenements.destroy');
        Route::put('/{evenement}', [EvenementController::class, 'update'])->name('evenements.update');
        Route::get('/create', [EvenementController::class, 'create'])->name('evenements.create');
        Route::post('/', [EvenementController::class, 'store'])->name('evenements.store');
        Route::get('/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');
        Route::get('/{evenement}/edit', [EvenementController::class, 'edit'])->name('evenements.edit');
    });
});
// Route::get('/chart', [ChartController::class, 'index'])->name('chart');
