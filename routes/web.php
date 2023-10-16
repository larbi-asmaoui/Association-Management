<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepenseTypeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\GroupeController;
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
use App\Http\Controllers\BureauController;
use App\Http\Controllers\CartesController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\DiplomeController;
use DragonCode\Contracts\Cashier\Http\Request;

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

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('depense-types', DepenseTypeController::class);
        Route::resource('reunion-types', ReunionTypeController::class);
        Route::resource('revenue-types', RevenueTypeController::class);
        Route::resource('stock-types', StockTypeController::class);
        Route::resource('activity-types', ActivityTypeController::class);




        Route::middleware(['can:manage info'])->group(function () {
            Route::put('/statut/associate/{id}', [StatutController::class, 'associatePosteWithAdherent'])->name('status.associate');
            Route::resource('association', AssociationController::class);
            Route::resource('statuts', StatutController::class);
        });

        Route::middleware(['can:manage classes'])->group(function () {
            Route::resource('classes', \App\Http\Controllers\ClasseController::class);
            Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        });

        Route::middleware(['can:manage reunions'])->group(function () {
            Route::resource('reunions', \App\Http\Controllers\ReunionController::class);
        });

        Route::middleware(['can:manage docs'])->group(function () {
            Route::get('/e-documents', [App\Http\Controllers\DocumentsController::class, 'index'])->name('e-documents.index');
            Route::get('/e-document/rapport-litteraire', [App\Http\Controllers\DocumentsController::class, 'generateRapportLitterairePdf'])->name('e-documents.rapport_litteraire');
            Route::get('/e-document/rapport-financier', [App\Http\Controllers\DocumentsController::class, 'generateRapportFinancierPdf'])->name('e-documents.rapport_financier');
        });

        Route::middleware(['can:manage revenus'])->group(function () {
            Route::resource('revenues', RevenueController::class);
        });

        Route::middleware(['can:manage depenses'])->group(function () {
            Route::resource('depenses', DepenseController::class);
        });
        Route::middleware(['can:manage supervisors'])->group(function () {
            Route::delete('/supervisors/diplomes/{id}', [SupervisorController::class, 'deleteDiplome']);
            Route::post('/supervisors/{supervisor}/diplomes', [SupervisorController::class, 'addDiplome']);
            Route::post('/supervisors/{supervisor}/classes', [SupervisorController::class, 'attachClasse']);
            Route::delete('/supervisors/{supervisor}/classes/{classe}', [SupervisorController::class, 'detachClasse']);
            Route::put('/supervisors/updateImage/{id}', [\App\Http\Controllers\SupervisorController::class, 'updateImage'])->name('supervisors.updateImage');
            Route::resource('supervisors', \App\Http\Controllers\SupervisorController::class);
        });
        Route::middleware(['can:manage adherents'])->group(function () {
            Route::post('adherents/desactivate', [AdherentController::class, 'deactivateAll'])->name('adherents.desactivate');
            Route::resource('adherents', AdherentController::class);
            Route::resource('cartes', CartesController::class);
        });
        Route::middleware(['can:manage users'])->group(function () {
            Route::resource('users', UserController::class);
        });

        Route::middleware(['can:manage abonnements'])->group(function () {
            Route::resource('abonnements', AbonnementController::class);
        });
        Route::middleware(['can:manage groupes'])->group(function () {
            Route::resource('groupes', GroupeController::class);
        });

        Route::middleware(['can:manage stocks'])->group(function () {
            Route::resource('stocks', StockController::class);
        });
        Route::middleware(['can:manage activites'])->group(function () {
            Route::get('/activities/calendrier', [ActivityController::class, 'calender'])->name('activities.calender');
            Route::resource('activities', ActivityController::class);
        });

        Route::get('/bureau', [BureauController::class, 'index'])->name('bureau');
    }
);
