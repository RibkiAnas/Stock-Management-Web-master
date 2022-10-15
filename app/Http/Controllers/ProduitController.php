<?php

namespace App\Http\Controllers;

use App\Models\Bon_commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::all();
        return view('produit.list-produits', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produit.add-produit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // this validation is so customizable
        Validator::make(
            $request->all(),
            [
                'produit_ref' => 'required|max:255|unique:produits,ref',
                'produit_libelle' => 'required|max:255',
                'produit_price' => 'required|numeric|min:0',
                'produit_price_buy' => 'required|numeric|min:0',
                'produit_qte' => 'required|numeric',
            ],
            [
                'required' => 'Le champs :attribute est obligatoire.',
                'unique' => 'Le champs :attribute doit être unique.',
                'numeric' => 'Le champs :attribute doit être numerique',
                'max'
            ],
            [
                'produit_ref' => 'REF',
                'produit_libelle' => 'Libellé',
                'produit_price' => 'Prix de vente',
                'produit_price_buy' => 'Prix d\'achat',
                'produit_qte' => 'Quantité',
            ]
        )->validate();

        // this validation is so limited
        // $validated = $request->validate([
        //     'produit_ref' => 'required|max:255|unique:produits,ref',
        //     'produit_libelle' => 'required|max:255',
        //     'produit_price' => 'required|numeric',
        // ]);

        $produit = Produit::create([
            'ref' => $request->produit_ref,
            'libelle' => $request->produit_libelle,
            'qte' => $request->produit_qte,
            'price' => $request->produit_price,
            'price_buy' => $request->produit_price_buy,
        ]);

        if ($produit) {
            if ($request->ajax()) {
                return $produit;
            }
            $status = 'Le produit était bien ajouté.';
        } else {
            $status = 'Insertion échoue.';
        }
        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        return view('produit.list-produit', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        $bon_commandes = Bon_commande::all();
        return view('produit.edit-produit', compact('produit', 'bon_commandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        Validator::make(
            $request->all(),
            [
                'produit_ref' => ($request->produit_ref != $produit->ref) ? 'required|unique:produits,ref' : 'required',
                'produit_libelle' => 'required|max:255',
                'produit_price' => 'required|numeric',
                'produit_qte' => 'required|numeric|min:0',
                'produit_price_buy' => 'required|numeric|min:0',
                'bon_commande' => [
                    function ($attribute, $value, $fail)
                    {
                        // check if the $value == "number" or == "".
                        if (!is_numeric($value) && Str::of($value)->isNotEmpty()){
                            $fail('there is some problems with params.');
                        }
                    }
                ]
            ],
            [
                'required' => 'Le champs :attribute est obligatoire.',
                'unique' => 'Le champs :attribute doit être unique.',
                'numeric' => 'Le champs :attribute doit être numerique',
                'max' => 'Le champs :attribute ne doit pas dépasser 255 caractère.',
            ],
            [
                'produit_ref' => 'REF',
                'produit_libelle' => 'Libellé',
                'produit_price' => 'Prix de vente',
                'produit_price_buy' => 'Prix d\'achat',
                'produit_qte' => 'Quantité',
            ]
        )->validate();
        // $validated = $request->validate([
        //     'produit_ref' => ($request->produit_ref != $produit->ref) ? 'required|unique:produits,ref' : 'required',
        //     'produit_libelle' => 'required|max:255',
        //     'produit_price' => 'required|numeric',
        // ]);
        $produit->ref = $request->produit_ref;
        $produit->libelle = $request->produit_libelle;
        $produit->price = $request->produit_price;
        $produit->price_buy = $request->produit_price_buy;
        $produit->qte = $request->produit_qte;
        if (is_numeric($request->bon_commande)) {
            $bon_commande = Bon_commande::find($request->bon_commande);
            $produit->bon_commande()->associate($bon_commande);
        }else {
            $produit->bon_commande()->disassociate();
        }
        if ($produit->update()) {
            if ($request->ajax()) {
                return $produit;
            }
            $status = 'Le produit était bien modifié.';
        } else {
            $status = 'Modification échoue.';
        }
        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        if ($produit->delete())
        {
            if (FacadesRequest::ajax()) {
                return $produit;
            }
            $status = "Le produit était bien supprimé.";
        }
        else
            $status = "Supprission échoue.";
        session()->flash('status', $status);

        return redirect(route('produit.index'));
    }
    public function getByBonCommandeId($bon_commande_id)
    {
        $produits = Bon_commande::find($bon_commande_id)->produits;
        return $produits;
    }
}
