<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\CotisationTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DepenseTypeController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EvenementTypeController;
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
use Illuminate\Http\Request;

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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(
    function () {
        // Route::get('/only-once', function (Request $request) {
        //     if ($request->session()->has('visited')) {
        //         abort(403, "You can't visit this page again.");
        //     }

        //     $request->session()->put('visited', true);

        //     return "This is a one-time page visit. You will not be able to visit this page again.";
        // });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/evenements/calendrier', [EvenementController::class, 'calender'])->name('evenements.calender');


        Route::resource('adherents', AdherentController::class);
        Route::get('adherents/{adherent}/print', [PrintController::class, 'printAdherentCard'])->name('adherents.print');
        Route::resource('cotisations', CotisationController::class);
        Route::resource('groupes', GroupeController::class);
        Route::resource('stocks', StockController::class);
        Route::resource('evenements', EvenementController::class);

        Route::resource('revenues', RevenueController::class);
        Route::resource('depenses', DepenseController::class);
        Route::resource('depense-types', DepenseTypeController::class);
        Route::resource('reunion-types', ReunionTypeController::class);
        Route::resource('revenue-types', RevenueTypeController::class);
        Route::resource('cotisation-types', CotisationTypeController::class);
        Route::resource('stock-types', StockTypeController::class);
        Route::resource('evenement-types', EvenementTypeController::class);
        Route::resource('status', StatutController::class);
        Route::resource('association', AssociationController::class);
        Route::resource('reunions', \App\Http\Controllers\ReunionController::class);
        Route::get('/e-documents', [App\Http\Controllers\DocumentsController::class, 'index'])->name('e-documents.index');
        // Route::get('/e-document/rapport-litteraire', [App\Http\Controllers\DocumentsController::class, 'generateRapportLitterairePdf'])->name('e-documents.rapport_litteraire');
        Route::get('/e-document/rapport-litteraire', [App\Http\Controllers\DocumentsController::class, 'generateRapportLitterairePdf'])->name('e-documents.rapport_litteraire');
        Route::get('/e-document/rapport-financier', [App\Http\Controllers\DocumentsController::class, 'generateRapportFinancierPdf'])->name('e-documents.rapport_financier');
    }
);
