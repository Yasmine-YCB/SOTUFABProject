<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebMouv extends Model
{
    use HasFactory;
    protected $table='SIMMOUV';
    public  $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $fillable= [  
        'SIMMOUV_ID'  ,  
        'REF',
        'SREF1',
        'SREF2',      
        'TIERS',
        'DES',
        'PUB',        
        'DEPO',       
        'CDQTE',
        'REM_0001',//
        'REM_0002',//
        'REM_0003',//
        'PDT',//
        'CDCODE', //ent id
        'CDSLG',
        'USIM_TRANSFERT_PINO'
    ];
   
    protected $attributes = [
        // 'DOS'=>'1',
        // 'PICOD'=>2,
        // 'TICOD'=>'C',
        // 'CE1' =>'A',
        // 'CE2'=>'  ',
        // 'CE3'=>'  ',
        // 'CE4' =>'1',
        // 'CE5'=>'1',
        // 'CE6'=>'  ',
        // 'CE7'=>'  ',
        // 'CE8'=>' ',
        // 'CE9'=>'  ',
        // 'CEA'=>'  ',
        // 'CEB'=>'  ',
        // 'CEC'=>'  ',
        // 'CED'=>'  ',
        // 'CEE'=>'  ',
        // 'CEF'=>'  ',       
        // 'PCOD_0001'=>4,
        // 'PCOD_0002'=>4,
        // 'PCOD_0003'=>2,
        // 'PCOD_0004'=>2,
        // 'PCOD_0005'=>2,
        // 'PCOD_0006'=>2,
    ];
}
