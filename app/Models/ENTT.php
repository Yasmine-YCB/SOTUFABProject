<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ENTT extends Model
{
    use HasFactory;
 
   protected $fillable= [ 'ENT_ID',
       'DOS',
       'TICOD',
       'PICOD',
       'TIERS',
       'PREFPINO',
       'PINO',
       'PIDT',
       'REPR_0001',
       'USIMAUTO',
       'STATUS',
       'CLINOM',
       'REPRESENTANT',
       'TTCMT',
        'USIM_RESTE',
        'USIM_ACOMPTE',
        'USIM_DATE' ,
        'USIM_PLAST',
        'CLIFinal',
        'TEL',
        'RUE', 
        'U_TIMBRE'
     
      ];
 
}
 
