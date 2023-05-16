<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class config extends Model
{
    use HasFactory;
    protected $table='config';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
        'id',
        'prefix',
        'sav',
        'sc',    
        'st',    
        'compteur',    
        'prefixdiva'
        
    ]; 
}
