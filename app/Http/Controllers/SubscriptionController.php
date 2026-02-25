<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeSubscription;
use App\Models\Email;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validar el email
        $validated = $request->validate([
            'email' => 'required|email|unique:emails,email',
        ],[
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ]);

        // Guardar en la base de datos
        Email::create(['email' => $validated['email']]);

        // Enviar correo de bienvenida
        Mail::to($validated['email'])->send(new WelcomeSubscription());

        // Respuesta (puedes ajustar para JSON si usas AJAX, o redirect si es form submit)
        return response()->json(['message' => '¡Suscripción exitosa! Revisa tu correo para el mensaje de bienvenida.']);
    }
}
