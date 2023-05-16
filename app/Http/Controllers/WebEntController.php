<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebEnt;
use App\Models\ENTT;
use App\Models\CLI;
use App\Models\VRP;

use Illuminate\Support\Facades\DB;


class WebEntController extends Controller
{
   public function getCliCommande($cli){
      $ENTete=DB::select("SELECT  SIMENT.SIMENT_ID AS ENT_ID, SIMENT.PIDT, SIMENT.USIMAUTO, SIMENT.TIERS, 
         SIMENT.TTCMT, SIMENT.USIM_RESTE, SIMENT.USIM_ACOMPTE, SIMENT.USIM_DATE, SIMENT.USIM_PLAST, 
         SIMENT.NAME, SIMENT.TEL1, SIMENT.TEL2, SIMENT.U_TIMBRE,
         SIMENT.TEL3, SIMENT.ADRCPL1, SIMENT.PREFPINO, SIMENT.CPOSTAL, SIMENT.ADRTYP_0003, 
         CLI.RUE, CLI.NOM, SIMENT.INTEGRE, SIMENT.REPR_0001, SIMENT.PICODE, SIMENT.USIM_TRANSFERT_PINO,
         CLI.DOS
      FROM     SIMENT INNER JOIN
          CLI ON SIMENT.TIERS = CLI.TIERS
      WHERE  (CLI.DOS = 1) AND (SIMENT.TIERS = '".$cli."')");
       $table=[];
       foreach ($ENTete as $key => $value) {
         # code...
         $response= new ENTT(); 
         $response->U_TIMBRE= $value->U_TIMBRE;
         $response->ENT_ID = $value->ENT_ID; 
         $response->TIERS= $value->TIERS;
         $response->PREFPINO= $value->PREFPINO; 
         $response->REPR_0001=" ";
         $response->PIDT= $value->PIDT; 
         $response->USIMAUTO= $value->USIMAUTO;
         $response->CLINOM=$value->NOM;
         $response->CLIFinal=$value->NOM;         
         $response->TEL=$value->TEL1;            
         $response->RUE= $value->RUE;            
         $response->REPRESENTANT=" ";
         $response->TTCMT= $value->TTCMT;
         $response->USIM_RESTE= $value->USIM_RESTE;
         $response->USIM_ACOMPTE= $value->USIM_ACOMPTE;
         $response->USIM_DATE= $value->USIM_DATE;
         $response->USIM_PLAST= $value->USIM_PLAST;     
         $response->INTEGRE= $value->INTEGRE;   
         array_push($table, $response);
      }

      return response($table);    
   }
    
    public function UpdateEnt(Request $request)
        {        
            WebEnt::where('SIMENT_ID',$request->id)->update([              
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
            return  WebEnt::where('SIMENT_ID',$request->id)->first();
    }

    public function getById($id)
        {        
          $ENTete= DB::table('SIMENT')->select(
              'SIMENT.SIMENT_ID',       
            //   'SIMENT.TICOD',
            //   'SIMENT.PICOD', 
              'SIMENT.PREFPINO',
            //   'SIMENT.PINO', 
              'SIMENT.PIDT',
              'SIMENT.TIERS',
              'SIMENT.REPR_0001',            
              'SIMENT.USIMAUTO', 
              'SIMENT.TTCMT',
              'SIMENT.USIM_RESTE',
              'SIMENT.USIM_ACOMPTE',
              'SIMENT.USIM_DATE'  ,
              'SIMENT.USIM_PLAST',
              'SIMENT.U_TIMBRE', 
              'SIMENT.INTEGRE',
              'SIMENT.ADRTYP_0003',
              'SIMENT.CPOSTAL',
              'SIMENT.NAME',
              'SIMENT.TEL1',
              'SIMENT.TEL2',
              'SIMENT.TEL3',
              'SIMENT.ADRCPL1',              
              'CLI.NOM',
              'CLI.RUE',
              'CLI.VIL',
              'CLI.TEL')
              ->join('CLI','CLI.TIERS', '=', 'SIMENT.TIERS') 
          
              ->where('CLI.DOS', 1)
              ->where('SIMENT_ID',$id) 
              ->get(); 
               $response= new ENTT(); 
               $response->SIMENT_ID =$ENTete[0]->SIMENT_ID;
               $response->INTEGRE= 0;
               $response->U_TIMBRE= $ENTete[0]->U_TIMBRE;
            //    $response->TICOD = $ENTete[0]->TICOD;
            //    $response->PICOD= $ENTete[0]->PICOD;
               $response->TIERS= $ENTete[0]->TIERS;
               $response->PREFPINO= $ENTete[0]->PREFPINO;
            //    $response->PINO= $ENTete[0]->PINO;
               $response->REPR_0001= $ENTete[0]->REPR_0001;
               $response->PIDT= $ENTete[0]->PIDT;
            //    $response->STATUS= $ENTete[0]->STATUS;
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
            //    $response->STATUS= $ENTete[0]->STATUS;        
               $response->INTEGRE= $ENTete[0]->INTEGRE;   
           return response($response);        
    }
    public function Add(Request $request)
     {          
     
         $ENTete= new WebEnt();         
         $ENTete->TIERS = request('TIERS');        
         $ENTete->PIDT =request('PIDT');         
         $ENTete->USIMAUTO =request('USIMAUTO');
         $ENTete->TTCMT =request('TTCMT');
         $ENTete->USIM_RESTE =request('USIM_RESTE');
         $ENTete->USIM_ACOMPTE =request('USIM_ACOMPTE');
         $ENTete->USIM_DATE =request('USIM_DATE');
         $ENTete->USIM_PLAST =request('USIM_PLAST'); 
         $ENTete->INTEGRE =request('INTEGRE'); 
         $ENTete->REPR_0001 =request('REPR_0001');
         $ENTete->USIM_TRANSFERT_PINO=0;
         $ENTete->U_TIMBRE=request('U_TIMBRE');         
           $ENTete->CPOSTAL =request('CPOSTAL');
           $ENTete->NAME =request('NAME');
           $ENTete->TEL1 =request('TEL1');
           $ENTete->TEL2 =request('TEL2');
           $ENTete->TEL3 =request('TEL3');
           $ENTete->ADRCPL1 =request('ADRCPL1'); 
           $ENTete->PREFPINO =request('PREFPINO');  
           if(request('CPOSTAL') == null) $ENTete->ADRTYP_0003 =1;
           else  $ENTete->ADRTYP_0003 =2;          
         $ENTete->save();
         return response($ENTete);
    }
    public function Delete( $id)
    { 
        $ENTete= WebEnt::where('SIMENT_ID',$id);
        $ENTete->delete();
        return response(WebEnt::get(["SIMENT_ID",
        'SIMENT_ID',       
       
        
        ]));
    }

    
    public function getWebCommdByClient($clt, $rep)
    {       
       $client= CLI::where('TIERS',$clt)->first(['NOM', 'TEL','RUE', 'VIL','CPOSTAL',]);
       $VRP= VRP::where('TIERS',$rep)->first(['NOM', 'TIERS']);
       $ENTete=DB::select("SELECT  SIMENT.SIMENT_ID AS ENT_ID, SIMENT.PIDT, SIMENT.USIMAUTO, SIMENT.TIERS, 
       SIMENT.TTCMT, SIMENT.USIM_RESTE, SIMENT.USIM_ACOMPTE, SIMENT.USIM_DATE, SIMENT.USIM_PLAST, 
       SIMENT.NAME, SIMENT.TEL1, SIMENT.TEL2, SIMENT.U_TIMBRE,
       SIMENT.TEL3, SIMENT.ADRCPL1, SIMENT.PREFPINO, SIMENT.CPOSTAL, SIMENT.ADRTYP_0003, 
       CLI.RUE, CLI.NOM, SIMENT.INTEGRE, SIMENT.REPR_0001, SIMENT.PICODE, SIMENT.USIM_TRANSFERT_PINO,
       CLI.DOS
         FROM     SIMENT INNER JOIN
            CLI ON SIMENT.TIERS = CLI.TIERS
         WHERE  (CLI.DOS = 1) AND (SIMENT.TIERS = '".$clt."')");
         $table=[];
         foreach ($ENTete as $key => $value) {
            # code...
            $response= new ENTT(); 
            $response->U_TIMBRE= $value->U_TIMBRE;
            $response->ENT_ID = $value->ENT_ID; 
            $response->TIERS= $value->TIERS;
            $response->PREFPINO= $value->PREFPINO; 
            $response->REPR_0001=$VRP->TIERS;
            $response->PIDT= $value->PIDT; 
            $response->USIMAUTO= $value->USIMAUTO;
            $response->CLINOM=$value->NOM;
            $response->CLIFinal=$value->NOM;         
            $response->TEL=$value->TEL1;            
            $response->RUE= $value->RUE;            
            $response->REPRESENTANT=$VRP->NOM;;
            $response->TTCMT= $value->TTCMT;
            $response->USIM_RESTE= $value->USIM_RESTE;
            $response->USIM_ACOMPTE= $value->USIM_ACOMPTE;
            $response->USIM_DATE= $value->USIM_DATE;
            $response->USIM_PLAST= $value->USIM_PLAST;     
            $response->INTEGRE= $value->INTEGRE;   
            array_push($table, $response);
         }
         return response($table);    
       
       
    }   
 
    public function VAlidateENT($id)
    {       
        WebEnt::where('SIMENT_ID',$id)->update([              
         
        'INTEGRE' => 6,
                    
        ]);
        return  WebEnt::where('SIMENT_ID',$id)->first();
}
 }
