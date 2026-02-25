<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginSiteController extends Controller
{
    // public function index(){
    //     return view('site.login');
    // }

    public function index(Request $request){
        $section = $request->get('section', 'datos'); 
        return view('site.login', compact('section'));
    }



    public function indexRegister(){
        return view('site.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Devolver la URL de redirección en la respuesta JSON
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'redirect_url' => 'inicio' // Genera la URL de la ruta user_info
            ], 200);
        }

        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+51\d{9}$/',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'document_type' => 'required|string',
            'dni' => 'required_if:document_type,DNI|nullable|string|size:8|unique:users,dni', //Solo si DNI
            'addresses' => 'required|array',
            'addresses.*.department' => 'required|string',
            'addresses.*.province' => 'required|string',
            'addresses.*.district' => 'required|string',
            'addresses.*.street' => 'required|string',
            'addresses.*.number' => 'required|string',
        ], [
          
            'phone.unique' => 'Este número de celular ya está registrado.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'dni.required_if' => 'El DNI es obligatorio si el tipo de documento es DNI.',
            'addresses.min' => 'Debes registrar al menos una dirección.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'last_name' => $request->last_name,
            'document_type' => $request->document_type,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Default role, adjust as needed
            'estado' => 'activo',
            'dni' => $request->dni,
        ]);

        // Create address
        foreach ($request->addresses as $addressData) {
            Address::create([
                'user_id' => $user->id,
                'department' => $addressData['department'],
                'province' => $addressData['province'],
                'district' => $addressData['district'],
                'street' => $addressData['street'],
                'number' => $addressData['number'],
                'detail' => $addressData['detail'] ?? null,
            ]);
        }

        // Log in the user
        Auth::login($user);

        // Return success response
        return response()->json(['success' => true, 'message' => 'Registro exitoso. ¡Bienvenido!']);
    }

    public function logout(Request $request)
    {
        // Invalida la sesión y regenera el token CSRF
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Devuelve una respuesta JSON para que Vue pueda manejar la redirección
        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }
}
