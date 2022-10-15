<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id('num');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('devie_id')->nullable()->constrained('devies', 'num')->onDelete('cascade')->onUpdate('cascade'); // if the client want to convert quotation to invoice
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
        Schema::dropIfExists('factures');
    }
}
