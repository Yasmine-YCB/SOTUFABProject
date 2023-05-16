<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;
    protected $table='Panier';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
        'id',
        'CLI',  
        'REPR',
        'MEDIA',
        'DES',
        'ARTREF',
        'QTE',
        'TACOD',
        'PRIX' ,
        'TVAART'
    ];
}
