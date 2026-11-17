<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get(){
        return response()->json([
            'mensaje' => 'Soy la ruta GET y me consumiste por GET'
        ], 200);
    }

    public function post(){
        return response()->json([
            'mensaje' => 'Soy la ruta POST y me consumiste por POST'
        ], 200);
    }

    public function put(){
        return response()->json([
            'mensaje' => 'Soy la ruta PUT y me consumiste por PUT'
        ], 200);
    }

    public function patch(){
        return response()->json([
            'mensaje' => 'Soy la ruta PATCH y me consumiste por PATCH'
        ], 200);
    }

    public function delete(){
        return response()->json([
            'mensaje' => 'Soy la ruta DELETE y me consumiste por DELETE'
        ], 200);
    }
}
