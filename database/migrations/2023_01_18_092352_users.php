<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv1')->create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('PER_id')->nullable();
            $table->string('CLI_id')->nullable();
            $table->string('authorities_id');
            $table->string('DOS')->nullable();
            $table->string('ETB')->nullable();
            $table->string('first_Name');
            $table->string('last_Name');
            $table->string('username')->unique(); 
            $table->string('password');
            $table->string('gsm')->nullable();
            $table->boolean('enabled')->nullable();
            $table->boolean('SMS')->nullable();
            $table->boolean('EMAIL')->nullable();
 
            $table->timestamp()         ;
        
      
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
