<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MOUV; 
use App\Models\ENT;
use Illuminate\Support\Facades\DB;

class MOUVController extends Controller
{


        //   getALLProductByClt :  get all ligne de commande by client  route: Panier/allProducts/{clt}
        //   product 
        //   IncrementQte




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
     public function getMouv()
     {        
         return   MOUV::get([
            'MOUV_ID',
            'DOS',
            'REF', 
            'PREFDVNO',
            'DVNO',
            'PREFCDNO',
            'CDNO', 
            'PREFBLNO',
            'BLNO',  
            'PREFFANO',
            'FANO',
            'DVQTE',
            'CDQTE',
            'BLQTE',
            'FAQTE',
            'DES',         
            'ENRNO',
            'REPR_0001',
            'TIERS'
         ]);
     } 
 
         /**
      * Store a newly created resource in storage.
      *
      * don't accept null variable :( 
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function Add(Request $request)
     { 
       
         // DB::unprepared('SET IDENTITY_INSERT MOUV ON'); 
         $MOUV= new MOUV();     
         $MOUV->REF = '';
         $MOUV->PREFCDNO = request('PREFCDNO');
         $MOUV->CDNO = request('CDNO');
         $MOUV->CDQTE = request('CDQTE');
         $MOUV->TIERS = request('TIERS');
         $MOUV->PREFDVNO = '';
         $MOUV->DVNO = 0;
         $MOUV->PREFBLNO = '';
         $MOUV->BLNO = 0;
         $MOUV->PREFFANO = '';
         $MOUV->FANO =0;
         $MOUV->DVQTE = 0;
         $MOUV->BLQTE = 0;
         $MOUV->FAQTE = 0;
         $MOUV->DOS = '1';
         $MOUV->REPR_0001 =  request('REPR_0001');
         $MOUV->PICOD = request('PICOD');
         $MOUV->DES = request('DES');
         $MOUV->PUB = request('PUB');
         
         $MOUV->save();
         // DB::unprepared('SET IDENTITY_INSERT MOUV OFF');
         return response($MOUV);
     }


     public function AddMouv(Request $request)
     { 
        
         $MOUV= new MOUV();     
         $MOUV->TIERS = request('TIERS');
         $MOUV->REF = '';
         $MOUV->PREFDVNO = '';
         $MOUV->DVNO = 0;
         $MOUV->PREFCDNO = request('PREFCDNO');
         $MOUV->CDNO = request('CDNO');
         $MOUV->CDQTE = request('CDQTE');
         $MOUV->DES = request('DES');
         $MOUV->ENRNO = request('ENRNO');        
         $MOUV->REPR_0001 =  request('REPR_0001');
         $MOUV->PUB = request('PUB');        
         $MOUV->CDDT= request('CDDT');  
         $MOUV->CDLG= request('CDLG'); 
         $MOUV->CDSLG= request('CDSLG');   
         $MOUV->CDENRNO= request('CDENRNO'); 
         $MOUV->FADT= request('FADT'); 
         $MOUV->REFAMR= request('REFAMR');
         $MOUV->TACOD= request('TACOD'); 
         $MOUV->REMCOD= request('REMCOD'); 
         $MOUV->PUSTAT= request('PUSTAT');  
         $MOUV->REFQTE= request('REFQTE'); 
         $MOUV->MONT= request('MONT'); 
         $MOUV->DECCOD= request('DECCOD');  
         $MOUV->MVCOD= request('MVCOD'); 
         $MOUV->PRGQTE= request('PRGQTE'); 
         $MOUV->GRATUITFL= request('GRATUITFL'); 
         $MOUV->USERCR= request('USERCR');
         $MOUV->USERMO= NULL;
         $MOUV->USERCRDH= request('USERCRDH'); 
         $MOUV->USERMODH= NULL;
         
         $MOUV->save();
         // DB::unprepared('SET IDENTITY_INSERT MOUV OFF');
         return response($MOUV);
     }
 
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      * 
      */
     public function GetById($request)
     {
      $ENTete= ENT::where('ENT_ID',$request)->where('DOS',1)->select('ENT_ID','PINO','PREFPINO','TICOD')->first();

      if($ENTete){
        $Mouv = DB::table('MOUV')->select(
           'MOUV_ID',             
           'REF', 
           'PREFDVNO',
           'DVNO',
           'PREFCDNO',
           'CDNO', 
           'PREFBLNO',
           'BLNO',  
           'PREFFANO',
           'FANO',
           'DVQTE',
           'CDQTE',
           'BLQTE',
           'FAQTE',
           'DES',         
           'ENRNO',
           'ENT.PINO',
           'ENT.PIREF',
           'PUB',
           'ENT.TICOD') 
        //    ->join('ENT','ENT.PREFPINO', '=', 'MOUV.PREFCDNO')
           ->join('ENT','ENT.PINO', '=', 'MOUV.CDNO')
        //    ->join('ENT','ENT.TICOD', '=', 'MOUV.TICOD')
           ->where('ENT.DOS', 1)
           ->where('MOUV.DOS', 1)
           ->where('MOUV.CDNO' , $ENTete->PINO ) 
           ->where('MOUV.PREFCDNO' ,  $ENTete->PREFPINO)
           ->where('MOUV.TICOD' ,  $ENTete->TICOD)
           ->get();
           return response($Mouv);
      }
         else{
            return response('not found !');
         }
                   
      
     
     }
     
