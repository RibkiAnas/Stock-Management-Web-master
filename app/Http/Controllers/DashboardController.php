<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index($filter_value)
    {
        $nb_clients = $this->getNbClients($filter_value);
        $nb_fournisseurs = $this->getNbFournisseurs($filter_value);
        $nb_clients_with_credit = $this->getNbClientsWithCredit();
        $nb_fournisseurs_with_dette = $this->getNbFournisseursWithDette();
        $credit = $this->getCredit();
        $dette = $this->getDette();
        $gains = $this->getGains($filter_value);
        $expenses = $this->getExpenses($filter_value);
        $produits_with_small_qte = $this->produitsWithSmallQte(5);
        return view('dashboard', compact('nb_clients', 'nb_fournisseurs', 'nb_clients_with_credit', 'nb_fournisseurs_with_dette', 'credit', 'dette', 'gains', 'expenses', 'produits_with_small_qte'));
    }
    function getNbClients($filter_value)
    {
        $nb_clients = 0;
        if ($filter_value == 'today') {
            $nb_clients = Client::where('created_at', 'like', '%' . date_format(today(), 'Y-m-d') . '%')->count();
        }
        elseif ($filter_value == 'global') {
            $nb_clients = Client::count();
        }
        return $nb_clients;
    }
    function getNbFournisseurs($filter_value)
    {
        $nb_fournisseurs = 0;
        if ($filter_value == 'today') {
            $nb_fournisseurs = Fournisseur::where('created_at', 'like', '%' . date_format(today(), 'Y-m-d') . '%')->count();
        }
        elseif ($filter_value == 'global') {
            $nb_fournisseurs = Fournisseur::count();
        }
        return $nb_fournisseurs;
    }
    function getCredit()
    {
        $credit = Client::sum('credit');
        return $credit;
    }
    function getDette()
    {
        $dette = Fournisseur::sum('dette');
        return $dette;
    }
    function getNbClientsWithCredit()
    {
        $nb_clients_with_credit = Client::where('credit', '<>', 0)->count();
        return $nb_clients_with_credit;
    }
    function getNbFournisseursWithDette()
    {
        $nb_fournisseurs_with_dette = Fournisseur::where('dette', '<>', 0)->count();
        return $nb_fournisseurs_with_dette;
    }
    function getGains($filter_value)
    {
        $gains = 0;
        if ($filter_value == 'today') {
            // calculate invoices without quotations:
            $gains = DB::table('facture_produit')
                ->join('factures', 'facture_produit.facture_id', '=', 'factures.num')
                ->join('produits', 'facture_produit.produit_id', '=', 'produits.id')
                ->selectRaw('SUM(produits.price*quantity)*0.2 + SUM(produits.price*quantity) as total_price')
                ->where('facture_produit.created_at', 'like', '%' . date_format(today(), 'Y-m-d') . '%')
                ->first()
                ->total_price;
            // add global price of invoices with quotations:
            $gains += DB::table('devie_produit')
                ->join('produits', 'devie_produit.produit_id', '=', 'produits.id')
                ->join('devies', 'devie_produit.devie_id', '=', 'devies.num')
                ->join('factures', 'devies.num', '=', 'factures.devie_id')
                ->selectRaw('SUM(produits.price*quantity)*0.2 + SUM(produits.price*quantity) as total_price')
                ->where('devie_produit.created_at', 'like', '%' . date_format(today(), 'Y-m-d') . '%')
                ->first()
                ->total_price;
        }
        elseif ($filter_value == 'global') {
            $gains = DB::table('facture_produit')
                ->join('factures', 'facture_produit.facture_id', '=', 'factures.num')
                ->join('produits', 'facture_produit.produit_id', '=', 'produits.id')
                ->selectRaw('SUM(produits.price*quantity)*0.2 + SUM(produits.price*quantity) as total_price')
                ->first()
                ->total_price;
            // add global price of invoices with quotations:
            $gains += DB::table('devie_produit')
                ->join('produits', 'devie_produit.produit_id', '=', 'produits.id')
                ->join('devies', 'devie_produit.devie_id', '=', 'devies.num')
                ->join('factures', 'devies.num', '=', 'factures.devie_id')
                ->selectRaw('SUM(produits.price*quantity)*0.2 + SUM(produits.price*quantity) as total_price')
                ->first()
                ->total_price;
        }
        return $gains;
    }
    function getExpenses($filter_value)
    {
        $expenses = 0;
        if ($filter_value == 'today') {
            // calculate invoices without quotations:
            $expenses = Produit::where('created_at', 'like', '%' . date_format(today(), 'Y-m-d') . '%')
                ->selectRaw('SUM(price_buy*qte) as expenses')
                ->first()
                ->expenses;
        }
        elseif ($filter_value == 'Global') {
            $expenses = Produit::selectRaw('SUM(price_buy*qte) as expenses')
                ->first()
                ->expenses;
        }
        return $expenses;
    }
    public function clientsWithCredit()
    {
        $clients_with_credit = Client::where('credit', '<>', 0)->get();
        return $clients_with_credit;
    }
    public function fournisseursWithDette()
    {
        $fournisseurs_with_dette = Fournisseur::where('dette', '<>', 0)->get();
        return $fournisseurs_with_dette;
    }
    public function produitsWithSmallQte($min_qte)
    {
        $produits_with_small_qte = Produit::where('qte', '<=', $min_qte)->get();
        return $produits_with_small_qte;
    }
}