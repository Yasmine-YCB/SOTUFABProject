<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;
    protected $table='commande';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
        'id',
        'add_ref',
        'codetva_cin',
        'date_livr',    
        'ct_num',    
        'created_at',    
        'intutile',    
        'msg',    
        'num_sage',    
        'ref',    
        'reste',    
        'statut',    
        'tel_ref',    
        'totale',    
        'client_user_id',    
        'representant_user_id',    
        'num_cmd_clt',    
        'commune',    
        'tel_ref',      
        
    ]; 
  
}
