<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\CLI;
use App\Models\Vice;
use Carbon\Carbon;
class CLIController extends Controller
{
       
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAll()
    {
        $client = DB::select("select NOM,
        RUE,
        VIL,
        CPOSTAL,
        PAY,
        TEL,
        FAX,
        WEB,
        EMAIL,
        TIERS,
        FEU,
        TACOD,  REFAMX , REFAM , REMCOD , TPFT ,U_TIMBRE
        from CLI where DOS=1 
      
        ");
        return   $client;
        
        
    }
    public function  getClientsByRep($rep){ 
        $client= CLI::where('DOS',1)     
        ->where('REPR_0001',$rep)
        ->select([
            'NOM',
            'RUE',
            'VIL',
            'CPOSTAL',
            'PAY',
            'TEL',
            'FAX',
            'WEB',
            'EMAIL',
            'TIERS',
            'FEU',
            'TACOD',
            'REPR_0001', 
            'TPFT',
            'U_TIMBRE'
        ])->where( 'DOS', 1)->get();
        return response($client);
    }
 
    public function search($request )
    {
        $client= CLI::where('TIERS',$request->TIERS)
        ->where('NOM',$request->NOM)
        ->where('EMAIL',$request->EMAIL)
        ->where('TEL',$request->TEL)
        ->where('DOS',1)->first([
            'NOM',
            'RUE',
            'VIL',
            'CPOSTAL',
            'PAY',
            'TEL',
            'FAX',
            'WEB',
            'EMAIL',
            'TIERS', 
            'FEU',        
            'TACOD', 
            'TPFT',
            'U_TIMBRE'
        ]);
        return response($client);
    
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AddClient(Request $request)
    
    { 
        $serach= $this->search($request );
        if($serach){
            return 'Client déja existe';
        }
        else{
            $lastCLI= CLI::orderby('CLI_ID', 'desc')->first();
            $CLI_ID = $lastCLI->CLI_ID + 1;
            echo $CLI_ID;
            DB::unprepared('SET IDENTITY_INSERT CLI ON');
            $client= new CLI(); 
            $client->CLI_ID= $CLI_ID ;
            $client->NOM = request('NOM');
            $client->RUE = request('RUE');
            $client->VIL = request('VIL');
            $client->CPOSTAL = request('CPOSTAL');
            $client->PAY = request('PAY');
            $client->TEL = request('TEL');
            $client->FAX = request('FAX');
            $client->WEB = request('WEB');
            $client->EMAIL = request('EMAIL');
            $client->TIERS = request('TIERS');
            $client->FEU = request('FEU');
            
            $client->save();
            
            DB::unprepared('SET IDENTITY_INSERT CLI OFF');
            return response($client);
            
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function GetByTiers($id)
    {
        $client = DB::select("select 
        TPFT, 
        REFAM,
        NOM,
        RUE,
        VIL,
        CPOSTAL,
        PAY,
        TEL,
        FAX,
        WEB,
        EMAIL,
        TIERS,
        FEU,
        TACOD,
        REFAMX,
        U_TIMBRE, 
        REM_0001, REM_0002, REM_0003,
        REMTYP_0001, REMTYP_0002, REMTYP_0003,
        PREM_0001, PREM_0002, PREM_0003, PREMTYP_0001, PREMTYP_0002, PREMTYP_0003,  REMCOD 
        from CLI where TIERS='".$id."' AND DOS=1");
        return response($client);
    
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateClient(Request $request)
    {        CLI::where('CLI_ID',$request->CLI_ID)->where('DOS',1)->update([
            'NOM'=>request('NOM'),
            'RUE'=>request('RUE'),
            'VIL'=>request('VIL'),
            'CPOSTAL'=>request('CPOSTAL'),
            'TEL'=>request('TEL'),
            'FAX'=>request('FAX'),
            'WEB'=>request('WEB'),
            'EMAIL'=>request('EMAIL'),
            'TIERS'=>request('TIERS'),
            'PAY' =>request('PAY'),
            'FEU' =>request('FEU'),
           
        ]);
        return  CLI::where('CLI_ID',$request->CLI_ID)->first();}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteClient(Request $request,$id)
    {
        $cLI= CLI::where('CLI_ID',$id)->where('DOS',1);
        $cLI->delete();
        return response(CLI::get(["CLI_ID",
        "NOM",
        "RUE",
        "VIL",
        "CPOSTAL",
        "PAY",
        "TEL",
        "FAX",
        "WEB",
        "EMAIL",
        "TIERS",
        "FEU",
        ]));
    }


        /**
     * Show the form for creating a new resource.
     *
     * @param  string  $commercial
     */
    public function findClientOfComm($commercial)
    {
        $client= CLI::where('REPR_0001',$commercial)->where('DOS',1)->get([
            'CLI_ID',
            'NOM',
            'RUE',
            'VIL',
            'CPOSTAL',
            'PAY',
            'TEL',
            'FAX',
            'WEB',
            'EMAIL',
            'TIERS',
            'FEU',
            'TACOD',
            'TPFT'
         
        ]);
        return response($client);    
    }

    public function getRemise(Request $REF, $cli , $REMCOD){ 
        $remise=DB::select("SELECT  DOS, REF, SREF1, SREF2, REMCOD, TIERS, REMDT, QTE, REM_0001, REM_0002,REM_0003, REMTYP_0001, REMTYP_0002, REMTYP_0003, HSDT, ETB
        FROM     TRE
        WHERE  (REMDT <= GETDATE() OR
                          REMDT IS NULL) AND (HSDT >= GETDATE() OR
                          HSDT IS NULL) AND (DOS = 1) AND (TIERS = '".$cli."') AND (REF = '".$REF->ref."' OR
                           REF ='                         ') AND REMCOD='99'");        
        if($remise) return response($remise) ;
        else {
            $remise=DB::select("SELECT  DOS, REF, SREF1, SREF2, REMCOD, TIERS, REMDT, QTE, REM_0001, REM_0002,REM_0003, REMTYP_0001, REMTYP_0002, REMTYP_0003, HSDT, ETB
            FROM     TRE
            WHERE  (REMDT <= GETDATE() OR
                              REMDT IS NULL) AND (HSDT >= GETDATE() OR
                              HSDT IS NULL) AND (DOS = 1) AND (REMCOD = '".$REMCOD."')");
            if( $remise == []) return NULL ;           
            else  return response($remise) ;
        }       
    }
   
}
