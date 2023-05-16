<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Commande extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv1')->create('Event', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('autre');
            $table->timestamp('date_fin'); 
            $table->timestamp('date_deb');
            $table->string('designation'); 
            $table->string('lien');
            $table->string('localisation');  
            $table->string('type');
            $table->string('client_id');
            $table->string('representant_id');
            $table->string('description');
            $table->timestamp('start');
            $table->string('title');
            $table->string('url');
            $table->timestamp('end_date');
            $table->string('client');
                    
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
