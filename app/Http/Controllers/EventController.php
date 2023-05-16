<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
class EventController extends Controller
{    
    public function AddEvent(Request $request)
    { 
         $event= new Events(); 
         $event->date_fin = request('date_fin'); 
         $event->date_deb =request('date_deb');   
         $event->description = request('description');
         $event->lien = request('lien');
         $event->type = request('type');
         $event->client_id = request('client_id');
         $event->representant_id = request('representant_id');
         $event->USIM_PLAST = request('USIM_PLAST');     
       
         $event->save();
         return response($event);
    }


    public function getEvents()
    {
        $events= Events::get([
            'id',
            'date_fin',
            'date_deb',
            'description',
            'lien',
            'type',
            'client_id',
            'representant_id',
            'USIM_PLAST',
         
        ]);
        return response($events);
    
    }
    

    public function updateEvent(Request $request)
    {  
        Events::where('id',request('id'))->update([              
           'date_fin' => request('datefin'),
           'date_deb' => request('datedeb'),
           'description' => request('description'),
           'lien' => request('lien'),
           'type' => request('type'),     
           'client_id' => request('client_id'),     
           'representant_id' => request('representant_id'),     
           'USIM_PLAST' => request('USIM_PLAST'),     
           ]);
       return  Events::where('id',request('id'))->first();


    }

    public function deleteEvent($cli){
   
        $Event= Events::where('id',$cli); 
        $Event->delete();
    
        return response(Events::select(       
            'id',
            'date_fin',
            'date_deb',
            'description',
            'lien',
            'type',
            'client_id',
            'representant_id',
            'USIM_PLAST',
        )->get());
    }
}
