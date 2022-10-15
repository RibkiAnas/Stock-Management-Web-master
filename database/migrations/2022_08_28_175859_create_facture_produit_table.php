<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facture_id')->constrained('factures', 'num')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facture_produit');
    }
}
