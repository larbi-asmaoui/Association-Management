<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepenseTypeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RevenueTypeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatutController;
use \App\Http\Controllers\AssociationController;
use \App\Http\Controllers\ReunionTypeController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AbonnementController;

/*
|------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(
    function () {
        Route::resource('users', UserController::class)->middleware('role:admin');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/activities/calendrier', [ActivityController::class, 'calender'])->name('activities.calender');

        Route::post('adherents/desactivate', [AdherentController::class, 'deactivateAll'])->name('adherents.desactivate');
        Route::resource('adherents', AdherentController::class);
        Route::get('adherents/{adherent}/print', [PrintController::class, 'printAdherentCard'])->name('adherents.print');

        Route::resource('abonnements', AbonnementController::class);
        Route::resource('groupes', GroupeController::class);
        Route::resource('stocks', StockController::class);
        Route::resource('activities', ActivityController::class);

        Route::resource('revenues', RevenueController::class);
        Route::resource('depenses', DepenseController::class);
        Route::resource('depense-types', DepenseTypeController::class);
        Route::resource('reunion-types', ReunionTypeController::class);
        Route::resource('revenue-types', RevenueTypeController::class);
        // Route::resource('cotisation-types', CotisationTypeController::class);
        Route::resource('stock-types', StockTypeController::class);
        Route::resource('activity-types', ActivityTypeController::class);
        Route::resource('status', StatutController::class);
        Route::resource('association', AssociationController::class)->middleware('role:admin');
        Route::resource('reunions', \App\Http\Controllers\ReunionController::class);
        Route::get('/e-documents', [App\Http\Controllers\DocumentsController::class, 'index'])->name('e-documents.index');
        // Route::get('/e-document/rapport-litteraire', [App\Http\Controllers\DocumentsController::class, 'generateRapportLitterairePdf'])->name('e-documents.rapport_litteraire');
        Route::get('/e-document/rapport-litteraire', [App\Http\Controllers\DocumentsController::class, 'generateRapportLitterairePdf'])->name('e-documents.rapport_litteraire');
        Route::get('/e-document/rapport-financier', [App\Http\Controllers\DocumentsController::class, 'generateRapportFinancierPdf'])->name('e-documents.rapport_financier');
    }
);
