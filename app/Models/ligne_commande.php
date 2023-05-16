<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ligne_commande extends Model
{
    use HasFactory;
    protected $table='ligne_commande';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
    'DOS',
    'REF', 
    'PREFDVNO',
    'DVNO',
    'PREFCDNO',
    'CDNO', 
    'PREFBLNO',
    'BLNO',  
    'PREFFANO',
    'FANO',
    'DVQTE',
    'CDQTE',
    'BLQTE',
    'FAQTE',
    'DES',
    'ENRNO',
    'REPR_0001',];
}
