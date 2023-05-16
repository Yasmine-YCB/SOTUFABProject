<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\notification;
class NotificationController extends Controller
{


/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *  
     */
   
     public function getAllnotification()
     {                
        return DB::connection('sqlsrv1')->table('notification')->select( 
            'id',
            'description',  
            'nom',
            'client_user_id',
            'representant_user_id',
            'user_id',
            'srce',
            'clients',
            'representants',
            'remise',
            'datedeb',
            'datefin')->get(); 
  
     } 
 
         /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      * Notification/save
      */
     public function AddNotif(Request $request)
     { 
        
         $notification= new notification(); 
         $notification->description = request('description');
         $notification->nom = request('nom');
         $notification->client_user_id = request('client_user_id');
         $notification->representant_user_id = request('representant_user_id');
         $notification->user_id = request('user_id');
         $notification->srce = request('srce');
         $notification->clients = request('clients');
         $notification->representants = request('representants');
         $notification->remise = request('remise');
         $notification->save(); 
         return response($notification);

     }
 
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      * Notification/getbyid/{id}
      */
     public function GetById($id)
     {
         $notification= notification::where('id',$id)->first([
            'id',
            'description',  
            'nom',
            'client_user_id',
            'representant_user_id',
            'user_id',
            'srce',
            'clients',
            'representants',
            'remise',
            'datedeb',
            'datefin' 
          
         ]);
         return response($notification);
     
     }

     public function getCltEvents(){
        $notification= notification::where('clients',1)->get([
            'id',
            'description',  
            'nom',
            'client_user_id',
            'representant_user_id',
            'user_id',
            'srce',
            'clients',
            'representants',
            'remise',
            'datedeb',
            'datefin' 
          
         ]);
         return response($notification);
     
     }

     public function getRepNotif($rep){
        $notification= notification::where('representants',$rep)->get([
            'id',
            'description',  
            'nom',
            'client_user_id',
            'representant_user_id',
            'user_id',
            'srce',
            'clients',
            'representants',
            'remise',
            'datedeb',
            'datefin' 
         ]);
         return response($notification);
     
     }

     
      
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      * Notification/getbyname/{nom}
      */
      public function GetByName($nom)
      {
          $notification= notification::where('nom',$nom)->first([
             'id',
             'description',  
             'nom',
             'client_user_id',
             'representant_user_id',
             'user_id',
             'srce',
             'clients',
             'representants',
             'remise',
             'datedeb',
             'datefin' 
           
          ]);
          return response($notification);
      
      }


      public function GetByName12()
      {
          $notification= notification::where('nom','1')->where('nom','2')->select([
             'id',
             'description',  
             'nom',
             'client_user_id',
             'representant_user_id',
             'user_id',
             'srce',
             'clients',
             'representants',
             'remise',
             'datedeb',
             'datefin' 
           
          ])->get();
          return response($notification);
      }
         /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      * Notification/getevntbyRep/{rep}/{nom}
      */
      public function findByRep($rep,$nom)
      {
          $notification= notification::where('nom',$nom)->where('representant_user_id',$rep)->first([
             'id',
             'description',  
             'nom',
             'client_user_id',
             'representant_user_id',
             'user_id',
             'srce',
             'clients',
             'representants',
             'remise',
             'datedeb',
             'datefin' 
           
          ]);
          return response($notification);
      
      }


        /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      * Notification/getevntbyRep/{rep}/{nom}
      */
      public function findBNotifByClt($nom,$clt)
      {
          $notification= notification::where('nom',$nom)->where('client_user_id',$clt)->first([
             'id',
             'description',  
             'nom',
             'client_user_id',
             'representant_user_id',
             'user_id',
             'srce',
             'clients',
             'representants',
             'remise',
             'datedeb',
             'datefin' 
           
          ]);
          return response($notification);
      
      }
 
      
      
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * /Notification/Modifier
     */
    public function update(Request $request)
    {        notification::where('id',request('id'))->update([ 
              
       
            'description'=>request('description'), 
            'nom'=>request('nom'),
            'client_user_id'=>request('client_user_id'),
            'representant_user_id'=>request('representant_user_id'),
            'user_id'=>request('user_id'),
            'srce'=>request('srce'),
            'clients'=>request('clients'),
            'representants'=>request('representants'),
            'remise'=>request('remise'),
            'datedeb'=>request('datedeb'),
            'datefin'=>request('datefin'), 
        ]);
        return  notification::where('id',request('id'))->first();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *  Notification/delete/{id}
     */
    public function delete(Request $request,$id)
    {
        $notification= notification::where('id',$id);
        $notification->delete();
        return response(notification::get(["id",
        'id',
        'description',  
        'nom',
        'client_user_id',
        'representant_user_id',
        'user_id',
        'srce',
        'clients',
        'representants',
        'remise',
        'datedeb',
        'datefin'  
        ]));
    }

  
}
