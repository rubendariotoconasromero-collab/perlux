<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

   
    public function showLoginForm()
    {
        return view('admin.frmLogin');
    }

    

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role_id' => 1])) {
            // Redirigir con un mensaje de éxito a la vista
            return redirect('/bienvenida')->with('success', 'Inicio de sesión exitoso.');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas o usuario no autorizado.']);
    }

    public function logout(Request $request){
        Auth::logout(); // Laravel cierra la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Obtener la URL anterior de la sesión (si existe)
        $previousUrl = $request->session()->previousUrl();

        // Definir una ruta de redirección por defecto
        $defaultRedirect = '/admin'; // Cambia esto a la URL o ruta a la que quieras redirigir por defecto

        // Redirigir a la URL anterior si existe, de lo contrario, a la ruta por defecto
        return redirect()->intended($defaultRedirect);
    }
}
