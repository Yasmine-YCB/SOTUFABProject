<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//         $Article= ART::where('FAM_0001','like', $id.'%')->where('PRODNAT','2PF')     
//             ->where('DOS','1')->get([
//             'DOS',
//             'DES',
//             'REF',
//             'FAM_0001',
//             'PRODNAT', 
//             'QTE',
//             'LGTYP',
//             'USIM_PRIX_BASE',        
//         ]);
//     //   return response($Article);
//   foreach ($Article as $key => $value) {        
//     if($value->LGTYP != 2){
//         $Qte=0; 
//         $MVTL=DB::connection('sqlsrv')->table('MVTL')->select(
//             'REF' , 'QTE', 'STQTE', 'REFQTE', 'OP', 'DEPO')
//           ->where('DOS',"1")
//           ->where('DEPO',"2") 
//           ->where('REF',$value->REF)
//           ->get(); 
          
//           foreach ($MVTL as $key => $val) {
//             $Qte= $Qte+$val->STQTE;       // echo $Qte;            
//             if($val->OP=="999"){
//                 $Qte=$Qte-$val->REFQTE;
//             }                    
//           } 
//         $value->QTE= $Qte;
       
//     }
//     else{
//         $nb_kit=0;
//         $MVTL=DB::connection('sqlsrv')->table('DAR')->select('REFCO', 'DAR_ID', 'QTE')
//             ->where('DOS',"1") 
//             ->where('REF',$value->REF)
//             ->get(); 
//             echo "dar";
//             echo $MVTL;
//         $Qte=0; 
//        foreach ($MVTL as $keys => $DarValue) {        
//            if($DarValue){
//             $MVTL=DB::connection('sqlsrv')->table('MVTL')->select(
//                 'REF' , 'QTE', 'STQTE', 'REFQTE', 'OP', 'DEPO', 'QTE'
//             )
//             ->where('DOS',"1")
//             ->where('DEPO',"2") 
//             ->where('REF',$DarValue->REFCO)
//             ->get(); 
            
//             foreach ($MVTL as $key => $val) {
//                 $Qte= $Qte+$val->STQTE;
//                 // echo $Qte;
                
//                 if($val->OP=="999"){
//                     $Qte=$Qte-$val->REFQTE;
//                 }                    
//             } 
//             // after foreach
           
//             if($Qte/$DarValue->QTE < $nb_kit){
//                 $nb_kit= $Qte/$DarValue->QTE;
//             }
//            }
           
//         }
//         $value->QTE= $nb_kit;
//     }
//   }
        

        /////////////////////////////////get Article By Famille where Gtyp != 2
// public function getArtByFamGtypnot2($fam){
//             $Article= ART::where('FAM_0001','like', $fam.'%')
//                 ->where('PRODNAT','2PF')
//                 ->where('LGTYP','<>','2')     
//                 ->where('DOS','1')
//                 ->limit(10)
//                 ->get([
//                 'DOS',
//                 'DES',
//                 'REF',
//                 'FAM_0001',
//                 'PRODNAT', 
//                 'QTE',
//                 'LGTYP',
//                 'USIM_PRIX_BASE',        
//             ]);
//         foreach ($Article as $key => $value) {        
//             if($value->LGTYP != 2){
//                 $Qte=0; 
//                 $MVTL=DB::connection('sqlsrv')->table('MVTL')->select(
//                     'REF' , 'QTE', 'STQTE', 'REFQTE', 'OP', 'DEPO')
//                 ->where('DOS',"1")
//                 ->where('DEPO',"2") 
//                 ->where('REF',$value->REF)
//                 ->get(); 
                
//                 foreach ($MVTL as $key => $val) {
//                     $Qte= $Qte+$val->STQTE;                 
//                     if($val->OP=="999"){
//                         $Qte=$Qte-$val->REFQTE;
//                     }                    
//                 } 
//                 $value->QTE= $Qte;            
//             }
            
//         }
//         return response($Article);
//         }


//     ////////////////////////////////get Article By Famille where Gtyp = 1 ou  Gtyp = 3
    
//     public function GetByFamGTypis2($id)
//     {   $Article= ART::where('FAM_0001','like', $id.'%')
//         ->where('PRODNAT','2PF')
//         ->where('LGTYP','2')     
//         ->where('DOS','1')
//         ->limit(10)->get([
//         'DOS',
//         'DES',
//         'REF',
//         'FAM_0001',
//         'PRODNAT', 
//         'QTE',
//         'LGTYP',
//         'USIM_PRIX_BASE',        
//     ]);
//     foreach ($Article as $key => $value) {        
//         $nb_kit=0;
//             $MVTL=DB::connection('sqlsrv')->table('DAR')->select('REFCO', 'DAR_ID', 'QTE')
//                 ->where('DOS',"1") 
//                 ->where('REF',$value->REF)
//                 ->get();  
//             $Qte=0; 
//            foreach ($MVTL as $keys => $DarValue) {        
//                if($DarValue){
//                 $MVTL=DB::connection('sqlsrv')->table('MVTL')->select(
//                     'REF' , 'QTE', 'STQTE', 'REFQTE', 'OP', 'DEPO', 'QTE'
//                 )
//                 ->where('DOS',"1")
//                 ->where('DEPO',"2") 
//                 ->where('REF',$DarValue->REFCO)
//                 ->get();                 
//                 foreach ($MVTL as $key => $val) {
//                     $Qte= $Qte+$val->STQTE;
//                     if($val->OP=="999"){
//                         $Qte=$Qte-$val->REFQTE;
//                     }                    
//                 } 
               
//                 if($Qte/$DarValue->QTE < $nb_kit){
//                     $nb_kit= $Qte/$DarValue->QTE;
//                 }
//                }
//             }
//             $value->QTE= $nb_kit;
//         }
//         return response($Article);
//   } 
}
