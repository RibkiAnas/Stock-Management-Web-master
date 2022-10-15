<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon_commande extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num',
    ];

    /**
     * Get the products for the order form.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    /**
     * Get the supplier that owns the order form.
     */
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }
}
