<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 

use App\Models\ENT;
use App\Models\VRP;
use App\Models\CLI;
use App\Models\ENTT;
use App\Models\INTEGER;
use App\Models\ENTState;

use App\Models\WebEnt;


use Illuminate\Support\Facades\DB;

class ENTController extends Controller
{
     
   public function getFactureByCli($rep, $cli)
   {        
      $ENTete= DB::table('ENT')->select(
         'ENT.ENT_ID',       
         'ENT.TICOD',
         'ENT.PICOD', 
         'ENT.PREFPINO',
         'ENT.PINO', 
         'ENT.PIDT',
         'ENT.U_TIMBRE',
         'ENT.REPR_0001',            
         'ENT.USIMAUTO', 
         'ENT.TTCMT',
         'ENT.USIM_RESTE',
         'ENT.USIM_ACOMPTE',
         'ENT.USIM_DATE'  ,
         'ENT.USIM_PLAST',
         'ENT.STATUS',
         'ENT.ADRTYP_0001',
         'CLI.NOM',
         'CLI.RUE',
         'CLI.VIL',
         'CLI.TEL',
         'VRP.NOM AS REPR')         
         ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS') 
         ->join('VRP','VRP.TIERS', '=', 'ENT.REPR_0001') 
         ->where('ENT.DOS', 1)
         ->where('CLI.DOS', 1)
         ->where('VRP.DOS', 1)
         ->where('ENT.REPR_0001', $rep)
         ->where(  'ENT.TIERS', $cli)
         ->where('PICOD',4)->orderBy('ENT_ID', 'DESC')
         ->get(); 
         $table=[];
         foreach ($ENTete as $key => $value) {       
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[$key]->ENT_ID;
            $response->TICOD = $ENTete[$key]->TICOD;
            $response->PICOD= $ENTete[$key]->PICOD;
            $response->U_TIMBRE= $ENTete[$key]->U_TIMBRE;
            $response->PREFPINO= $ENTete[$key]->PREFPINO;
            $response->PINO= $ENTete[$key]->PINO;
            $response->REPR_0001= $ENTete[$key]->REPR_0001;
            $response->PIDT= $ENTete[$key]->PIDT;
            $response->STATUS= $ENTete[$key]->STATUS;
            $response->USIMAUTO= $ENTete[$key]->USIMAUTO;
            $response->CLINOM=$ENTete[$key]->NOM;
            $response->CLIFinal=$ENTete[$key]->NOM;         
            $response->TEL=$ENTete[$key]->TEL;            
            $response->RUE= $ENTete[$key]->RUE;            
            $response->REPRESENTANT=$ENTete[$key]->REPR;
            $response->TTCMT= $ENTete[$key]->TTCMT;
            $response->USIM_RESTE= $ENTete[$key]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[$key]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[$key]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[$key]->USIM_PLAST;
            $response->STATUS= $ENTete[$key]->STATUS;        
           if($ENTete[$key]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[$key]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
         array_push($table, $response);
         }

      return response($table);


       
   }   

   public function getCLIFacture($cli)
   {        
      $ENTete= DB::table('ENT')->select(
         'ENT.ENT_ID',       
         'ENT.TICOD',
         'ENT.PICOD', 
         'ENT.PREFPINO',
         'ENT.PINO', 
         'ENT.PIDT',            
         'ENT.USIMAUTO', 
         'ENT.TTCMT',
         'ENT.USIM_RESTE',
         'ENT.USIM_ACOMPTE',
         'ENT.USIM_DATE'  ,
         'ENT.USIM_PLAST',
         'ENT.STATUS',
         'ENT.ADRTYP_0001',
         'ENT.U_TIMBRE',
         'CLI.NOM',
         'CLI.RUE',
         'CLI.VIL',
         'CLI.TEL', )         
         ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS')  
         ->where('ENT.DOS', 1)
         ->where('CLI.DOS', 1) 
         ->where(  'ENT.TIERS', $cli)
         ->where('PICOD',4)->orderBy('ENT_ID', 'DESC')
         ->get(); 
         $table=[];
         foreach ($ENTete as $key => $value) {       
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[$key]->ENT_ID;
            $response->TICOD = $ENTete[$key]->TICOD;
            $response->PICOD= $ENTete[$key]->PICOD; 
            $response->PREFPINO= $ENTete[$key]->PREFPINO;
            $response->PINO= $ENTete[$key]->PINO;
            $response->REPR_0001= "";
            $response->U_TIMBRE= $ENTete[$key]->U_TIMBRE;
            $response->PIDT= $ENTete[$key]->PIDT;
            $response->STATUS= $ENTete[$key]->STATUS;
            $response->USIMAUTO= $ENTete[$key]->USIMAUTO;
            $response->CLINOM=$ENTete[$key]->NOM;
            $response->CLIFinal=$ENTete[$key]->NOM;         
            $response->TEL=$ENTete[$key]->TEL;            
            $response->RUE= $ENTete[$key]->RUE;            
            $response->REPRESENTANT=" ";
            $response->TTCMT= $ENTete[$key]->TTCMT;
            $response->USIM_RESTE= $ENTete[$key]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[$key]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[$key]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[$key]->USIM_PLAST;
            $response->STATUS= $ENTete[$key]->STATUS;        
           if($ENTete[$key]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[$key]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
         array_push($table, $response);
         }

      return response($table);


       
   }
   public function getFacture($rep)
   {      

       $ENTete= DB::table('ENT')->select(
         'ENT.ENT_ID',       
         'ENT.TICOD',
         'ENT.PICOD', 
         'ENT.PREFPINO',
         'ENT.PINO', 
         'ENT.PIDT',
         'ENT.TIERS',
         'ENT.REPR_0001',            
         'ENT.USIMAUTO', 
         'ENT.TTCMT',
         'ENT.USIM_RESTE',
         'ENT.USIM_ACOMPTE',
         'ENT.USIM_DATE'  ,
         'ENT.USIM_PLAST',
         'ENT.STATUS',
         'ENT.ADRTYP_0001',
         'ENT.U_TIMBRE',
         'CLI.NOM',
         'CLI.RUE',
         'CLI.VIL',
         'CLI.TEL',
         'VRP.NOM AS REPR')         
         ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS') 
         ->join('VRP','VRP.TIERS', '=', 'ENT.REPR_0001') 
         ->where('ENT.DOS', 1)
         ->where('CLI.DOS', 1)
         ->where('VRP.DOS', 1)
         ->where('ENT.REPR_0001', $rep)
         ->where('PICOD',4)->orderBy('ENT_ID', 'DESC')
         ->get(); 
         $table=[];
         foreach ($ENTete as $key => $value) {       
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[$key]->ENT_ID;
            $response->TICOD = $ENTete[$key]->TICOD;
            $response->PICOD= $ENTete[$key]->PICOD;
            $response->TIERS= $ENTete[$key]->TIERS;
            $response->PREFPINO= $ENTete[$key]->PREFPINO;
            $response->PINO= $ENTete[$key]->PINO;
            $response->U_TIMBRE= $ENTete[$key]->U_TIMBRE;
            $response->REPR_0001= $ENTete[$key]->REPR_0001;
            $response->PIDT= $ENTete[$key]->PIDT;
            $response->STATUS= $ENTete[$key]->STATUS;
            $response->USIMAUTO= $ENTete[$key]->USIMAUTO;
            $response->CLINOM=$ENTete[$key]->NOM;
            $response->CLIFinal=$ENTete[$key]->NOM;         
            $response->TEL=$ENTete[$key]->TEL;            
            $response->RUE= $ENTete[$key]->RUE;            
            $response->REPRESENTANT=$ENTete[$key]->REPR;
            $response->TTCMT= $ENTete[$key]->TTCMT;
            $response->USIM_RESTE= $ENTete[$key]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[$key]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[$key]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[$key]->USIM_PLAST;
            $response->STATUS= $ENTete[$key]->STATUS;        
           if($ENTete[$key]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[$key]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
         array_push($table, $response);
         }

      return response($table);
   } 
   
   public function getBL($rep)
   {        
      $ENTete= DB::table('ENT')->select(
         'ENT.ENT_ID',       
         'ENT.TICOD',
         'ENT.PICOD', 
         'ENT.PREFPINO',
         'ENT.PINO', 
         'ENT.PIDT',
         'ENT.TIERS',
         'ENT.REPR_0001',            
         'ENT.USIMAUTO', 
         'ENT.TTCMT',
         'ENT.USIM_RESTE',
         'ENT.USIM_ACOMPTE',
         'ENT.USIM_DATE'  ,
         'ENT.USIM_PLAST',
         'ENT.STATUS',
         'ENT.ADRTYP_0001',
         'ENT.U_TIMBRE',
         'CLI.NOM',
         'CLI.RUE',
         'CLI.VIL',
         'CLI.TEL',
         'VRP.NOM AS REPR')
         
         ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS') 
         ->join('VRP','VRP.TIERS', '=', 'ENT.REPR_0001') 
         ->where('ENT.DOS', 1)
         ->where('CLI.DOS', 1)
         ->where('VRP.DOS', 1)
         ->where('ENT.REPR_0001', $rep)
         ->where('PICOD',3)->orderBy('ENT_ID', 'DESC')
         ->get(); 
         $table=[];
         foreach ($ENTete as $key => $value) {       
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[$key]->ENT_ID;
            $response->TICOD = $ENTete[$key]->TICOD;
            $response->PICOD= $ENTete[$key]->PICOD;
            $response->TIERS= $ENTete[$key]->TIERS;
            $response->PREFPINO= $ENTete[$key]->PREFPINO;
            $response->U_TIMBRE= $ENTete[$key]->U_TIMBRE;
            $response->PINO= $ENTete[$key]->PINO;
            $response->REPR_0001= $ENTete[$key]->REPR_0001;
            $response->PIDT= $ENTete[$key]->PIDT;
            $response->STATUS= $ENTete[$key]->STATUS;
            $response->USIMAUTO= $ENTete[$key]->USIMAUTO;
            $response->CLINOM=$ENTete[$key]->NOM;
            $response->CLIFinal=$ENTete[$key]->NOM;         
            $response->TEL=$ENTete[$key]->TEL;            
            $response->RUE= $ENTete[$key]->RUE;            
            $response->REPRESENTANT=$ENTete[$key]->REPR;
            $response->TTCMT= $ENTete[$key]->TTCMT;
            $response->USIM_RESTE= $ENTete[$key]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[$key]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[$key]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[$key]->USIM_PLAST;
            $response->STATUS= $ENTete[$key]->STATUS;        
           if($ENTete[$key]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[$key]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
         array_push($table, $response);
         }

      return response($table);
   }

   public function getBLByCli($rep, $cli)
   {        
      $ENTete= DB::table('ENT')->select(
         'ENT.ENT_ID',       
         'ENT.TICOD',
         'ENT.PICOD', 
         'ENT.PREFPINO',
         'ENT.PINO', 
         'ENT.PIDT',
         'ENT.TIERS',
         'ENT.REPR_0001',            
         'ENT.USIMAUTO', 
         'ENT.TTCMT',
         'ENT.USIM_RESTE',
         'ENT.USIM_ACOMPTE',
         'ENT.USIM_DATE'  ,
         'ENT.USIM_PLAST',
         'ENT.STATUS',
         'ENT.ADRTYP_0001',
         'ENT.U_TIMBRE',
         'CLI.NOM',
         'CLI.RUE',
         'CLI.VIL',
         'CLI.TEL',
         'VRP.NOM AS REPR')         
         ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS') 
         ->join('VRP','VRP.TIERS', '=', 'ENT.REPR_0001') 
         ->where('ENT.DOS', 1)
         ->where('CLI.DOS', 1)
         ->where('VRP.DOS', 1)
         ->where('ENT.REPR_0001', $rep)
         ->where('ENT.TIERS', $cli)
         ->where('PICOD',3)->orderBy('ENT_ID', 'DESC')
         ->get(); 
         $table=[];
         foreach ($ENTete as $key => $value) {       
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[$key]->ENT_ID;
            $response->TICOD = $ENTete[$key]->TICOD;
            $response->PICOD= $ENTete[$key]->PICOD;
            $response->TIERS= $ENTete[$key]->TIERS;
            $response->PREFPINO= $ENTete[$key]->PREFPINO;
            $response->PINO= $ENTete[$key]->PINO;
            $response->REPR_0001= $ENTete[$key]->REPR_0001;
            $response->U_TIMBRE= $ENTete[$key]->U_TIMBRE;
            $response->PIDT= $ENTete[$key]->PIDT;
            $response->STATUS= $ENTete[$key]->STATUS;
            $response->USIMAUTO= $ENTete[$key]->USIMAUTO;
            $response->CLINOM=$ENTete[$key]->NOM;
            $response->CLIFinal=$ENTete[$key]->NOM;         
            $response->TEL=$ENTete[$key]->TEL;            
            $response->RUE= $ENTete[$key]->RUE;            
            $response->REPRESENTANT=$ENTete[$key]->REPR;
            $response->TTCMT= $ENTete[$key]->TTCMT;
            $response->USIM_RESTE= $ENTete[$key]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[$key]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[$key]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[$key]->USIM_PLAST;
            $response->STATUS= $ENTete[$key]->STATUS;        
           if($ENTete[$key]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[$key]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
         array_push($table, $response);
         }

      return response($table);
   }


   public function getCLIBL($cli)
   {        
      $ENTete= DB::table('ENT')->select(
         'ENT.ENT_ID',       
         'ENT.TICOD',
         'ENT.PICOD', 
         'ENT.PREFPINO',
         'ENT.PINO', 
         'ENT.PIDT',
         'ENT.TIERS',
         'ENT.REPR_0001',            
         'ENT.USIMAUTO', 
         'ENT.TTCMT',
         'ENT.USIM_RESTE',
         'ENT.USIM_ACOMPTE',
         'ENT.USIM_DATE'  ,
         'ENT.USIM_PLAST',
         'ENT.STATUS',
         'ENT.ADRTYP_0001',
         'ENT.U_TIMBRE',
         'CLI.NOM',
         'CLI.RUE',
         'CLI.VIL',
         'CLI.TEL',
          )         
         ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS')  
         ->where('ENT.DOS', 1)
         ->where('CLI.DOS', 1) 
         ->where('ENT.TIERS', $cli)
         ->where('PICOD',3)->orderBy('ENT_ID', 'DESC')
         ->get(); 
         $table=[];
         foreach ($ENTete as $key => $value) {       
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[$key]->ENT_ID;
            $response->TICOD = $ENTete[$key]->TICOD;
            $response->PICOD= $ENTete[$key]->PICOD;
            $response->TIERS= $ENTete[$key]->TIERS;
            $response->PREFPINO= $ENTete[$key]->PREFPINO;
            $response->PINO= $ENTete[$key]->PINO;
            $response->REPR_0001=" ";
            $response->U_TIMBRE= $ENTete[$key]->U_TIMBRE;
            $response->PIDT= $ENTete[$key]->PIDT;
            $response->STATUS= $ENTete[$key]->STATUS;
            $response->USIMAUTO= $ENTete[$key]->USIMAUTO;
            $response->CLINOM=$ENTete[$key]->NOM;
            $response->CLIFinal=$ENTete[$key]->NOM;         
            $response->TEL=$ENTete[$key]->TEL;            
            $response->RUE= $ENTete[$key]->RUE;            
            $response->REPRESENTANT=" ";
            $response->TTCMT= $ENTete[$key]->TTCMT;
            $response->USIM_RESTE= $ENTete[$key]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[$key]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[$key]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[$key]->USIM_PLAST;
            $response->STATUS= $ENTete[$key]->STATUS;        
           if($ENTete[$key]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[$key]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
         array_push($table, $response);
         }

      return response($table);
   }
     public function getCommd()
     {        
        $ENTete= ENT::where('PICOD',2)->get([
            'ENT_ID',       
            'TICOD',
            'PICOD',
            'TIERS',
            'PREFPINO',
            'PINO',
            'REPR_0001',
            'PIDT',
            'STATUS',
            'USIMAUTO',
            'TTCMT',
            'USIM_RESTE',
            'USIM_ACOMPTE',
            'USIM_DATE',
            'USIM_PLAST',
            'STATUS'
          
         ]);
         return response($ENTete);
     } 
     
     public function getById($id)
     {        
       $ENTete= DB::table('ENT')->select(
           'ENT.ENT_ID',       
           'ENT.TICOD',
           'ENT.PICOD', 
           'ENT.PREFPINO',
           'ENT.PINO', 
           'ENT.PIDT',
           'ENT.TIERS',
           'ENT.REPR_0001',            
           'ENT.USIMAUTO', 
           'ENT.TTCMT',
           'ENT.USIM_RESTE',
           'ENT.USIM_ACOMPTE',
           'ENT.USIM_DATE'  ,
           'ENT.USIM_PLAST',
           'ENT.STATUS',
           'ENT.ADRTYP_0001',
           'ENT.U_TIMBRE',
           'CLI.NOM',
           'CLI.RUE',
           'CLI.VIL',
           'CLI.TEL')
           ->join('CLI','CLI.TIERS', '=', 'ENT.TIERS') 
           ->where('ENT.DOS', 1)
           ->where('CLI.DOS', 1)
           ->where('ENT_ID',$id) 
           ->get(); 
            $response= new ENTT(); 
            $response->ENT_ID = $ENTete[0]->ENT_ID;
            $response->TICOD = $ENTete[0]->TICOD;
            $response->PICOD= $ENTete[0]->PICOD;
            $response->TIERS= $ENTete[0]->TIERS;
            $response->PREFPINO= $ENTete[0]->PREFPINO;
            $response->PINO= $ENTete[0]->PINO;
            $response->REPR_0001= $ENTete[0]->REPR_0001;
            $response->U_TIMBRE= $ENTete[0]->U_TIMBRE;
            $response->PIDT= $ENTete[0]->PIDT;
            $response->STATUS= $ENTete[0]->STATUS;
            $response->USIMAUTO= $ENTete[0]->USIMAUTO;
            $response->CLINOM=$ENTete[0]->NOM;
            $response->CLIFinal=$ENTete[0]->NOM;         
            $response->TEL=$ENTete[0]->TEL;            
            $response->RUE= $ENTete[0]->RUE;            
            $response->REPRESENTANT=$ENTete[0]->REPR_0001;
            $response->TTCMT= $ENTete[0]->TTCMT;
            $response->USIM_RESTE= $ENTete[0]->USIM_RESTE;
            $response->USIM_ACOMPTE= $ENTete[0]->USIM_ACOMPTE;
            $response->USIM_DATE= $ENTete[0]->USIM_DATE;
            $response->USIM_PLAST= $ENTete[0]->USIM_PLAST;
            $response->STATUS= $ENTete[0]->STATUS;        
           if($ENTete[0]->ADRTYP_0001 == 2)   {
            $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM', 'VIL', 'ADRCPL1 AS RUE', 'ADRCPL2 AS TEL')
                        ->where('DOS',"1") 
                        ->where('PINO',$ENTete[0]->PINO)
                        ->get(); 
            $response->CLIFinal=$cli->NOM;         
            $response->TEL=$cli->TEL;            
            $response->RUE=$cli->RUE;            
         }       
        return response($response);
     
     }
 
         /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function Add(Request $request)
     { 
         
      $lastPino= DB::table('ENT')->orderby('ENT_ID', 'desc')->select('ENT_ID')
      ->where('PICOD','2')
      ->where('TICOD','C')
      ->where('DOS', '1')
      ->where('ETB', '1')
      ->where('PREFPINO', 'BCVM      ')->get();
     
        DB::unprepared('SET IDENTITY_INSERT ART ON');
         $ENTete= new ENT(); 
         $ENTete->TIERS = request('TIERS');
         // $ENTete->TICOD = request('TICOD');
         // $ENTete->PICOD = request('PICOD');
         $ENTete->PREFPINO =request('PREFPINO');
         $ENTete->PINO = $lastPino[0]->ENT_ID+1;
         $ENTete->PIDT = request('PIDT');
         $ENTete->REPR_0001 = request('REPR_0001');
         $ENTete->STATUS = request('STATUS');
         $ENTete->USIMAUTO = request('USIMAUTO');
         $ENTete->TTCMT = request('TTCMT');
         $ENTete->USIM_RESTE = request('USIM_RESTE');
         $ENTete->USIM_ACOMPTE = request('USIM_ACOMPTE');
         $ENTete->USIM_PLAST = request('USIM_PLAST');          
         $ENTete->save();
         DB::unprepared('SET IDENTITY_INSERT ART OFF');
         return response($ENTete);

   }


        public function ADDENtet(Request $request){
         $lastPino= DB::table('ENT')->orderby('ENT_ID', 'desc')->select('ENT_ID')
         ->where('PICOD','2')
         ->where('TICOD','C')
         ->where('DOS', '1')
         ->where('ETB', '1')
         ->where('PREFPINO', 'BCVM      ')->get();
        
           DB::unprepared('SET IDENTITY_INSERT ART ON');
            $ENTete= new ENT(); 
            $ENTete->TIERS = request('TIERS'); 
            $ENTete->PREFPINO =request('PREFPINO');
            $ENTete->PINO = $lastPino[0]->ENT_ID+1;
            $ENTete->PIDT = request('PIDT');
            $ENTete->REPR_0001 = request('REPR_0001');
            $ENTete->STATUS = request('STATUS');
            $ENTete->USIMAUTO = request('USIMAUTO');
            $ENTete->USIM_RESTE = request('USIM_RESTE');
            $ENTete->USIM_ACOMPTE = request('USIM_ACOMPTE');
            $ENTete->USIM_PLAST = request('USIM_PLAST');          
            $ENTete->TTCMT = request('TTCMT');
            $ENTete->USIM_DATE= request('USIM_DATE');
            $ENTete->PIREF= request('PIREF');
            $ENTete->TIERSRLV= request('TIERSRLV');
            $ENTete->TAFAM= request('TTAFAMTCMT');
            $ENTete->TACOD= request('TACOD');
            $ENTete->HTMT= request('HTMT');
            $ENTete->HTPDTMT= request('HTPDTMT');
            $ENTete->REFNB= request('REFNB');
            $ENTete->USERCRDH= request('USERCRDH');
            $ENTete->USERMODH= NULL;
            $ENTete->save();
            DB::unprepared('SET IDENTITY_INSERT ART OFF');
            return response($ENTete);

        }
        
        
        public function getcommandesByRep($tiers)
     {
      $ENTete= DB::Select("SELECT       ENT_ID ,  TIERS,REPR_0001,
            PIDT,USIMAUTO,TTCMT,
            USIM_RESTE,USIM_ACOMPTE,
            USIM_DATE,USIM_PLAST, PREFPINO	,PINO AS PINO, PINA AS INTEGRE
         from ENT where REPR_0001='".$tiers."' and CE4=1 and PICOD=2
         UNION
         select  SIMENT_ID AS ENT_ID,  TIERS,REPR_0001, PIDT, USIMAUTO,   
         TTCMT, USIM_RESTE, USIM_ACOMPTE, USIM_DATE, USIM_PLAST,PREFPINO	  ,INTEGRE	,
         USIM_TRANSFERT_PINO AS PINO
         from SIMENT 
         order by  PIDT  DESC ");
   
         $VRP= VRP::where('TIERS',$tiers)->first(['NOM']);
          $result= array();
          foreach ($ENTete as $key => $value) {        
            $client= CLI::where('TIERS',$value->TIERS)->first(['NOM']);
            if($client){              
                  $response= new ENTState(); 
                  $response->ENT_ID = $value->ENT_ID;
                  $response->INTEGRE = $value->INTEGRE;
                  // $response->TICOD = $value->TICOD;
                  // $response->PICOD= $value->PICOD;
                  $response->TIERS= $value->TIERS; 
                  $response->PREFPINO= $value->PREFPINO;
                  $response->PINO= $value->PINO;
                  $response->REPR_0001= $value->REPR_0001;
                  $response->PIDT= $value->PIDT;
                  $response->PIDT= $value->PIDT;
                
                  
                  $response->USIMAUTO= $value->USIMAUTO;
                  $response->TTCMT= $value->TTCMT;
                  $response->USIM_RESTE= $value->USIM_RESTE;
                  $response->USIM_ACOMPTE= $value->USIM_ACOMPTE;
                  $response->USIM_DATE= $value->USIM_DATE;
                  $response->CLINOM=$client->NOM;
                  $response->REPRESENTANT=$VRP->NOM;
                  array_push($result, $response);
               }
          }
         return response($result);

     
     }
     public function getcommandesByRepState($tiers, $state)
     {
    
         $ENTete= DB::Select("select  SIMENT_ID AS ENT_ID,  TIERS,REPR_0001, PIDT, USIMAUTO,  INTEGRE,
       TTCMT, USIM_RESTE, USIM_ACOMPTE, USIM_DATE, USIM_PLAST	,PREFPINO	 ,USIM_TRANSFERT_PINO
        from SIMENT  where INTEGRE=".$state." and REPR_0001='".$tiers."'
        order by  PIDT  DESC ");
   
         $VRP= VRP::where('TIERS',$tiers)->first(['NOM']);
          $result= array();
          foreach ($ENTete as $key => $value) {        
            $client= CLI::where('TIERS',$value->TIERS)->first(['NOM']);
            if($client){              
                  $response= new ENTState(); 
                  
                  $response->INTEGRE = $value->INTEGRE;
                  $response->ENT_ID = $value->ENT_ID;
                  // $response->TICOD = $value->TICOD;
                  // $response->PICOD= $value->PICOD;
                  $response->TIERS= $value->TIERS; 
                  $response->PREFPINO= $value->PREFPINO;
                  // $response->PINO= $value->PINO;
                  $response->REPR_0001= $value->REPR_0001;
                  $response->PIDT= $value->PIDT; 
                  $response->USIMAUTO= $value->USIMAUTO;
                  $response->TTCMT= $value->TTCMT;
                  $response->USIM_RESTE= $value->USIM_RESTE;
                  $response->USIM_ACOMPTE= $value->USIM_ACOMPTE;
                  $response->USIM_DATE= $value->USIM_DATE;
                  $response->CLINOM=$client->NOM;
                  $response->REPRESENTANT=$VRP->NOM;
                  $response->USIM_TRANSFERT_PINO=$value->USIM_TRANSFERT_PINO;
                  
                  array_push($result, $response);
               }
          }
         return response($result);

     
     }
     public function getcommandesByCliRepState($tiers, $state, $cli)
     {
         if($state==5 || $state==6){

               $ENTete= DB::Select("select  SIMENT_ID AS ENT_ID,  TIERS,REPR_0001, PIDT, USIMAUTO,  
            TTCMT, USIM_RESTE, USIM_ACOMPTE, USIM_DATE, USIM_PLAST,PREFPINO	, U_TIMBRE ,INTEGRE,
            SIMENT_ID AS PINO
            from SIMENT  where INTEGRE=".$state." and REPR_0001='".$tiers."' and TIERS='".$cli."'
            order by  PIDT  DESC ");
            }
          
            else{
               $ENTete= DB::Select("SELECT ENT_ID , TIERS,REPR_0001,
            PIDT,USIMAUTO,TTCMT, USIM_RESTE,USIM_ACOMPTE, U_TIMBRE,
            USIM_DATE,USIM_PLAST,PREFPINO	, PINO	,INTEGRE 
            from ENT where REPR_0001='".$tiers."' and CE4=1 and TIERS='".$cli."' and PICOD=2
            order by  PIDT  DESC  ");
            }   
            $VRP= VRP::where('TIERS',$tiers)->first(['NOM']);
            $result= array();
            foreach ($ENTete as $key => $value) {        
               $client= CLI::where('TIERS',$cli)->first(['NOM']);
               if($client){              
                     $response= new INTEGER();                      
                     $response->INTEGRE = $value->INTEGRE;
                     $response->ENT_ID = $value->ENT_ID;
                     $response->TIERS= $value->TIERS; 
                     $response->PREFPINO= $value->PREFPINO;
                     $response->REPR_0001= $value->REPR_0001;
                     $response->PIDT= $value->PIDT;
                     $response->U_TIMBRE= $value->U_TIMBRE;
                     $response->USIMAUTO= $value->USIMAUTO;
                     $response->TTCMT= $value->TTCMT;
                     $response->USIM_RESTE= $value->USIM_RESTE;
                     $response->USIM_ACOMPTE= $value->USIM_ACOMPTE;
                     $response->USIM_DATE= $value->USIM_DATE;
                     $response->CLINOM=$client->NOM;
                     $response->REPRESENTANT=$VRP->NOM;
                     $response->PINO= $value->PINO;
                      
                     
                     array_push($result, $response);
                  }
            }
            return response($result);

     
     }


  
     public function updateEnt(Request $request){
       
      WebEnt::where('SIMENT_ID',$request->id)->update([          
        'TTCMT' => request('TTCMT'),
        'USIM_RESTE' => request('USIM_RESTE'),
        'USIM_ACOMPTE' => request('USIM_ACOMPTE'),
        'USIM_DATE' => request('USIM_DATE'),
        'USIM_PLAST' => request('USIM_PLAST'),
        'CPOSTAL' =>request('CPOSTAL'),
        'ADRCPL1' =>request('ADRCPL1'),             
        'TEL1' =>request('TEL1'),
        'TEL2' =>request('TEL2'),
        'TEL3' =>request('TEL3'),
        'NAME' =>request('NAME'),
      
        'ADRTYP_0003' => request('ADRTYP_0003'),
        ]);
        return  WebEnt::where('SIMENT_ID',$request->id)->first();
     }
     
   
     public function Update(Request $request)
     {        
        ENT::where('ENT_ID', request('ENT_ID'))->update([            
           
            'TICOD' => request('TICOD'),
            'PICOD' => request('PICOD'),
            'TIERS' => request('TIERS'),
            'PREFPINO' => request('PREFPINO'),
            'PINO' => request('PINO'),
            'REPR_0001' => request('REPR_0001'),
            'PIDT' => request('PIDT'),             
            'USIMAUTO' => request('USIMAUTO'), 
            'TTCMT' => request('TTCMT'), 
            'USIM_RESTE' => request('USIM_RESTE'), 
            'USIM_ACOMPTE' => request('USIM_ACOMPTE'), 
            'USIM_DATE' => request('USIM_DATE'),
            'USIM_PLAST' => request('USIM_PLAST'),
          
            
       
        ]);
        return  ENT::where('ENT_ID',request('ENT_ID'))->first();
        
     }
     public function UpdateWebEnt(Request $request)
     {        
      WebEnt::where('SIMENT_ID',$id)->update([              
          'TIERS' => request('TIERS'),
         'PIDT' => request('PIDT'),
         'USIMAUTO' => request('USIMAUTO'),
         'TTCMT' => request('TTCMT'),
         'USIM_RESTE' => request('USIM_RESTE'),
         'USIM_ACOMPTE' => request('USIM_ACOMPTE'),
         'USIM_DATE' => request('USIM_DATE'),
         'USIM_PLAST' => request('USIM_PLAST'),
         'INTEGRE' => request('INTEGRE'),
         'ADRTYP_0003' => request('REPR_0001'),
         'CPOSTAL' =>request('CPOSTAL'),
         'NAME' =>request('NAME'),
         'TEL1' =>request('TEL1'),
         'TEL2' =>request('TEL2'),
         'TEL3' =>request('TEL3'),
         'ADRCPL1' =>request('ADRCPL1'),             
         ]);
         return  WebEnt::where('SIMENT_ID',$id)->first();
 }
     
     public function Delete( $id)
     { 
         $ENTete= ENT::where('ENT_ID',$id);
         $ENTete->delete();
         return response(ENT::get(["ENT_ID",
         'ENT_ID',       
         'TICOD',
         'PICOD',
         'TIERS',
         'PREFPINO',
         'PINO',
         'REPR_0001',
         'PIDT', 
         'USIMAUTO',
         'TTCMT',
         'USIM_RESTE',
         'USIM_ACOMPTE',
         'USIM_DATE',
         'USIM_PLAST',
         
         ]));
     }
   
       
      public function getCommdByClient($clt, $rep)
      {
         
         $client= CLI::where('TIERS',$clt)->first(['NOM', 'TEL','RUE', 'VIL','CPOSTAL',]);
         $VRP= VRP::where('TIERS',$rep)->first(['NOM']);
          $ENTete= ENT::where('TIERS',$clt)->where('REPR_0001',$rep)
          ->where('CE4',1)->where('PICOD',2)->get([
            'ENT_ID',       
            'TICOD',
            'PICOD',
            'TIERS',
            'PREFPINO',
            'PINO',
            'REPR_0001',
            'PIDT',             
            'USIMAUTO', 
            'TTCMT',
            'USIM_RESTE',
            'USIM_ACOMPTE',
            'USIM_DATE',
            'ADRTYP_0001',
            'U_TIMBRE',
            'USIM_PLAST'          
          ]);
          $result= array();
          foreach ($ENTete as $key => $value) {  
            $Final_Client=$client->NOM ;  
            if($value->ADRTYP_0001 == 2)   {
               $cli=DB::connection('sqlsrv')->table('EAD')->select('NOM')
                           ->where('DOS',"1") 
                           ->where('PINO',$value->PINO)
                           ->get(); 
               $Final_Client=$cli->NOM;
            }    
            $response= new ENTT(); 
            $response->ENT_ID = $value->ENT_ID;
            $response->TICOD = $value->TICOD;
            $response->PICOD= $value->PICOD;
            $response->TIERS= $value->TIERS;
            $response->PREFPINO= $value->PREFPINO;
            $response->PINO= $value->PINO;
            $response->REPR_0001= $value->REPR_0001;
            $response->PIDT= $value->PIDT; 
            $response->U_TIMBRE= $value->U_TIMBRE;
            $response->USIMAUTO= $value->USIMAUTO;
            $response->CLINOM=$client->NOM;
            $response->CLIFinal=$Final_Client;            
            $response->TEL=$client->TEL;            
            $response->RUE=$client->RUE.$client->VIL;            
            $response->REPRESENTANT=$VRP->NOM;
            $response->TTCMT= $value->TTCMT;
            $response->USIM_RESTE= $value->USIM_RESTE;
            $response->USIM_ACOMPTE= $value->USIM_ACOMPTE;
            $response->USIM_DATE= $value->USIM_DATE;
            $response->USIM_PLAST= $value->USIM_PLAST;            
            array_push($result, $response);
          }
       return response($result);

         
      }
         
  
      public function getAdress(){
         return  DB::Select("SELECT * from T057 ");
      }
     
 
}
