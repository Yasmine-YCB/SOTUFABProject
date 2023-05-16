<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CLI; 

class ARTicleController extends Controller
{
    public function findClientOfComm(Request $request,$commercial)
    {
        $client= CLI::where('TIERS',$commercial)->where('DOS',1)->select([
            'TACOD',  'TIERS'      
        ])->first(); 
 
        $Article= DB::connection('sqlsrv')->table('ART')
        ->where('DOS',1)
        ->where('PRODNAT','2PF')
        ->where('REF',$request->ref)
        ->get([
            'DOS',
            'DES',
            'REF',
            'FAM_0001',
            'PRODNAT',
            'LGTYP',
            'QTE',
            'USIM_PRIX_BASE',
            'SREF1',
            'SREF2',
            'MEDIA',
            'TVAART' 
        ])->first();
             
           if($client){         
            $tt=  DB::select("SELECT ART.ART_ID, ART.REF, ART.DES, ART.TIERS, ART.FAM_0001, ART.REFAMRX, ART.REFAMR, ISNULL(TAR.PUB, ART.USIM_PRIX_BASE) AS USIM_PRIX_BASE, ART.FAM_0002, ART.FAM_0003, ART.PRODNAT, ART.MEDIA, ART.TVAART, 
            ART.SREF1, ART.SREF2, ART.PREFDVNO, ART.DVNO, ART.QTE, ART.LGTYP
            FROM     TAR RIGHT OUTER JOIN
            ART ON TAR.REF = ART.REF
            WHERE  (ART.DOS = '1') AND (ART.PRODNAT = '2PF') AND ( ART.REF='".$Article->REF."') 
            AND (TAR.TACOD = '".$client->TACOD."')
            ORDER BY ART.ART_ID");
        return response($tt);}
        else return null;
    
    }
}
