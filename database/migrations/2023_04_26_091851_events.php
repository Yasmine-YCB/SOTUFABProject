<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv1')->create('Events', function (Blueprint $table) {
            $table->id()->autoIncrement();          
            $table->string('date_fin'); 
            $table->string('date_deb');
            $table->string('description'); 
            $table->string('lien');  
            $table->string('type');
            $table->string('client_id');
            $table->string('representant_id');    
            $table->string('USIM_PLAST');    
                                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Event');
    }
}
