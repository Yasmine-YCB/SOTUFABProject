<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MVTL extends Model
{
    use HasFactory;
    protected $table='MVTL';
    public  $timestamps = false;
    protected $connection = 'sqlsrv';
    protected $fillable= [
        'REF', 
        'TIERS' , 
        'USERCR',
        'USERMO', 
        'ENRNO', 
        'DELDEMDT',//delai de livraison demandé     
        'VTLNO', //increment the last one 
        'CDVTLNO',//the same number as VTLNO
        'PINO', // pino from ENT
        'QTE', // CDQTE in MOUV
        'REFQTE',// REFQTE in MOUV 
    ];
    protected $hidden = [
        'CE1',
           'CE2',
           'CE3' ,
           'CE4',
           'CE5',
           'CE6',
           'CE7',
           'CE8',
           'CE9',
           'CEA',
           'DOS',            
           'SREF1', 
           'SREF2', 
           'TICOD',          
           'OP',         
           'ETB', 
           'DEPO', 
           'LIEU',
           'COLINO', 
           'SERIE',
           'NST', 
           'STDTSQL', 
           'PREFPINO', 
           'BLASLIEU',
           'MANUTCOD', 
           'SERIEFOU',
           'TIERSSTOCK',
           'SENS',  
           'PICOD',            
           'LILG', 
           'TICKETRES',            
           'VTLNA', 
           'BLASVTLNO', 
           'CR', 
           'CNCR', 
           'CMP', 
           'CRGAM',         
           'STQTE' , 
           'RESQTE' , 
           'STRES', 
           'STATUS', 
           'OFRESCOD', 
           'PREVFLG', 
           'BPDETNO', 
           'TICKETMRESS', 
           'RCONO', 
           'BLDT',
           'DELDT',          
           'DELREPDT',
           'PEREMPDT',
           'USERCRDH', 
           'USERMODH'
    ];
    protected $attributes = [
        'DELACCDT'=>NULL,  //delai de livraison accepté
            'CE1'=>'V',
           'CE2',
           'CE3'=>'1',
           'CE4'=>'1',
           'CE5',
           'CE6',
           'CE7',
           'CE8',
           'CE9',
           'CEA',
           'DOS'=>'1',            
           'SREF1'=>'        ', 
           'SREF2'=>'        ', 
           'TICOD'=>'C',          
           'OP'=>'C',         
           'ETB'=>'1', 
           'DEPO'=>'2', 
           'LIEU'=>'                    ',
           'COLINO'=>'         ', 
           'SERIE'=>'                              ',
           'NST'=>'N ', 
           'STDTSQL'=>'        ', 
           'PREFPINO'=>'BCVM      ', 
           'BLASLIEU'=>'                    ',
           'MANUTCOD'=>'        ', 
           'SERIEFOU'=>'                              ',
           'TIERSSTOCK'=>'                    ',
           'SENS'=>2,   
           'PICOD'=>2,            
           'LILG'=>1, 
           'TICKETRES'=>0,            
           'VTLNA'=>0, 
           'BLASVTLNO'=>0, 
           'CR'=>0.000000, 
           'CNCR'=>0, 
           'CMP'=>0.000000, 
           'CRGAM'=>0.000000,  
           'STQTE'=>0.000, 
           'RESQTE'=>0.000, 
           'STRES'=>1, 
           'STATUS'=>0, 
           'OFRESCOD'=>1, 
           'PREVFLG'=>1, 
           'BPDETNO'=>0, 
           'TICKETMRESS'=>0, 
           'RCONO'=>0, 
           'BLDT'=>NULL,
           'DELDT'=>NULL,          
           'DELREPDT'=>NULL,
           'PEREMPDT'=>NULL,
           'USERCRDH'=>NULL, 
           'USERMODH'=>NULL
           ];
        }
        