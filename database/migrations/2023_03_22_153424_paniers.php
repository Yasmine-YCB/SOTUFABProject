<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paniers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
    Schema::connection('sqlsrv1')->create('Panier', function (Blueprint $table) {
        $table->id()->autoIncrement();
        $table->string('CLI');
        $table->string('REPR');
        $table->string('MEDIA')->nullable();  
        $table->string('DES');
        $table->string('ARTREF');
        $table->integer('QTE');
        $table->string('TACOD');
        $table->float('PRIX');  
        $table->string('SREF1')->nullable();  
        $table->string('SREF2')->nullable();  
        $table->string('TVAART')->nullable();  
        $table->integer('LGTYP')->nullable();  
        
        
        
                 
                
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::dropIfExists('Panier');
}
}
