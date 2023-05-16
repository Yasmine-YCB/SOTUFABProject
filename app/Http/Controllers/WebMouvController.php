<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WebMouv;

class WebMouvController extends Controller
{
 
    public function Add(Request $request)
    {          
 
       // DB::unprepared('SET IDENTITY_INSERT SIMENT ON');
        $Mouv= new WebMouv();         
        $Mouv->REF = request('REF');        
        $Mouv->SREF1 =request('SREF1');
        $Mouv->SREF2 =request('SREF2');
        $Mouv->TIERS =request('TIERS');
        $Mouv->DES =request('DES');
        $Mouv->PUB =request('PUB');
        $Mouv->DEPO =request('DEPO');
        $Mouv->CDQTE =request('CDQTE');
        $Mouv->CDCODE =request('CDCODE');
        $Mouv->PDT= request('PDT');
        $Mouv->CDSLG= request('CDSLG');
        $Mouv->PICODE= 1;
        $Mouv->REM_0001 =request('REM_0001');
        $Mouv->REM_0002 =request('REM_0002');
        $Mouv->REM_0003 =request('REM_0003');
        $Mouv->REMTYP_0001= request('REMTYP_0001');
        $Mouv->REMTYP_0002= request('REMTYP_0002');
        $Mouv->REMTYP_0003= request('REMTYP_0003');
        $Mouv->save();
        return response($Mouv);
    }
    public function AddTable(Request $request)
    {   
         $table=[];               
         $response=[];               
         $table=$request->input('objects');               
         foreach ($table as $key => $value) {            
            $Mouv= new WebMouv();  
        $Mouv->REF = $value['REF'] ;        
        // $Mouv->SREF1 =$value['SREF1'] ;
        // $Mouv->SREF2 =$value['SREF2'] ;
        $Mouv->TIERS =$value['TIERS'] ;
        $Mouv->DES =$value['DES'] ;
        $Mouv->PUB =$value['PUB'] ;
        $Mouv->DEPO =$value['DEPO'] ;
        $Mouv->CDQTE =$value['CDQTE'] ;
        $Mouv->CDCODE =$value['CDCODE'] ;
        $Mouv->PDT= $value['PDT'] ;
        $Mouv->CDSLG= $value['CDSLG'] ;
        $Mouv->PICODE= 1;
        $Mouv->REM_0001 =$value['REM_0001'] ;
        $Mouv->REM_0002 =$value['REM_0002'] ;
        $Mouv->REM_0003 =$value['REM_0003'] ;
        $Mouv->REMTYP_0001= $value['REMTYP_0001'] ;
        $Mouv->REMTYP_0002= $value['REMTYP_0002'] ;
        $Mouv->REMTYP_0003= $value['REMTYP_0003'] ; 
        $Mouv->save();
            }
        return  $table;   
    }

       public function update(Request $request, $id)
       {        
        MOUV::where('SIMMOUV_ID',$id)->update([              
           'REF' => request('REF'),
           'SREF1' => request('SREF1'),
           'SREF2' => request('SREF2'),
           'TIERS' => request('TIERS'),
           'DES' => request('DES'),
           'PUB' => request('PUB'),
           'DEPO' => request('DEPO'),
           'CDQTE' => request('CDQTE'),
           'CDCODE' => request('CDCODE'),  
           'REM_0001' => request('REM_0001'),  
           'REM_0002' => request('REM_0002'),  
           'REM_0003' => request('REM_0003'),            
           ]);
           return  MOUV::where('SIMMOUV_ID',$id)->first();
       }
       public function updateMouvQte(Request $request)
       {        $table=[];               
                $table=$request->input('objects');;        
            //    return $table;
            foreach ($table as $key => $value) {             
              $tt= WebMouv::where('SIMMOUV_ID', $value['id'])
              ->update(['CDQTE' =>   $value['CDQTE']]);
                     
            }
           return  $table;
       }
       

       public function GetWebByENT($id)
       { 
          $Mouv = DB::table('SIMMOUV')->select(
            'SIMMOUV_ID AS id',
            'REF',
            'SREF1',
            'SREF2',      
            'TIERS',
            'DES',
            'PUB',        
            'DEPO',       
            'CDQTE',
            'CDCODE', 
            'REM_0001',
            'REM_0002',
            'REM_0003', 
            'PDT')
            ->where('CDCODE',$id)       
            ->get();
        return response($Mouv);
     
       
       }

     
     public function Delete( $id)
     { 
         $ENTete= WebMouv::where('CDCODE',$id);         
         $ENTete->delete(); 
         return response(WebMouv::get([ 
         'SIMMOUV_ID',
         'REF',
         'SREF1',
         'SREF2',      
         'TIERS',
         'DES',
         'PUB',        
         'DEPO',       
         'CDQTE',
         'CDCODE',
         'CDQTE'
         ]));
     }
}
