<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdherantController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\DepenseTypeController;
use App\Http\Controllers\RevenueTypeController;
use App\Http\Controllers\CotisationTypeController;
use App\Http\Controllers\StockTypeController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\EvenementTypeController;
use App\Http\Controllers\DepenseController;


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

    // ---------Reveneues ------------ //
    Route::prefix('/revenues')->group(function () {
        Route::get('/', [RevenueController::class, 'index'])->name('revenues.index');
        Route::delete('/{revenue}', [RevenueController::class, 'destroy'])->name('revenues.destroy');
        Route::get('/create', [RevenueController::class, 'create'])->name('revenues.create');
        Route::post('/', [RevenueController::class, 'store'])->name('revenues.store');
        Route::get('/{revenue}', [RevenueController::class, 'show'])->name('revenues.show');
        Route::get('/{revenue}/edit', [RevenueController::class, 'edit'])->name('revenues.edit');
        Route::put('/{revenue}', [RevenueController::class, 'update'])->name('revenues.update');
    });

    //-----------Depenses------------//
    Route::prefix('/depenses')->group(function () {
        Route::get('/', [DepenseController::class, 'index'])->name('depenses.index');
        Route::delete('/{depense}', [DepenseController::class, 'destroy'])->name('depenses.destroy');
        Route::get('/create', [DepenseController::class, 'create'])->name('depenses.create');
        Route::post('/', [DepenseController::class, 'store'])->name('depenses.store');
        Route::get('/{depense}', [DepenseController::class, 'show'])->name('depenses.show');
        Route::get('/{depense}/edit', [DepenseController::class, 'edit'])->name('depenses.edit');
        Route::put('/{depense}', [DepenseController::class, 'update'])->name('depenses.update');
    });

    // ----------DepenseTypes----------//
    Route::prefix('/depense-types')->group(function () {
        Route::get('/', [DepenseTypeController::class, 'index'])->name('depense-types.index');
        Route::delete('/{depenseType}', [DepenseTypeController::class, 'destroy'])->name('depense-types.destroy');
        Route::get('/create', [DepenseTypeController::class, 'create'])->name('depense-types.create');
        Route::post('/', [DepenseTypeController::class, 'store'])->name('depense-types.store');
        Route::get('/{depenseType}', [DepenseTypeController::class, 'show'])->name('depense-types.show');
        Route::get('/{depenseType}/edit', [DepenseTypeController::class, 'edit'])->name('depense-types.edit');
        Route::put('/{depenseType}', [DepenseTypeController::class, 'update'])->name('depense-types.update');
    });

    // ----------RevenueTypes----------//
    Route::prefix('/revenue-types')->group(function () {
        Route::get('/', [RevenueTypeController::class, 'index'])->name('revenue-types.index');
        Route::delete('/{revenueType}', [RevenueTypeController::class, 'destroy'])->name('revenue-types.destroy');
        Route::get('/create', [RevenueTypeController::class, 'create'])->name('revenue-types.create');
        Route::post('/', [RevenueTypeController::class, 'store'])->name('revenue-types.store');
        Route::get('/{revenueType}', [RevenueTypeController::class, 'show'])->name('revenue-types.show');
        Route::get('/{revenueType}/edit', [RevenueTypeController::class, 'edit'])->name('revenue-types.edit');
        Route::put('/{revenueType}', [RevenueTypeController::class, 'update'])->name('revenue-types.update');
    });

    // ----------CotisationTypes----------//
    Route::prefix('/cotisation-types')->group(function () {
        Route::get('/', [CotisationTypeController::class, 'index'])->name('cotisation-types.index');
        Route::delete('/{cotisationType}', [CotisationTypeController::class, 'destroy'])->name('cotisation-types.destroy');
        Route::get('/create', [CotisationTypeController::class, 'create'])->name('cotisation-types.create');
        Route::post('/', [CotisationTypeController::class, 'store'])->name('cotisation-types.store');
        Route::get('/{cotisationType}', [CotisationTypeController::class, 'show'])->name('cotisation-types.show');
        Route::get('/{cotisationType}/edit', [CotisationTypeController::class, 'edit'])->name('cotisation-types.edit');
        Route::put('/{cotisationType}', [CotisationTypeController::class, 'update'])->name('cotisation-types.update');
    });

    // ----------StockTypes----------//
    Route::prefix('/stock-types')->group(function () {
        Route::get('/', [StockTypeController::class, 'index'])->name('stock-types.index');
        Route::delete('/{stockType}', [StockTypeController::class, 'destroy'])->name('stock-types.destroy');
        Route::get('/create', [StockTypeController::class, 'create'])->name('stock-types.create');
        Route::post('/', [StockTypeController::class, 'store'])->name('stock-types.store');
        Route::get('/{stockType}', [StockTypeController::class, 'show'])->name('stock-types.show');
        Route::get('/{stockType}/edit', [StockTypeController::class, 'edit'])->name('stock-types.edit');
        Route::put('/{stockType}', [StockTypeController::class, 'update'])->name('stock-types.update');
    });

    // ---------Evenement Types ------------ //
    Route::prefix('/evenement-types')->group(function () {

        Route::get('/', [EvenementTypeController::class, 'index'])->name('evenement-types.index');
        Route::put('/{evenementType}', [EvenementTypeController::class, 'update'])->name('evenement-types.update');
        Route::delete('/{evenementType}', [EvenementTypeController::class, 'destroy'])->name('evenement-types.destroy');
        Route::get('/create', [EvenementTypeController::class, 'create'])->name('evenement-types.create');
        Route::post('/', [EvenementTypeController::class, 'store'])->name('evenement-types.store');

        Route::get('/{evenementType}', [EvenementTypeController::class, 'show'])->name('evenement-types.show');
        Route::get('/{evenementType}/edit', [EvenementTypeController::class, 'edit'])->name('evenement-types.edit');
    });
});
