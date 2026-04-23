<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicaciones;

class PublicacionesController extends Controller
{
    public function listado()
    {
        $publicaciones = Publicaciones::orderBy('fecha_registro', 'desc')->get();
        return view('publicaciones.formulario', compact('publicaciones'));
    }
}