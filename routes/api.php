<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\GameController;
use Laravel\Passport\Http\Middleware\CheckTokenForAnyScope;

use App\Http\Middleware\ApiForceAcceptHeader;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

/*
//Endpoint listado de players
Route::get('/players', [PlayerController::class, 'index'])->middleware([ApiForceAcceptHeader::class]);
//Endpoint busqueda de player con id
Route::get('/players/{id}', [PlayerController::class, 'show'])->middleware([ApiForceAcceptHeader::class]);
//Endpoint busqueda de player con first_name
Route::get('/players/first_name/{first_name}', [PlayerController::class, 'showByFirstName'])->middleware([ApiForceAcceptHeader::class]);
Route::get('/players/{id}', [PlayerController::class, 'show'])->middleware([ApiForceAcceptHeader::class]);
//Endpoint insertar nuevo player
Route::post('/players', [PlayerController::class, 'store'])->middleware([ApiForceAcceptHeader::class]);
*/

Route::middleware([ApiForceAcceptHeader::class])->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware([ApiForceAcceptHeader::class, 'auth:api','scope:user:read'])->group(function () {

    //User medical record
    Route::get('/users/{id}/medicalrecord', [MedicalRecordController::class, 'show_user_medical_record']);

    //Endpoint listado de players
    Route::get('/players', [PlayerController::class, 'index']);
    //Endpoint busqueda de player con id
    Route::get('/players/{id}', [PlayerController::class, 'show']);
    Route::get('/players/{id}/medicalrecord', [PlayerController::class, 'show_medical_record']);
    //Endpoint busqueda de player con first_name
    Route::get('/players/first_name/{first_name}', [PlayerController::class, 'showByFirstName']);
    Route::get('/players/{id}', [PlayerController::class, 'show']);
    //Endpoint insertar nuevo player
    Route::post('/players', [PlayerController::class, 'store']);
    //Endpoint actualizar un nuevo player
    Route::put('/players/{id}', [PlayerController::class, 'update']);
    //Endpoint delete player
    Route::delete('/players/{id}', [PlayerController::class, 'destroy']);
    //Endpoint teams player
    Route::get('/players/{id}/teams', [PlayerController::class, 'show_teams']);

    //Endpoint create player medical record
    Route::post('/players/{id}/medicalrecords', [PlayerController::class, 'store_medicalrecords']);

    //Endpoints teams
    Route::get('/teams', [TeamController::class, 'index']);
    Route::get('/teams/{id}', [TeamController::class, 'show']);
    Route::get('/teams/{id}/games', [TeamController::class, 'show_games']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::put('/teams/{id}', [TeamController::class, 'update']);
    Route::delete('/teams/{id}', [TeamController::class, 'destroy']);
    Route::get('/teams/{id}/players', [TeamController::class, 'show_players']);

    Route::post('/teams/{id}/players/{id_player}', [TeamController::class, 'store_player']);

    //Endpoints medicalrecorts
    Route::get('/medicalrecords', [MedicalRecordController::class, 'index']);
    Route::get('/medicalrecords/{id}', [MedicalRecordController::class, 'show']);
    Route::get('/medicalrecords/{id}/player', [MedicalRecordController::class, 'show_player']);
    Route::delete('/medicalrecords/{id}', [MedicalRecordController::class, 'destroy']);

    //Endpoints games
    Route::get('/games', [GameController::class, 'index']);
    Route::get('/games/{id}', [GameController::class, 'show']);
    Route::post('/games', [GameController::class, 'store']);

    //Enpoints Teams with games
    Route::get('/teamswithgames/{id?}', [TeamController::class, 'show_teams_withgames']);
    Route::get('/teams/{id}/lastgame', [TeamController::class, 'show_last_game']);
    Route::get('/teams/{id}/bestgame', [TeamController::class, 'show_best_game']);

});

Route::middleware([ApiForceAcceptHeader::class, 'auth:api',,'scope:user:read'])->group(function () {

    Route::post('/players', [PlayerController::class, 'store']);

    Route::put('/players/{id}', [PlayerController::class, 'update']);

    Route::delete('/players/{id}', [PlayerController::class, 'destroy']);

    Route::post('/players/{id}/medicalrecords', [PlayerController::class, 'store_medicalrecords']);

    Route::post('/teams', [TeamController::class, 'store']);

    Route::put('/teams/{id}', [TeamController::class, 'update']);

    Route::delete('/teams/{id}', [TeamController::class, 'destroy']);

    Route::post('/teams/{id}/players/{id_player}', [TeamController::class, 'store_player']);

    Route::delete('/medicalrecords/{id}', [MedicalRecordController::class, 'destroy']);

    Route::post('/games', [GameController::class, 'store']);
});