<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDevieProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devie_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devie_id')->constrained('devies', 'num')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('devie_produit');
    }
}