     public function GetByENT($request, $type)
     {
        $ENTete= ENT::where('ENT_ID',$request)->where('DOS',1)->select('ENT_ID','PINO','PREFPINO','TICOD')->first();
           if($type == 'BL'){
         if($ENTete){
            $Mouv = DB::table('MOUV')->select(
               'MOUV_ID',             
               'REF', 
               'PREFDVNO',
               'DVNO',
               'PREFCDNO',
               'CDNO', 
               'PREFBLNO',
               'BLNO',  
               'PREFFANO',
               'FANO',
               'DVQTE',
               'CDQTE',
               'BLQTE',
               'FAQTE',
               'DES',         
               'ENRNO',
               'ENT.PINO',
               'ENT.PIREF',
               'PUB',
               'ENT.TICOD')  
               ->join('ENT','ENT.PINO', '=', 'MOUV.BLNO') 
               ->where('ENT.DOS', 1)
               ->where('MOUV.DOS', 1)
               ->where('MOUV.BLNO' , $ENTete->PINO ) 
               ->where('MOUV.PREFBLNO' ,  $ENTete->PREFPINO)
               ->where('MOUV.TICOD' ,  $ENTete->TICOD)
               ->where('MOUV.PICOD' ,  3)
               ->get();
               return response($Mouv);
              
         }
            else{
               return response('BL not found !');
            }
      }else{
         if($ENTete){
         $Mouv = DB::table('MOUV')->select(
            'MOUV_ID',             
            'REF', 
            'PREFDVNO',
            'DVNO',
            'PREFCDNO',
            'CDNO', 
            'PREFBLNO',
            'BLNO',  
            'PREFFANO',
            'FANO',
            'DVQTE',
            'CDQTE',
            'BLQTE',
            'FAQTE',
            'DES',         
            'ENRNO',
            'ENT.PINO',
            'ENT.PIREF',
            'PUB',
            'ENT.TICOD')  
            ->join('ENT','ENT.PINO', '=', 'MOUV.FANO') 
            ->where('ENT.DOS', 1)
            ->where('MOUV.DOS', 1)
            ->where('MOUV.FANO' , $ENTete->PINO ) 
            ->where('MOUV.PREFFANO' ,  $ENTete->PREFPINO)
            ->where('MOUV.TICOD' ,  $ENTete->TICOD)
            ->where('MOUV.PICOD' ,  4)
            ->get();
            return response($Mouv);
       }
          else{
             return response(' Facture not found !');
          }

      }
                   
      
     
     }
     

