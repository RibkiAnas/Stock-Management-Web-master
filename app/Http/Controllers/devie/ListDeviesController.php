<?php

namespace App\Http\Controllers\devie;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Devie;
use App\Models\Facture;
use Illuminate\Http\Request;

class ListDeviesController extends Controller
{
    public function convertDevisToInvoice(Request $request)
    {
        $validated = $request->validate([
            // 'facture_num' => 'required|max:255|unique:factures,num',
            'devie' => 'required|numeric',
        ]);

        $devie = Devie::where('num', $request->devie)->first();
        $client = Client::find($devie->client->id);
        $facture = new Facture;
        if ($devie && $client) {
            // to calculate quantities (decrease):
            for ($i=0; $i < count($devie->produits); $i++) {
                if ($this->checkQuantity($devie->produits[$i])) {
                    $devie->produits[$i]->qte -= $devie->produits[$i]->devie_produit->quantity;
                    $devie->produits[$i]->save();
                } else {
                    $status = 'Le produit ' . $devie->produits[$i]->libelle . ' a ' . $devie->produits[$i]->qte . ' en stock et tu as choisie ' . intval($devie->produits[$i]->devie_produit->quantity) . ' en quantity. Veuillez donner une qunatity existe.';
                    $request->session()->flash('status', $status);

                    return back();
                }
            }
            if ($devie->facture()->save($facture) && $client->factures()->save($facture)) {
                $status = 'La facture était bien ajouté.';
            } else {
                $status = 'Insertion echouée.';
            }
        } else {
            $status = 'Devis n\'existe pas.';
        }
        $request->session()->flash('status', $status);

        return redirect(route('facture.index'));
    }
    /**
     * * @param Produit $produit product
     * * @return bool whether the quantity is correct or not
     */
    public function checkQuantity($produit)
    {
        return $produit->qte >= $produit->devie_produit->quantity;
    }
}
