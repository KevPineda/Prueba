<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicaciones;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    private string $usuario    = 'admin@blog.com';
    private string $contrasena = 'Admin1234';

    public function showLogin()
    {
        if (session('admin_logueado')) {
            return redirect()->route('admin.listado');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($request->email === $this->usuario && $request->password === $this->contrasena) {
            session(['admin_logueado' => true]);
            return redirect()->route('admin.listado');
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.'
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        session()->forget('admin_logueado');
        return redirect()->route('login');
    }

    public function adminListado()
    {
        $publicaciones = Publicaciones::orderBy('fecha_registro', 'desc')->get();
        return view('admin.listado', compact('publicaciones'));
    }

    public function adminDetalle($id)
    {
        $publicacion = Publicaciones::findOrFail($id);
        return view('admin.detalle', compact('publicacion'));
    }

    public function eliminar($id)
{
    $publicacion = Publicaciones::findOrFail($id);

    if ($publicacion->imagen && Storage::disk('public')->exists($publicacion->imagen)) {
        Storage::disk('public')->delete($publicacion->imagen);
    }

    $publicacion->delete();

    return redirect()->route('admin.listado')
        ->with('success', 'Publicación eliminada correctamente.');
}
}