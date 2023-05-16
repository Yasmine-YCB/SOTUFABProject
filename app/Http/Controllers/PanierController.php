<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panier;
use Illuminate\Support\Facades\DB;



class PanierController extends Controller
{
    public function getAll(){
        return Panier::get(
            'id'   ,
            'CLI',  
            'REPR',
            'MEDIA',
            'DES',
            'ARTREF',
            'QTE',
            'TACOD',
            'PRIX' ,
            'LGTYP'
        );
    }   
 
    public function Add(Request $request)    
    {    
        {                
            $panier= new Panier();   
            $panier->CLI = $request->CLI;
            $panier->REPR = $request->REPR;
            $panier->MEDIA = $request->MEDIA;
            $panier->DES = $request->DES;
            $panier->ARTREF = $request->ARTREF;
            $panier->QTE = $request->QTE;
            $panier->TACOD = $request->TACOD;
            $panier->PRIX = $request->PRIX;  
            $panier->LGTYP = $request->LGTYP;   
            
            
            $panier->save();    
            return response($panier);           
    }
}
public function getByCLI($cli){
    return Panier::where('CLI', $cli)->select(    
        'id'   ,
        'CLI',  
        'REPR',
        'MEDIA',
        'DES',
        'ARTREF',
        'QTE',
        'TACOD',
        'PRIX' ,
        'LGTYP'
    )->get();
}
public function delete($cli){
   
    $panier= Panier::where('CLI',$cli)->get();
 
    foreach ($panier as $key => $value) {
        # code...
        $panier[$key]->delete();
        echo 'deleted';
    }
    return response(Panier::select(       
        'CLI',  
        'REPR',
        'MEDIA',
        'DES',
        'ARTREF',
        'QTE',
        'TACOD',
        'PRIX' ,
        'LGTYP'
    )->get());
}
public function deleteByID($cli){
   
    $panier= Panier::where('id',$cli); 
    $panier->delete();

    return response(Panier::select(       
        'CLI',  
        'REPR',
        'MEDIA',
        'DES',
        'ARTREF',
        'QTE',
        'TACOD',
        'PRIX' ,
        'LGTYP'
    )->get());
}

public function deleteAll(Request $Request){ 
    foreach ($Request->input('objects') as $key => $value) {  
       Panier::where('id',$value['id'])->delete(); 
       }    
    return response(Panier::select(       
        'CLI',  
        'REPR',
        'MEDIA',
        'DES',
        'ARTREF',
        'QTE',
        'TACOD',
        'PRIX' ,
        'LGTYP'
            )->get());
}

}