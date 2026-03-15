<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\MedicalRecord;

use Carbon\Carbon;

class PlayerController extends Controller
{
    /**
     * Show all players from table players
     */
    public function index()
    {
        //devuelve todos los registros de la tabla players
        $players = Player::all();
        // Devuelve JSON con código 200 OK
        return response()->json($players, 200);
    }

    /**
     * Get a player
     */
    public function show(int $id)
    {
        // Buscar el player por su id
        $player =  Player::with('image')->find($id);
        if($player){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($player, 200);
        }else{
            $data = [
                'msg' => "Player not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    /**
     * Get a player medical record
     */
    public function show_medical_record($id)
    {
        // Buscar el player por su id
        $player = Player::find($id);
        if($player){
            // Devolvemos el medical record
            return response()->json($player->medical_record, 200);
        }else{
            $data = [
                'msg' => "Player not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    /**
     * Get teams player
     */
    public function show_teams(int $id)
    {
        // Buscar el player por su id
        $player = Player::find($id);
        if($player){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($player->teams, 200);
        }else{
            $data = [
                'msg' => "Player not found with id=$id",
            ];
            return response()->json($data, 404);
        }
        
    }
    /**
     * Get a player
     */
    public function showByFirstName(string $first_name)
    {
        // Buscar el player por su id
        $player = Player::where('first_name',$first_name)->first();
        if($player){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($player, 200);
        }else{
            $data = [
                'msg' => "Player not found with firs_name=$first_name",
            ];
            return response()->json($data, 404);
        }

    }

    
    /**
     * Store a player
     */
    public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required|max:128',
            'last_name' => 'required|max:256',
            'gender' => 'required|in:female,male,other',
            'date_birth' => 'required|date|before_or_equal:'. Carbon::now()->subYears(6),
        ]);

        //Insert a new player
        $player = new Player;
 
        $player->first_name = $validated['first_name'];
        $player->last_name = $validated['last_name'];
        $player->gender = $validated['gender'];
        $player->date_birth = $validated['date_birth'];
         
        $player->save();
        
        $data = ['message' => 'Usuario creado successfully', 'player' => $player];
        return response()->json($data, 201);

    }

    /**
     * Store a player medical record
     */
    public function store_medicalrecords($id, Request $request){
        $validated = $request->validate([
            'medical_public_id' => 'required|max:128',
            'allergies' => 'required|max:256',
            'blood_type' => 'required|in:A,B,AB,O',
            'injuries' => 'required|max:512',
        ]);


        // Buscar el player por su id
        $player = Player::find($id);
        if($player){
            // Buscar el MedicalRecord por el player id
            $medicalrecordFind = $player->medical_record;
            if($medicalrecordFind){
                $data = [
                    'msg' => "Player's medical record exist",
                ];
                return response()->json($data, 200);
            }
            $medicalrecord = new MedicalRecord();
            $medicalrecord->fill($validated);
            // Insertamos el medical record para ese player
            $player->medical_record()->save($medicalrecord);
            $player->refresh();
            // Devolvemos el medical record
            return response()->json($player->medical_record, 201);
        }else{
            $data = [
                'msg' => "Player not found with id=$id",
            ];
            return response()->json($data, 404);
        }
    }

    /**
     * Update a player
     * 
     * @param  int  $id  the Player id
     */
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|max:128',
            'last_name' => 'sometimes|max:256',
            'gender' => 'sometimes|in:female,male,other',
            'date_birth' => 'sometimes|date|before_or_equal:'. Carbon::now()->subYears(6),
        ]);

        // Buscar el player por su id
        $player = Player::find($id);
        if($player){
            //Si la validación es correcta actualizamos cada campo si existe
            if ($request->has('first_name')) {
                $player->first_name = $validated['first_name'];
            }
            if ($request->has('last_name')) {
                $player->last_name = $validated['last_name'];
            }
            if ($request->has('gender')) {
                $player->gender = $validated['gender'];
            }
            if ($request->has('date_birth')) {
                $player->date_birth = $validated['date_birth'];
            }
            //Salvamos el player
            $player->save();
            $data = ['message' => 'Updated player successfully', 'player' => $player];
            return response()->json($data, 200);

        }else{
            $data = [
                'msg' => "Player not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }
    /**
     * Delete a player
     */
    public function destroy(int $id)
    {
        // Buscar el player por su id
        $player = Player::find($id);
        if($player){
            // Elimina el medical record asociado
            $player->medical_record()->delete();
            //Desvincular todos los teams de la tabla intermedia
            $player->teams()->detach();
            // Eliminar el player
            $player->delete();
            return response()->json([
                'msg' => "Player with id=$id deleted",
            ], 200);
        }else{
            $data = [
                'msg' => "Player not found with id=$id",
            ];
            return response()->json($data, 404);
        }
    }   
 
}
