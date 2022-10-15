<?php

namespace App\Http\Controllers;

use App\Models\Devie;
use App\Models\Facture;
use Exception;
use Illuminate\Http\Request;

class PrintingController extends Controller
{
    public function imprimer($id, $type)
    {
        if ($type == "devie") {
            $devie = Devie::where('num', $id)->first();
            return view('impression', compact('devie'));
        }elseif($type == "facture"){
            $facture = Facture::where('num', $id)->first();
            return view('impression', compact('facture'));
        }
    }
}
