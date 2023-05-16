<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vice extends Model
{
    use HasFactory; 
    protected $table='Vice';
    public  $timestamps = false;
    protected $connection = 'sqlsrv1';
    protected $fillable= [
        'id',
        'rep_id',
        'vice_id',
        
        
    ];

    
}
