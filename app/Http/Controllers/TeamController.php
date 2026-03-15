<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\Player;

class TeamController extends Controller
{
    /**
     * Show all teams from table teams
     */
    public function index()
    {
        //devuelve todos los registros de la tabla players
        $teams= Team::all();
        // Devuelve JSON con código 200 OK
        return response()->json($teams, 200);
    }

    /**
     * Get a team
     */
    public function show(int $id)
    {
        // Buscar el player por su id
        $team = Team::find($id);
        if($team){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($team, 200);
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }
        
    }
    
    
    /**
     * Get team players
     */
    public function show_players(int $id)
    {
        // Buscar el player por su id
        $team = Team::with('image')->find($id);
        // Buscar el player por su id
        if($team){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($team->players, 200);
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }
        
    }
    /**
     * Get team games
     */
    public function show_games($id)
    {
        // Buscar el player por su id
        $team = Team::find($id);
        if($team){
            // Devolvemos los partidos jugados
            return response()->json($team->games, 200);
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }
    /**
     * Store a team
     */
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:128',
            'category' => 'required|in:prebenjamines,benjamines,alevines,infantiles,cadete,junior,senior',
            'gender' => 'required|in:female,male,other'
        ]);

        //Insert a new team
        $team = new Team;
 
        $team->name = $validated['name'];
        $team->category = $validated['category'];
        $team->gender = $validated['gender'];
         
        $team->save();
        
        $data = ['message' => 'Team stored successfully', 'player' => $team];
        return response()->json($data, 201);

    }

    /**
     * Update a team
     */
    public function update(int $id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|max:128',
            'category' => 'sometimes|in:prebenjamines,benjamines,alevines,infantiles,cadete,junior,senior',
            'gender' => 'sometimes|in:female,male,other'
        ]);

        // Buscar el player por su id
        $team = Team::find($id);
        if($team){
            //Si la validación es correcta actualizamos cada campo si existe
            if ($request->has('name')) {
                $team->name = $validated['name'];
            }
            if ($request->has('category')) {
                $team->category = $validated['category'];
            }
            if ($request->has('gender')) {
                $team->gender = $validated['gender'];
            }
            //Salvamos el player
            $team->save();
            $data = ['message' => 'Updated team successfully', 'team' => $team];
            return response()->json($data, 200);

        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }
    /**
     * Delete a team
     */
    public function destroy(int $id)
    {
        // Buscar el player por su id
        $team = Team::find($id);
        if($team){
            // Eliminar el team
            $team->delete();
            return response()->json([
                'msg' => "Team with id=$id deleted",
            ], 200);
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }
    }   


    /**
     * Show all teams with games
     */
    public function show_teams_withgames(?int $id = null)
    {
        if($id == null){
            //devolvemos todos los equipos incluyendo los partidos
            $teams = Team::with('games')->get();
        }else{
            //devolvemos el equipo incluyendo sus partidos
            $teams = Team::with('games')->find($id);
        }
        return response()->json($teams, 200); // Devuelve JSON con código 200 OK
    }

    /**
     * Get last game team
     */
    public function show_last_game($id)
    {
        // Buscar el player por su id
        $game = Team::find($id)->latestGame;
        if($game){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($game, 200);
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    /**
     * Get best game team
     */
    public function show_best_game($id)
    {

        // Buscar el player por su id
        $team = Team::find($id);
        if($team){
            $game = Team::find($id)->bestGame;
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($game, 200);
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    
    /**
     * Store a player in a team
    */
    public function store_player($id,$id_player)
    {
        // Buscar el player por su id
        $team = Team::find($id);
        if($team){
            // Insertamos el player
            $player = Player::find($id_player);
            if($player){
                //$team->players()->atach($player);
                $team->players()->syncWithoutDetaching($id_player);
                $teamPlayers = Team::with('players')->find($id);
                return response()->json($teamPlayers, 200);
            }else{
                $data = [
                    'msg' => "Player not found with id=$id_player",
                ];
                return response()->json($data, 404);
            }
        }else{
            $data = [
                'msg' => "Team not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }


}
