<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\commande;

class CommandeController extends Controller
{
    // getAll
    // GetById
    // getByRep
  /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     * 
     */
    public function GetCommandeIntegrer()
    {
        $commandes= commande::where('statut','integré')->get([
            'id',
            'add_ref',
            'codetva_cin',
            'date_livr',    
            'ct_num',    
            'created_at',    
            'intutile',    
            'msg',    
            'num_sage',    
            'ref',    
            'reste',    
            'statut',    
            'tel_ref',    
            'totale',    
            'client_user_id',    
            'representant_user_id',    
            'num_cmd_clt',    
            'commune',    
            'tel_ref',      
            
         
        ]);
        return response($commandes);
    
    }
    public function GetCommandeValider()
    {
        $commandes= commande::where('statut','confirmé')->get([
            'id',
            'add_ref',
            'codetva_cin',
            'date_livr',    
            'ct_num',    
            'created_at',    
            'intutile',    
            'msg',    
            'num_sage',    
            'ref',    
            'reste',    
            'statut',    
            'tel_ref',    
            'totale',    
            'client_user_id',    
            'representant_user_id',    
            'num_cmd_clt',    
            'commune',    
            'tel_ref',      
            
         
        ]);
        return response($commandes);
    
    }
    
     
    
    // getCommandeValider =>status = confirme
    // getCommandeInteger =>status = integrer
    // getCommandeNonVerifier : /clt =>status = saisie
    // getCommandeNonVerifierByRep : /rep =>status = saisie
    //getLignedeCmdByCmd: /cmd
    // AddCmmd: add commande + add ligne de commande + calcule prix totale + setIsCommande true  
    //delete commande
    // delete ligne de commande
    // updateCommande
    // valider => update the status to confirmé
    // Integrer => update the status to Integrer


    //getPrefix



}
