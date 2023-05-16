<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table='Events';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
        'id',
        'date_fin',
        'date_deb',
        'description',
        'lien',
        'type',
        'client_id',
        'representant_id',
        'USIM_PLAST',
        
        
    ];
}





