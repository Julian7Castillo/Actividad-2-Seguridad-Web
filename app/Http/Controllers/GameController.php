<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    /**
     * Show all games from table game
     */
    public function index()
    {
        //devuelve todos los registros de la tabla game
        $games= Game::all();
        // Devuelve JSON con código 200 OK
        return response()->json($games, 200);
    }

    /**
     * Get a game
     */
    public function show(int $id)
    {
        // Buscar el player por su id
        $game = Game::find($id);
        if($game){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($game, 200);
        }else{
            $data = [
                'msg' => "Geam not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    /**
     * Store a game
     */
    public function store(Request $request){
        $validated = $request->validate([
            'is_home' => 'required',
            'pts_team' => 'required|gte:0',
            'pts_op_team' => 'required|gte:0',
            'name_op_team' => 'required|max:128',
            'date_play' => 'required',
            'team_id' => 'required'
        ]);

        //Insert a new game
        $game = new Game;
        $game->fill($validated);
        $game->save();

        $data = ['message' => 'Game created successfully', 'game' => $game];
        return response()->json($data, 201);
    }


}
