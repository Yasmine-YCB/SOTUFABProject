<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MVTLController extends Controller
{
    public function Add(Request $request)
    { 
       
        DB::unprepared('SET IDENTITY_INSERT ART ON');
        $Article= new MVTL();
       
        $Article->DOS = request('DOS');
        $Article->DES = request('DES');
        $Article->REF = request('REF');       
        $Article->save();
        DB::unprepared('SET IDENTITY_INSERT ART OFF');
        return response($Article);
    }

    public function AddMVTL(Request $request)
    { 
       
        DB::unprepared('SET IDENTITY_INSERT MVTL ON');
        $MVTL= new MVTL();       
        $MVTL->REF = request('REF');
        $MVTL->TIERS = request('TIERS');
        $MVTL->USERCR = request('USERCR');       
        $MVTL->USERMO =NULL;       
        $MVTL->ENRNO = request('ENRNO');       
        $MVTL->DELDEMDT = request('DELDEMDT');       
        $MVTL->VTLNO = request('VTLNO');       
        $MVTL->CDVTLNO = request('CDVTLNO');       
        $MVTL->PINO = request('PINO');       
        $MVTL->QTE = request('QTE');       
        $MVTL->REFQTE = request('REFQTE');       
        $MVTL->save();

        DB::unprepared('SET IDENTITY_INSERT MVTL OFF');
        return response($MVTL);
    }
}
