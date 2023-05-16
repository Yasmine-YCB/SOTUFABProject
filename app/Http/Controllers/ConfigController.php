<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\config;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public function getAll(){
        return config::select(  
        'id',
        'prefix',
        'sav',
        'sc',    
        'st',    
        'compteur', 
        'prefixdiva'
        )->first();
        }
                   /**
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function updatePrefix(Request $request)
     {  
        config::where('id',request('id'))->update([              
            'prefix' => request('prefix'),
            'prefixdiva' => request('prefixdiva'),            
            'sav' => request('sav'),
            'sc' => request('sc'),
            'st' => request('st'),
            'compteur' => request('compteur'),     
            ]);
        return  config::where('id',request('id'))->first();
 

     }



     public function getpref(){
        return DB::select("select   SOCPREFNO_ID,PREFPINO,DOS, ETB, TICOD, PINO, PICOD  from SOCPREFNO  where TICOD='C' and PICOD=2 ");
       }
    public function getprefByID($id){
        return DB::select("select   SOCPREFNO_ID,PREFPINO,DOS, ETB, TICOD, PINO, PICOD  from SOCPREFNO 
         where TICOD='C' and PICOD=2
         and SOCPREFNO_ID= '".$id."' ");
       }

    
}
