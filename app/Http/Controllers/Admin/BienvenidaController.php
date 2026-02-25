<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class BienvenidaController extends Controller
{
    public function index()
    {
        return view('admin.frmBienvenida');
    }

    /**
     * Obtener la información del usuario autenticado.
     */
    public function getUserInfo(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->image ?? null, // Asume que el modelo User tiene un campo 'image' opcional
        ]);
    }
}
