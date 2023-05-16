<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VRP extends Model
{
    use HasFactory;
    protected $table='VRP';
    public  $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $fillable= [
        'VRP_ID',
        'TIERS',
        'NOM',
        'RUE',
        'VIL',
        'CPOSTAL',
        'PAY',
        'TEL',
        'FAX',
        'WEB',
        'EMAIL',
        'TIT',
    
    
    
    
    
       
        
    ];
    protected $hidden = [
        
        'CE2',
        'CE3',
        'CE4',
        'CE5',
        'CE6',
        'CE7',
        'CE8',
        'CE9',
        'CEA',
        'DOS',
        'USERCR',
        'USERMO',
        'CONF',
        'VISA',
        'NOMABR',
        'ADRCPL1',
        'ADRCPL2',
        'ZIPCOD',
        'REGIONCOD',
        'INSEECOD',
        'NAF',
        
        'REGL',
        'DEV',
        'LANG',
        'CPT',
        'CPTMSK',
        'SELCOD',
        'SIRET',
        'ETB',
        'USERCRDH',
        'USERMODH',
        'HSDT',
        'NOTE',
        'CENOTE',
        'JOINT',
        'CEJOINT',
        'IDCONNECT',
        'CLDCOD',
        'GLN',
        'TELCLE',
        'ICPFL',
        'COFAMV',
        'TELGSM',
        'SALCOD',
        'COMP',
        'COMTYP',
        'COMBASTYP',
        'REPRTYP',
        'TELGSMCLE',
      
    ];


    protected $attributes=[
        'CENOTE'=>'1',
        'JOINT'=>'1',
        'CEJOINT'=>'1',
        'IDCONNECT'=>'1',
        'SALCOD'=>'1',
        'ICPFL'=>'1',
        'COMP'=>'1',
        'COMTYP'=>'1',
        'COMBASTYP'=>'1',
        'REPRTYP'=>'1',
        'NOTE'=>'1',
        'CE1'=>'1',
        'CE2'=>'1',
        'CE3'=>'1',
        'CE4'=>'1',
        'CE5'=>'1',
        'CE6'=>'1',
        'CE7'=>'1',
        'CE8'=>'1',
        'CE9'=>'1',
        'CEA'=>'1',
        'DOS'=>'1',
        'USERCR'=>'1',
        'USERMO'=>'1',
        'CONF'=>'1',
        'VISA'=>'1',
        'NOMABR'=>'1',
        'ADRCPL1'=>'1',
        'ADRCPL2'=>'1',
        'ZIPCOD'=>'1',
        'REGIONCOD'=>'1',
        'INSEECOD'=>'1',
        'NAF'=>'1',
        'TIT'=>'1',
        'REGL'=>'1',
        'DEV'=>'1',
        'LANG'=>'1',
        'CPT'=>'1',
        'CPTMSK'=>'1',
        'SELCOD'=>'1',
        'SIRET'=>'1',
        'ETB'=>'1',
        'LOC'=>'1',
        'CLDCOD'=>'1',
        'GLN'=>'1',
        'TELCLE'=>'1',
        'COFAMV'=>'1',
        'TELGSM'=>'1',
        'TELGSMCLE'=>'1',
    
        ];
         
}
