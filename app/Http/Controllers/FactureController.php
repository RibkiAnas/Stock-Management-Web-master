<?php

namespace App\Http\Controllers;

use App\Models\Bon_commande;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factures = Facture::all();
        $produits_factures = Produit::join('facture_produit', 'produits.id', '=', 'facture_produit.produit_id')->get();
        $produits_devies = Produit::join('devie_produit', 'produits.id', '=', 'devie_produit.produit_id')->get();
        return view('facture.list-factures', compact('factures', 'produits_factures', 'produits_devies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $bon_commandes = Bon_commande::all();
        $produits = Produit::all();
        $clients = Client::all();
        return view('facture.add-facture', compact('produits', 'clients'));
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
            // 'facture_num' => 'required|max:255|unique:factures,num',
            'client' => 'required|numeric',
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
            'quantities' => [
                'required',
                // this will be used to customize validation:
                function ($attribute, $value, $fail) {
                    $produits_quantities = Str::of($value)->explode(',');
                    foreach ($produits_quantities as $id) {
                        if (!is_numeric($id)) {
                            $fail('there is some problems with params.');
                        }
                    }
                }
            ],
        ]);

        $facture = new Facture;
        $client = Client::find($request->client);

        if ($client) {
            $facture->save();
            // to associate a quotation with its products:
            $produits_ids = Str::of($request->produits)->explode(',');
            $produits_quantities = Str::of($request->quantities)->explode(',');
            for ($i = 0; $i < count($produits_ids); $i++) {
                $produit = Produit::find($produits_ids[$i]);
                if ($produit->qte >= intval($produits_quantities[$i])) {
                    $facture->produits()->attach($produits_ids[$i], ['quantity' => $produits_quantities[$i]]); // create new record in the intermediate table (facture_produit).
                    $produit->qte -= $produits_quantities[$i];
                    $produit->save();
                } else {
                    $facture->delete();
                    $status = 'Le produit ' . $produit->libelle . ' a ' . $produit->qte . ' en stock et tu as choisie ' . intval($produits_quantities[$i]) . ' en quantity. Veuillez donner une qunatity existe.';
                    $request->session()->flash('status', $status);

                    return back();
                }
            }

            if ($client->factures()->save($facture)) { // associate the client with his invoices (factures).
                $status = 'La facture était bien ajouté.';
            } else {
                $status = 'Insertion echouée.';
            }
        } else {
            $status = 'Client n\'existe pas.';
        }
        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        return view('facture.list-facture', compact('facture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        $produits = Produit::all();
        // $bon_commandes = Bon_commande::all();
        $clients = Client::all();
        return view('facture.edit-facture', compact('facture', 'clients', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facture $facture)
    {
        $validated = $request->validate([
            'facture_num' => ($request->facture_num != $facture->num) ? 'required|max:255|unique:factures,num' : 'required',
            'client' => 'required|numeric',
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
            'quantities' => [
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

        $produits_ids = Str::of($request->produits)->explode(',');
        $produits_quantities = Str::of($request->quantities)->explode(',');
        if (count($produits_ids) == count($produits_quantities)) {
            $facture->num = $request->facture_num;
            $client = Client::find($request->client);

            if ($client) {
                $client->factures()->save($facture); // associate the client with his quotations (factures).

                // to associate a quotation with its products or make update them:
                $produits_with_their_quantities = $produits_ids->combine($produits_quantities); // get the new associated products with their quantities.
                $old_produits_with_their_quantities = collect($facture->produits->modelKeys())->combine($facture->produits->pluck('facture_produit.quantity')); // get the old associated products with their quantities.

                $ids_to_associate_or_update = $produits_with_their_quantities->diffAssoc($old_produits_with_their_quantities); // get products ids to associate them with this quotation.
                if ($ids_to_associate_or_update->isNotEmpty()) {
                    foreach ($ids_to_associate_or_update as $id => $qte) {
                        $produit = Produit::find($id);
                        if ($produit->qte >= intval($qte)) {
                            if ($old_produits_with_their_quantities->has($id)) {
                                $facture->produits()->updateExistingPivot($id, ['quantity' => $qte]); // update quantity because the product already exists.
                                $produit->qte += $old_produits_with_their_quantities->get($id); // rollback to initial status
                                $produit->qte -= $qte; // then, decrease the new quantity.
                            } else {
                                $facture->produits()->attach($id, ['quantity' => $qte]); // create new record in the intermediate table (facture_produit).
                                $produit->qte -= $qte;
                            }
                            $produit->save();
                        } else {
                            $status = 'Le produit ' . $produit->libelle . ' a ' . $produit->qte . ' en stock et tu as choisie ' . intval($qte) . ' en quantity. Veuillez donner une qunatity existe.';
                            $request->session()->flash('status', $status);

                            return back();
                        }
                    }
                }
                // detach products from this quotation:
                $ids_to_detach = $old_produits_with_their_quantities->diffKeys($produits_with_their_quantities);
                if ($ids_to_detach->isNotEmpty()) {
                    $facture->produits()->detach($ids_to_detach->keys());
                    // to reset the stock quantities of detached products to their initial status:
                    foreach ($ids_to_detach as $id => $qte) {
                        $produit = Produit::find($id);
                        $produit->qte += $qte;
                        $produit->save();
                    }
                }

                if ($facture->update()) {
                    $status = 'La facture était bien modifié.';
                } else {
                    $status = 'Modification échoue.';
                }
            } else {
                $status = 'Client n\'existe pas.';
            }
        } else {
            $status = 'problem with length products & quantities';
        }

        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        // to reset the stock quantities of detached products to their initial status:
        if ($facture->devie_id != null) { // if the facture is created from quotation (conversion).
            for ($i=0; $i < count($facture->devie->produits); $i++) {
                $facture->devie->produits[$i]->qte += $facture->devie->produits[$i]->devie_produit->quantity;
                $facture->devie->produits[$i]->save();
            }
        } else{
            foreach ($facture::join('facture_produit', 'factures.id', '=', 'facture_produit.facture_id')->where('factures.id', $facture->id)->get() as $fact_prod) {
                $produit = Produit::find($fact_prod->produit_id);
                $produit->qte += $fact_prod->quantity;
                $produit->save();
            }
        }
        if ($facture->delete())
            $status = "La facture était bien supprimé.";
        else
            $status = "Supprission échoue.";
        session()->flash('status', $status);

        return redirect(route('facture.index'));
    }
}
