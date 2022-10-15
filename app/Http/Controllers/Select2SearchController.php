<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class Select2SearchController extends Controller
{
    public function selectSearchClient(Request $request)
    {
    	$clients = [];

        if($request->has('q')){
            $search  = $request->q;
            $clients = Client::select("id", "nom_complet")
            		->where('nom_complet', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($clients);
    }

    public function selectSearchProduit(Request $request)
    {
    	$produits = [];
        if($request->has('q')){
            $search  = $request->q;
            $produits = Produit::select("id", "ref", "libelle","price","qte")
            		->where('ref', 'LIKE', "%$search%")
                    ->orWhere('libelle', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($produits);
    }

    public function selectSearchFournisseur(Request $request) 
    {
        $fournisseurs = [];
        if($request->has('q')){
            $search  = $request->q;
            $fournisseurs = Fournisseur::select("id", "nom_complet")
            		->where('nom_complet', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($fournisseurs);
    }
}
