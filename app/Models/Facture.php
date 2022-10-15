<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'num';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num',
    ];

    /**
     * The products that belong to the quotation (devis).
     */
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'facture_produit', 'facture_id', 'produit_id')
                    ->as('facture_produit')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    /**
     * The client that own this quotation (devis).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    /**
     * Get the quotation (devis) that owns the invoice (facture).
     */
    public function devie()
    {
        return $this->belongsTo(Devie::class,'devie_id', 'num');
    }
}