      public function  GetByPINO($pino)
      {
        
         $ENTete= ENT::where('PINO',$pino)->where('DOS',1)
         ->where('TICOD','C')
         ->where('PICOD',4)
         ->select('ENT_ID','PINO','PREFPINO','TICOD')->first();
   
         if($ENTete){
           $Mouv = DB::table('MOUV')->select(
              'MOUV_ID',             
              'REF', 
              'PREFDVNO',
              'DVNO',
              'PREFCDNO',
              'CDNO', 
              'PREFBLNO',
              'BLNO',  
              'PREFFANO',
              'FANO',
              'DVQTE',
              'CDQTE',
              'BLQTE',
              'FAQTE',
              'DES',         
              'ENRNO',
              'ENT.PINO',
              'ENT.PIREF',
              'PUB',
              'ENT.TICOD')  
              ->join('ENT','ENT.PINO', '=', 'MOUV.CDNO') 
              ->where('ENT.DOS', 1)
              ->where('MOUV.DOS', 1)
              ->where('MOUV.CDNO' , $pino ) 
              ->where('MOUV.PREFCDNO' ,  $ENTete->PREFPINO)
              ->where('MOUV.TICOD' ,  $ENTete->TICOD)
              ->get();
              return response($Mouv);
         }
            else{
               return response('not found !');
            }
                      
         
        
        }
          /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      * 
      */
      public function GetByClt($id)
      {
          $MOUV= MOUV::where('TIERS',$id)->get([
             'MOUV_ID',
             'DOS',
             'REF', 
             'PREFDVNO',
             'DVNO',
             'PREFCDNO',
             'CDNO', 
             'PREFBLNO',
             'BLNO',  
             'PREFFANO',
             'FANO',
             'DVQTE',
             'CDQTE',
             'BLQTE',
             'FAQTE',
             'DES',
             'ENRNO',
             'REPR_0001',    
             'TIERS' 
           
          ]);
          return response($MOUV);
      
      }
     
     
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {        MOUV::where('MOUV_ID',$id)->update([              
         'DOS' => request('DOS'),
         'REF' => request('REF'),
         'PREFDVNO' => request('PREFDVNO'),
         'DVNO' => request('DVNO'),
         'PREFCDNO' => request('PREFCDNO'),
         'CDNO' => request('CDNO'),
         'PREFBLNO' => request('PREFBLNO'),
         'BLNO' => request('BLNO'),
         'PREFFANO' => request('PREFFANO'),
         'FANO' => request('FANO'),
         'DVQTE' => request('DVQTE'),
         'CDQTE' => request('CDQTE'),
         'BLQTE' => request('BLQTE'),
         'FAQTE' => request('FAQTE'),
         'DES' => request('DES'),
         'TIERS' => request('TIERS'),
         

        
         ]);
         return  MOUV::where('MOUV_ID',$id)->first();
     }
     
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function delete($id)
     {          
         $MOUVete= MOUV::where('CDNO',$id);
         $MOUVete->delete();
         return response(MOUV::get(["MOUV_ID",
         'MOUV_ID',
         'DOS',
         'REF', 
         'PREFDVNO',
         'DVNO',
         'PREFCDNO',
         'CDNO', 
         'PREFBLNO',
         'BLNO',  
         'PREFFANO',
         'FANO',
         'DVQTE',
         'CDQTE',
         'BLQTE',
         'FAQTE',
         'DES',
         'ENRNO',
         'REPR_0001',     
         'TIERS'
         ]));
     }
 
     public function tt( $id)
     {
         $ENTete= MOUV::where('CDNO',$id);
         // echo $ENTete; 
         if($ENTete){
            $ENTete->delete();
         }
         return response(MOUV::get([ 
           
            'TIERS'
          
         ]));
     }
     }
  
 