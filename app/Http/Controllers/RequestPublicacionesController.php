<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Publicaciones;

class RequestPublicacionesController extends Controller
{
    public function store(Request $request)
    {
        $captchaToken = $request->input('g-recaptcha-response');

        if (!$captchaToken) {
            return response()->json([
                'success' => false,
                'errors'  => ['captcha' => ['Por favor completa el captcha.']]
            ], 422);
        }

        $captchaResponse = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('services.recaptcha.secret_key'),
                'response' => $captchaToken,
                'remoteip' => $request->ip(),
            ]
        );

        if (!$captchaResponse->json('success')) {
            return response()->json([
                'success' => false,
                'errors'  => ['captcha' => ['Captcha inválido. Intenta de nuevo.']]
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'titulo'    => 'required',
            'contenido' => 'required',
            'email'     => 'required|email',
            'imagen'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'titulo.required'    => 'El título es obligatorio.',
            'contenido.required' => 'El contenido es obligatorio.',
            'email.required'     => 'El correo es obligatorio.',
            'email.email'        => 'El correo no tiene un formato válido.',
            'imagen.required'    => 'La imagen es obligatoria.',
            'imagen.image'       => 'El archivo debe ser una imagen.',
            'imagen.mimes'       => 'Formatos permitidos: jpeg, png, jpg, webp.',
            'imagen.max'         => 'La imagen no puede superar 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $rutaImagen = $request->file('imagen')->store('publicaciones', 'public');

        $pub = Publicaciones::create([
            'titulo'         => $request->titulo,
            'contenido'      => $request->contenido,
            'email_registro' => $request->email,
            'imagen'         => $rutaImagen,
            'fecha_registro' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Publicación guardada correctamente!',
            'publicacion' => [
                'titulo'         => $pub->titulo,
                'contenido'      => $pub->contenido,
                'email_registro' => $pub->email_registro,
                'fecha_registro' => $pub->fecha_registro,
                'imagen_url'     => asset('storage/' . $pub->imagen),
            ]
        ]);
    }
}