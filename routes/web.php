<?php

use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\devie\ListDeviesController;
use App\Http\Controllers\DevieController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintingController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\Select2SearchController;
use App\Http\Middleware\CheckAuthenticationGlobal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'auth.login')->name('login-view')->middleware('auth.check');
Route::middleware(CheckAuthenticationGlobal::class)->group(function () {
    
    Route::get('/produit/byBonCommande/{bon_commande_id}', [ProduitController::class, 'getByBonCommandeId']);
    Route::resources(
        [
            'client' => ClientController::class,
            'fournisseur' => FournisseurController::class,
            'bon_commande' => BonCommandeController::class,
            'devie' => DevieController::class,
            'produit' => ProduitController::class,
            'facture' => FactureController::class,
        ]
    );
    Route::post('convertToInvoice', [ListDeviesController::class, 'convertDevisToInvoice'])->name('covertToInvoice');
    Route::get('/dashboard/{filter_value}', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('ajax-autocomplete-search', [Select2SearchController::class,'selectSearchClient']);
    Route::get('ajax-autocomplete-search-produit', [Select2SearchController::class,'selectSearchProduit']);
    Route::get('/dashboard/clients/credit', [DashboardController::class, 'clientsWithCredit'])->name('clients-credit');
    Route::get('/dashboard/fournisseurs/dette', [DashboardController::class, 'fournisseursWithDette'])->name('fournisseurs-dette');
    Route::get('impression/{id}/{type}', [PrintingController::class, 'imprimer'])->name('impression');
    Route::get('ajax-autocomplete-search-fournisseur', [Select2SearchController::class,'selectSearchFournisseur']);
});
Auth::routes();
