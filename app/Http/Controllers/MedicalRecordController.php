<?php

namespace App\Http\Controllers;
use App\Models\MedicalRecord;
use App\Models\User;

use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Show all medical records from table medicalrecords
     */
    public function index()
    {
        //devuelve todos los registros de la tabla players
        $medicalrecords= MedicalRecord::all();
        // Devuelve JSON con código 200 OK
        return response()->json($medicalrecords, 200);
    }

    /**
     * Get a medical record
     */
    public function show(int $id)
    {
        // Buscar el player por su id
        $medicalrecord = MedicalRecord::find($id);
        if($medicalrecord){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($medicalrecord, 200);
        }else{
            $data = [
                'msg' => "Medical record not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    /**
     * Get a player medical record
     */
    public function show_player($id)
    {
        // Buscar el player por su id
        $medicalrecord = MedicalRecord::find($id);
        if($medicalrecord){
            // Devolvemos el medical record
            return response()->json($medicalrecord->player, 200);
        }else{
            $data = [
                'msg' => "Medical record not found with id=$id",
            ];
            return response()->json($data, 404);
        }


    }

    /**
     * Get a medical record from user
     */
    public function show_user_medical_record($id)
    {
        // Buscar el player por su id
        $user = User::with(['medical_record','player'])->find($id);
        if($user){
            // Puedes retornar una vista o una respuesta JSON, según necesites
            return response()->json($user, 200);
        }else{
            $data = [
                'msg' => "User not found with id=$id",
            ];
            return response()->json($data, 404);
        }

    }

    /**
     * Delete a medicalrecord
     */
    public function destroy(int $id)
    {
        // Buscar el player por su id
        $medicalrecord = MedicalRecord::find($id);
        if($medicalrecord){
            // Eliminar el player
            $medicalrecord->delete();
            return response()->json([
                'msg' => "MedicalRecord with id=$id deleted",
            ], 200);
        }else{
            $data = [
                'msg' => "MedicalRecord not found with id=$id",
            ];
            return response()->json($data, 404);
        }
    }  
}
