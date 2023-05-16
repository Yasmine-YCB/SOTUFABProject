<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class WebEnt extends Model
{
    use HasFactory;
    protected $table='SIMENT';
    public  $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $fillable= [
        'SIMENT_ID'  ,      
        'PIDT',
        'USIMAUTO', 
        'TIERS',
        'TTCMT',
        'USIM_RESTE',
        'USIM_ACOMPTE',
        'USIM_DATE',
        'USIM_PLAST',
        'REPR_0001',//
        'NAME',
        'TEL1',
        'TEL2',
        'TEL3',
        'ADRCPL1',    
        'PREFPINO',     
        'ADRTYP_0003',
        'CPOSTAL',//
        'USIM_TRANSFERT_PINO',
       
    ];
    protected $attributes = [
        'PICODE'=>2,
        // 'DOS'=>'1',
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
        // 'ETB'=>'1',
        // 'DEV'=>'TND ',
        // 'OP'=>'C  ',
        // 'PIREF'=>'  ', 
        // 'PINOTIERS'=>'  ',
        // 'HTCOD'=>1,
        // 'PIEDMT_0001'=>0.000,
        // 'PIEDMT_0002'=>0.000,
        // 'PIEDMT_0003'=>0.000,
        // 'PICODE'=>0,
        // 'STATUS'=>1,

    
    ];
}
