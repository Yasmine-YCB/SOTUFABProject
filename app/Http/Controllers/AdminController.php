<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Date;

class AdminController extends Controller
{

    public function getUser(){
        return User::select('users.id',  'users.enabled','users.first_Name', 'users.gsm',  'users.last_Name',  
        'users.password',  'users.username', 'users.authorities_id','users.ETB','users.DOS',
        'authority.name as authority_name',    'users.PER_id','users.EMAIL', 'users.SMS',
        'users.CLI_id')
        ->join('authority', 'authority.id', '=', 'users.authorities_id')->get()  ;
    }
 
    public function log(Request $request)
     {              
        $user = User::select('users.id',  'users.enabled','users.first_Name', 'users.gsm',  'users.last_Name',  
        'users.password',  'users.username', 'users.PER_id','users.ETB','users.DOS','users.EMAIL', 'users.SMS',
        'users.CLI_id','users.authorities_id' ,'users.EMAIL', 'users.SMS',
        'authority.name as authority_name')
        ->join('authority', 'authority.id', '=', 'users.authorities_id') 
        ->where('users.username', $request->username)
        ->where('users.password', $request->password)
        ->first();        
        if($user){
            if($user->password === $request->password) return $user;
            else return "Verifier votre mot de passe !!";
          
         }else{
            return "Non authoriser";
        }
     } 
 
    
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function AddUser(Request $request)     
     { 
   
         $serach= $this->search($request );
         
         if($serach != null){
             return 'Utilisateur déja existe';
         }
         else{
            
             DB::unprepared('SET IDENTITY_INSERT CLI ON');
             $client= new User();  
             $client->first_Name = request('first_Name');
             $client->last_Name = request('last_Name');
             $client->username = request('username'); 
             $client->password = request('password');
             $client->gsm = request('gsm');
             $client->enabled =true;
             $client->PER_id = request('PER_id');
             $client->CLI_id = request('CLI_id'); 
             $client->DOS = request('DOS'); 
             $client->ETB = request('ETB');            
             $client->SMS = request('SMS');            
             $client->EMAIL = request('EMAIL');            
             $client->authorities_id = request('authorities_id');    
            //  $client->created_at= strval(new Date()) ;   
            //  strval(strtotime(date_create()))  ;      
             $client->save();
             DB::unprepared('SET IDENTITY_INSERT CLI OFF');
          
             return response($client);
         }       
     } 

    public function search($request )
    {
        $user= User::where('PER_id',$request->PER_id) 
        ->where('first_Name',$request->first_Name)
        ->where('last_Name',$request->last_Name) 
        ->where('gsm',$request->gsm)
        ->where('username',$request->username)->first([
            'id',
            'first_Name',
            'last_Name',
            'username',  
            'password',
            'gsm', 
            'enabled',
            'PER_id',
            'CLI_id',
            'authorities_id'
         
        ]);

        if($user)  return response($user);
        else return null;
    
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }
    
      /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int $id
      * @return \Illuminate\Http\Response
      */
      public function ActiveUser(Request $request)
      { 
 
        if($request->enabled){
            User::where('id',$request->id)->update([              
                'enabled' => FALSE,                       
                ]);
        }
        else{
            User::where('id',$request->id)->update([              
                'enabled' => TRUE,                       
                ]);
        }        
          return  User::where('id',$request->id)->first();
      }

           /**
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int $id
      * @return \Illuminate\Http\Response
      */
     public function updateUser(Request $request)
     {        
        if( $request->password != null){
            User::where('id',request('id'))->update([ 
                   'password'=>request('password'),  
                   'username'=>request('username'),  
                   'gsm'=>request('gsm'),  
                   'SMS'=>request('SMS'),  
                   'EMAIL'=>request('EMAIL'),  

               ]); 
            }   
        else{
            User::where('id',request('id'))->update([    
                 'gsm'=>request('gsm'), 
                'username'=>request('username'),                  
                'gsm'=>request('gsm'), 
                'SMS'=>request('SMS'),  
                'EMAIL'=>request('EMAIL'),   

            ]); 
        }      
        return  User::where('id',request('id'))->first();
     }

          
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function delete(Request $request,$id)
      {
          $user= User::where('id',$id);
          $user->delete();
          return response(User::get(["id",
          'id',
            'first_Name',
            'last_Name',
            'username',  
            'password',
            'gsm', 
            'enabled',
            'PER_id',
            'CLI_id',
            'authorities_id'
          ]));
      }

      public function gettt(){

        $tt=  DB::connection('sqlsrv')->table('ART')->select("REF")->get();
      }
      public function getETB(){

       return  DB::select(" select  DOS, ETB, NOM from ETS ");
      }
      public function getSOC(){

        return  DB::select("select DOS, NOM from SOC");
       }
    
     
}
