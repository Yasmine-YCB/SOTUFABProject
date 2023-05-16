<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Prefix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::connection('sqlsrv1')->create('Prefix', function (Blueprint $table) {
        $table->id()->autoIncrement();          
        $table->string('DOS'); 
        $table->string('ETB'); 
        $table->string('PREFIX'); 
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
        Schema::dropIfExists('Prefix');

    }
}
