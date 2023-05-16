<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class representant extends Model
{
    protected $table='representant';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable = [
        'user_id',
        'fonction',
        'nom',
        'prenom',
        'numcpt',
        'vice_user_id'        
    ];
    //many to one vice_user_id
    // one to one user_id
}
