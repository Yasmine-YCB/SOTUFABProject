<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VRP;
use App\Models\Vice;
use Illuminate\Support\Facades\DB;
class VRPController extends Controller
{
     // getAll
    // getRepByID
    // Remplacer
    // IgnoreRemplacant
    public function DeletRemplacant($id){     

            $vice= Vice::where('rep_id',$id);
            $vice->delete();
            return response(Vice::get([
                'id',
                'rep_id',
                'vice_id',
            ]));
        }
     

    public function GetAll(){

        return  VRP::get([
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
        
        ]);
    }
 

public function RepresentantById($id) {
    $rep= VRP::where('TIERS',$id)->first([
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
     
    ]);
    return response($rep);



}
 


  /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateVRP(Request $request, $id)
    {        VRP::where('VRP_ID',$id)->update([
            'NOM'=>request('NOM'),
            'RUE'=>request('RUE'),
            'VIL'=>request('VIL'),
            'CPOSTAL'=>request('CPOSTAL'),
            'TEL'=>request('TEL'),
            'FAX'=>request('FAX'),
            'WEB'=>request('WEB'),
            'EMAIL'=>request('EMAIL'),
            'TIERS'=>request('TIERS'),
            'PAY' =>request('PAY')
        ]);
        return  VRP::where('VRP_ID',$id)->first();}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteVRP(Request $request,$id)
    {
        $cLI= CLI::where('VRP_ID',$id);
        $cLI->delete();
        return response(CLI::get(["VRP_ID",
        "NOM",
        "RUE",
        "VIL",
        "CPOSTAL",
        "PAY",
        "TEL",
        "FAX",
        "WEB",
        "EMAIL",
        "TIERS"
        ]));
    }


}



// public function search($request )
// {
//     $client= VRP::where('TIERS',$request->TIERS)
//     ->where('NOM',$request->NOM)
//     ->where('EMAIL',$request->EMAIL)
//     ->where('TEL',$request->TEL)->first([
//         'NOM',
//         'RUE',
//         'VIL',
//         'CPOSTAL',
//         'PAY',
//         'TEL',
//         'FAX',
//         'WEB',
//         'EMAIL',
//         'TIERS',         
//     ]);
//     if($client){

//         return response($client);
//     }
//     else{
//         return null;
//     }

// }


// /**
//  * Store a newly created resource in storage.
//  *
//  * @param  \Illuminate\Http\Request  $request
//  * @return \Illuminate\Http\Response
//  */
// public function AddVRP(Request $request)

// { 
//     $serach= $this->search($request );
//     if($serach != null){ return 'Commercial déja existe'; }
//     else{
//         $lastID= VRP::orderby('VRP_ID', 'desc')->first();
//         $VRP_ID = $lastID->VRP_ID + 1;
//         DB::unprepared('SET IDENTITY_INSERT CLI ON');
//         $VRP= new VRP(); 
//         $VRP->VRP_ID= $VRP_ID ;
//         $VRP->NOM = request('NOM');
//         $VRP->RUE = request('RUE');
//         $VRP->VIL = request('VIL');
//         $VRP->CPOSTAL = request('CPOSTAL');
//         $VRP->PAY = request('PAY');
//         $VRP->TEL = request('TEL');
//         $VRP->FAX = request('FAX');
//         $VRP->WEB = request('WEB');
//         $VRP->EMAIL = request('EMAIL');
//         $VRP->TIERS = request('TIERS');
//         $VRP->save();
//         DB::unprepared('SET IDENTITY_INSERT CLI OFF');
     
//         return response($VRP);
//     }
   
// }    