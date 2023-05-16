<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    protected $table='notification';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
        'id',
        'description',  
        'nom',
        'client_user_id',
        'representant_user_id',
        'user_id',
        'srce',
        'clients',
        'representants',
        'remise',
        'datedeb',
        'datefin'
    ];
}
 