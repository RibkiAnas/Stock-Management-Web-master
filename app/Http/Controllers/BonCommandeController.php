<?php

namespace App\Http\Controllers;

use App\Models\Bon_commande;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BonCommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bons = Bon_commande::all();
        return view('bon.list-bons', compact('bons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fournisseurs = Fournisseur::all();
        return view('bon.add-bon', compact('fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bon_commande_num' => 'required|max:255|unique:bon_commandes,num',
            'produits' => [
                'required',
                // this will be used to customize validation:
                function ($attribute, $value, $fail) {
                    $produits_ids = Str::of($value)->explode(',');
                    foreach ($produits_ids as $id) {
                        if (!is_numeric($id)) {
                            $fail('there is some problems with params.');
                        }
                    }
                }
            ],
        ]);

        $bon_commande = new Bon_commande(['num' => $request->bon_commande_num]);
        $fournisseur = Fournisseur::find($request->fournisseur);

        if ($fournisseur) {
            $fournisseur->bon_commandes()->save($bon_commande); // associate the supplier with his order form.

            // to associate an order form with its products:
            $produits_ids = Str::of($request->produits)->explode(',');
            foreach ($produits_ids as $id) {
                $produit = Produit::find($id);
                $produit->bon_commande()->associate($bon_commande);
                $produit->save();
            }

            $status = 'Le bon de commande était bien ajouté.';
        } else {
            $status = 'Insertion échoue.';
        }

        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bon_commande  $bon_commande
     * @return \Illuminate\Http\Response
     */
    public function show(Bon_commande $bon_commande)
    {
        return view('bon.list-bon', compact('bon_commande'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bon_commande  $bon_commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Bon_commande $bon_commande)
    {
        $fournisseurs = Fournisseur::all();
        return view('bon.edit-bon', compact('bon_commande', 'fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bon_commande  $bon_commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bon_commande $bon_commande)
    {
        $validated = $request->validate([
            'bon_commande_num' => ($request->bon_commande_num != $bon_commande->num) ? 'required|max:255|unique:bon_commandes,num' : 'required',
            'produits' => [
                'required',
                // this will be used to customize validation:
                function ($attribute, $value, $fail) {
                    $produits_ids = Str::of($value)->explode(',');
                    foreach ($produits_ids as $id) {
                        if (!is_numeric($id)) {
                            $fail('there is some problems with params.');
                        }
                    }
                }
            ],
        ]);

        $fournisseur = Fournisseur::find($request->fournisseur);
        if ($fournisseur) {
            $bon_commande->fournisseur()->associate($fournisseur);
            $bon_commande->num = $request->bon_commande_num;

            // to associate an order form with its products:
            $produits_ids = Str::of($request->produits)->explode(',');
            foreach ($produits_ids as $id) {
                $produit = Produit::find($id);
                $produit->bon_commande()->associate($bon_commande);
                $produit->save();
            }

            if ($bon_commande->update()) {
                $status = 'Le bon de commande était bien modifié.';
            } else {
                $status = 'Modification échoue.';
            }
        } else {
            $status = 'Le fournisseur ne se trouve pas. Veuillez vérifier!';
        }
        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bon_commande  $bon_commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Bon_commande $bon_commande)
    {
        if ($bon_commande->delete())
            $status = "Le bon de commande était bien supprimé.";
        else
            $status = "Supprission échoue.";
        session()->flash('status', $status);
        // it the current request incomes from list-fournisseur page:
        if ($request->query('page') == 'list-fournisseur') {
            return back();
        }
        return redirect(route('bon_commande.index'));
    }
}
