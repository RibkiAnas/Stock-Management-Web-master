<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('fournisseur.list-fournisseurs', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fournisseur.add-fournisseur');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'fournisseur_name' => 'required|max:255',
                'fournisseur_rc' => 'required|unique:fournisseurs,rc|numeric',
                'fournisseur_nom_societe' => 'required|max:255',
                'fournisseur_ice' => 'required|unique:fournisseurs,ice|numeric',
            ],
            [
                'required' => 'Le champs :attribute est obligatoire.',
                'unique' => 'Le champs :attribute doit être unique.',
                'numeric' => 'Le champs :attribute doit être numerique',
                'max'
            ],
            [
                'fournisseur_name' => 'Nom de Fournisseur',
                'fournisseur_rc' => 'RC de Fournisseur',
                'fournisseur_nom_societe' => 'Nom de la Société de Fournisseur',
                'fournisseur_ice' => 'ICE de Fournisseur',
            ]
        )->validate();
        $fournisseur = Fournisseur::create([
            'nom_complet' => $request->fournisseur_name,
            'telephone' => $request->fournisseur_tele,
            'rc' => $request->fournisseur_rc,
            'nom_societe' => $request->fournisseur_nom_societe,
            'ice' => $request->fournisseur_ice,
        ]);

        if ($fournisseur) {
            $status = 'Le fournisseur était bien ajouté.';
        } else {
            $status = 'Insertion échoue.';
        }
        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        return view('fournisseur.list-fournisseur', compact('fournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseur.edit-fournisseur', compact('fournisseur'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        $validated = $request->validate([
            'fournisseur_name' => 'required|max:255',
            'fournisseur_rc' => ($request->fournisseur_rc != $fournisseur->rc) ? 'required|unique:fournisseurs,rc|numeric' : 'required|numeric',
            'fournisseur_nom_societe' => 'required|max:255',
            'fournisseur_ice' => ($request->fournisseur_ice != $fournisseur->ice) ? 'required|unique:fournisseurs,ice|numeric' : 'required|numeric',
            'fournisseur_dette' => 'numeric|required',
        ]);
        $fournisseur->nom_complet = $request->fournisseur_name;
        $fournisseur->telephone = $request->fournisseur_tele;
        $fournisseur->rc = $request->fournisseur_rc;
        $fournisseur->nom_societe = $request->fournisseur_nom_societe;
        $fournisseur->ice = $request->fournisseur_ice;
        $fournisseur->dette = $request->fournisseur_dette;

        if ($fournisseur->update()) {
            $status = 'Le fournisseur était bien modifié.';
        } else {
            $status = 'Modification échoue.';
        }
        $request->session()->flash('status', $status);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        if ($fournisseur->delete())
            $status = "Le fournisseur était bien supprimé.";
        else
            $status = "Supprission échoue.";
        session()->flash('status', $status);

        return redirect(route('fournisseur.index'));
    }
}
