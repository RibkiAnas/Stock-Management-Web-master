<?php

namespace App\Http\Controllers;

use App\Models\Bon_commande;
use App\Models\Client;
use App\Models\Devie;
use App\Models\Produit;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DevieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devies = Devie::all();
        $produits = Produit::join('devie_produit', 'produits.id','=','devie_produit.produit_id')->get();
        return view('devie.list-devies', compact('devies', 'produits'));
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
        return view('devie.add-devie', compact('produits', 'clients'));
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
            // 'devie_num' => 'required|max:255|unique:devies,num',
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

        // $devie = new Devie(['num' => $request->devie_num,]);
        $devie = new Devie;
        $client = Client::find($request->client);

        if ($client) {
            $client->devies()->save($devie); // associate the client with his quotations (devies).

            // to associate a quotation with its products:
            $produits_ids = Str::of($request->produits)->explode(',');
            $produits_quantities = Str::of($request->quantities)->explode(',');
            for ($i = 0; $i < count($produits_ids); $i++) {
                $devie->produits()->attach($produits_ids[$i], ['quantity' => $produits_quantities[$i]]); // create new record in the intermediate table (devie_produit).
            }
            if ($devie->save()) {
                $status = 'Le devis était bien ajouté.';
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
     * @param  \App\Models\Devie  $devie
     * @return \Illuminate\Http\Response
     */
    public function show(Devie $devie)
    {
        return view('devie.list-devie', compact('devie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devie  $devie
     * @return \Illuminate\Http\Response
     */
    public function edit(Devie $devie)
    {
        $produits = Produit::all();
        // $bon_commandes = Bon_commande::all();
        $clients = Client::all();
        return view('devie.edit-devie', compact('devie', 'clients', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devie  $devie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Devie $devie)
    {
        $validated = $request->validate([
            // 'devie_num' => ($request->devie_num != $devie->num) ? 'required|max:255|unique:devies,num' : 'required',
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
            $devie->num = $request->devie_num;
            $client = Client::find($request->client);

            if ($client) {
                $client->devies()->save($devie); // associate the client with his quotations (devies).

                // to associate a quotation with its products or make update them:
                $produits_with_their_quantities = $produits_ids->combine($produits_quantities); // get old the associated products with their quantities.
                $old_produits_with_their_quantities = collect($devie->produits->modelKeys())->combine($devie->produits->pluck('devie_produit.quantity')); // get old the associated products with their quantities.

                $ids_to_associate_or_update = $produits_with_their_quantities->diffAssoc($old_produits_with_their_quantities); // get products ids to associate them with this quotation.
                if ($ids_to_associate_or_update->isNotEmpty()) {
                    foreach ($ids_to_associate_or_update as $id => $qte) {
                        $produit = Produit::find($id);
                        if ($old_produits_with_their_quantities->has($id)) {
                            $devie->produits()->updateExistingPivot($id, ['quantity' => $qte]); // update quantity because the product already exists.
                            if ($devie->facture != null) { // check if the update is for an invoice
                                $produit->qte += $old_produits_with_their_quantities->get($id); // rollback to initial status
                                $produit->qte -= $qte; // then, decrease the new quantity.
                                $produit->save();
                            }
                        } else {
                            $devie->produits()->attach($id, ['quantity' => $qte]); // create new record in the intermediate table (devie_produit).
                            if ($devie->facture != null) { // check if the update is for an invoice
                                $produit->qte -= $qte;
                                $produit->save();
                            }
                        }
                    }
                }
                // detach products from this quotation:
                $ids_to_detach = $old_produits_with_their_quantities->diffKeys($produits_with_their_quantities);
                if ($ids_to_detach->isNotEmpty()) {
                    $devie->produits()->detach($ids_to_detach->keys());
                }

                if ($devie->update()) {
                    $status = 'Le devie était bien modifié.';
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
     * @param  \App\Models\Devie  $devie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Devie $devie)
    {
        if ($devie->delete())
            $status = "Le devie était bien supprimé.";
        else
            $status = "Supprission échoue.";
        session()->flash('status', $status);

        return redirect(route('devie.index'));
    }
}
