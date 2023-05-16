<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CLIController;
use App\Http\Controllers\ARTController;
use App\Http\Controllers\ENTController;
use App\Http\Controllers\MOUVController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VRPController;
use App\Http\Controllers\representantController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\WebEntController;
use App\Http\Controllers\WebMouvController;
use App\Http\Controllers\ARTicleController;
use App\Http\Controllers\reglementController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;


use App\Mail\ContactFormMail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('login', [AdminController::class, 'log']);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//config
Route::get('config',  [ConfigController::class, 'getAll']);
Route::patch('config',  [ConfigController::class, 'updatePrefix']);
Route::post('config',  [ConfigController::class, 'AddPrefix']);
Route::get('pref', [ConfigController::class, 'getpref']); 
Route::get('pref/{id}', [ConfigController::class, 'getprefByID']); 




////////events 
Route::post('event',  [EventController::class, 'AddEvent']);
Route::get('event',  [EventController::class, 'getEvents']);
Route::delete('event/{id}',  [EventController::class, 'deleteEvent']);
Route::patch('event',  [EventController::class, 'updateEvent']);



// login
Route::post('login', [AdminController::class, 'log']);
Route::get('get', [AdminController::class, 'gettt']);
Route::get('ETB', [AdminController::class, 'getETB']); 
Route::get('SOC', [AdminController::class, 'getSOC']); 



//client
Route::get('client',  [CLIController::class, 'GetAll']);
Route::get('client/{id}',  [CLIController::class, 'GetByTiers']);

Route::post('client',  [CLIController::class, 'AddClient']);
Route::patch('client',  [CLIController::class, 'UpdateClient']);
Route::delete('client/{id}',  [CLIController::class, 'DeleteClient']);
Route::get('clientByRep/{REP}',  [CLIController::class, 'getClientsByRep']);

Route::post('remise/{clt}/{REMCOD}',  [CLIController::class, 'getRemise']);

//VRP
Route::get('VRP',  [VRPController::class, 'GetAll']);
Route::get('VRP',  [VRPController::class, 'GetAll']);
Route::get('RepresentantById/{id}',  [VRPController::class, 'RepresentantById']);

// Route::post('VRP',  [VRPController::class, 'AddVRP']);
Route::patch('VRP',  [VRPController::class, 'UpdateVRP']);
Route::delete('VRP/{id}',  [VRPController::class, 'DeleteVRP']);

//Admin Controller 
Route::get('user',  [AdminController::class, 'getUser']);
Route::post('user',  [AdminController::class, 'AddUser']);
Route::patch('user',  [AdminController::class, 'updateUser']);
Route::delete('user/{id}',  [AdminController::class, 'delete']);
Route::post('user/Activate',  [AdminController::class, 'ActiveUser']);

///article fini
Route::post('findClientOfComm/{tiers}',  [ARTicleController::class, 'findClientOfComm']);
Route::post('articleF',  [ARTController::class, 'getArtPF']);
Route::post('articleByFamClient/{cli}',  [ARTController::class, 'GetByFamCli']);
Route::post('articleByClient/{cli}',  [ARTController::class, 'GetByCli']);
Route::post('articleByFam',  [ARTController::class, 'GetByFam']);
Route::get('Famille/{dos}',  [ARTController::class, 'GetFamille']);

 
Route::post('getArtByRef',  [ARTController::class, 'articleByRef']);

Route::post('articleByRef/{cli}',  [ARTController::class, 'getByRef']);
// Route::post('articleonlyByRef',  [ARTController::class, 'getOnlyByRef']);
Route::post('depo',  [ARTController::class, 'GetDepo']);
Route::post('articleonlyByRef',  [ARTController::class, 'getOnlyByRef']);
 


Route::post('stock/{fam}',  [ARTController::class, 'GetByFamStock']);
// Route::post('article',  [ARTController::class, 'Add']);
// Route::patch('article/{artId}',  [ARTController::class, 'update']);
// Route::delete('article/{artId}',  [ARTController::class, 'delete']);

Route::get('TypeFam',  [ARTController::class, 'GetTypeFamille']);

