<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Configg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv1')->create('config', function (Blueprint $table) {
            $table->id()->autoIncrement();          
            $table->string('prefix')->nullable(); 
            $table->string('sav')->nullable(); 
            $table->string('st')->nullable(); 
            $table->string('compteur')->nullable(); 
            $table->string('prefixdiva')->nullable(); 
            $table->timestamp() ; 
          
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config');
    }
}