//notification
Route::get('/Notification',  [NotificationController::class, 'getAllnotification']);
Route::get('/NotificationByRep/{rep}',  [NotificationController::class, 'getRepNotif']);
Route::post('/Notification',  [NotificationController::class, 'AddNotif']);
Route::get('Notification/getbyRep/{nom}/{id}',  [NotificationController::class, 'findByRep']);
// Route::delete('delete/{id}',  [NotificationController::class, 'delete']);
Route::get('/Notification/getbyname/{nom}',  [NotificationController::class, 'GetByName']);
Route::get('/Notification/getbyname12',  [NotificationController::class, 'GetByName12']);
// mouv
Route::get('mouvByENT/{entId}/{type}',  [MOUVController::class, 'GetByENT']);
Route::get('mouvByPino/{entId}',  [MOUVController::class, 'GetByPINO']);
Route::get('mouv/{MOUVId}',  [MOUVController::class, 'GetById']);
Route::post('mouv',  [MOUVController::class, 'Add']);
// Route::delete('mouv/{id}',  [MOUVController::class, 'delete']);
Route::delete('delete/{id}',  [MOUVController::class, 'tt']);

// ent
 
Route::patch('updateEnt',  [ENTController::class, 'updateEnt']);


Route::get('Facture/{id}',  [ENTController::class, 'getFacture']);
Route::get('BL/{id}',  [ENTController::class, 'getBL']);
Route::get('CLIFacture/{cli}',  [ENTController::class, 'getCLIFacture']);
Route::get('Facture/{id}/{cli}',  [ENTController::class, 'getFactureByCli']);
Route::get('BL/{id}/{cli}',  [ENTController::class, 'getBLByCli']);

Route::get('ent',  [ENTController::class, 'getCommd']);
Route::get('ent/{id}',  [ENTController::class, 'getById']);
Route::post('ent',  [ENTController::class, 'Add']);
Route::get('entByRep/{tiers}',  [ENTController::class, 'getcommandesByRep']);
Route::get('entByRepStatus/{tiers}/{status}',  [ENTController::class, 'getcommandesByRepState']);
Route::get('entByCliRepStatus/{tiers}/{status}/{cli}',  [ENTController::class, 'getcommandesByCliRepState']);


Route::get('entByCli/{clt}/{vrp}',  [ENTController::class, 'getCommdByClient']);


Route::get('adresse',  [ENTController::class, 'getAdress']);

// Route::get('entVerif',  [ENTController::class, 'getCommandesVerifie']);
// Route::get('entNotVerif/{tiers}',  [ENTController::class, 'getCommandesNonVerifie']);
// Route::get('entNotVerifByClt/{clt}',  [ENTController::class, 'getCommandesNonVerifieByclient']);
// Route::patch('updateEnt',  [ENTController::class, ' UpdateWebEnt']);


//panier
Route::get('panier',  [PanierController::class, 'getAll']);
Route::get('panier/{tiers}',  [PanierController::class, 'getByCLI']);
Route::post('panier',  [PanierController::class, 'Add']);
Route::delete('panier/{tiers}',  [PanierController::class, 'delete']);
Route::post('deleteAll',  [PanierController::class, 'deleteAll']);
Route::delete('deleteByID/{tiers}',  [PanierController::class, 'deleteByID']);




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('CliENT/{id}',  [WebEntController::class, 'getCliCommande']);
Route::get('Webent/{id}',  [WebEntController::class, 'getById']);
Route::post('AddEnt',  [WebEntController::class, 'Add']);
Route::delete('ent/{id}',  [WebEntController::class, 'Delete']);
Route::get('webentByCli/{clt}/{vrp}',  [WebEntController::class, 'getWebCommdByClient']);
Route::patch('VAlidate/{id}',  [WebEntController::class, 'VAlidateENT']);




Route::post('AddMouvv',  [WebMouvController::class, 'AddTable']);
Route::post('AddMouv',  [WebMouvController::class, 'Add']);
Route::get('WebMouv/{id}',  [WebMouvController::class, 'GetWebByENT']);
Route::patch('WebMouv',  [WebMouvController::class, 'update']);
Route::delete('WebMouv/{id}',  [WebMouvController::class, 'Delete']);
Route::patch('mouvqte',  [WebMouvController::class, 'updateMouvQte']);

//reglement
Route::get('facture/{id}',  [reglementController::class, 'getFactureNonPayee']);
Route::get('accompte/{id}',  [reglementController::class, 'accompte']);
 
// Route::post('send-email', [EmailController::class, 'sendEmail']); 

Route::post('email', [EmailController::class, 'sendEmail']); 


 














// Route::middleware('auth:api')->group(function () {
//     Route::post('/tokens/create', function (Request $request) {
//             $token = $request->user()->createToken($request->token_name);
         
//             return ['token' => $token->plainTextToken];
//         });


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
