<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function indexAdmin(){
        return view('admin.frmUser');  
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $query = User::with('role');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);
        return response()->json($users);
    }

    public function getRoles()
    {
        $roles = Role::where('estado', 'activo')->get();
        return response()->json(['data' => $roles]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'dni' => 'nullable|string|max:8',
            'document_type' => 'nullable|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'estado' => 'required|in:activo,inactivo',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('password_confirmation');
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'dni' => 'nullable|string|max:8',
            'document_type' => 'nullable|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'estado' => 'required|in:activo,inactivo',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('password_confirmation');
        
        // Solo actualizar contraseña si se proporciona
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user->fresh(['role'])
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // No permitir eliminar al usuario actual (si es el mismo que está logueado)
        if (auth()->id() == $user->id) {
            return response()->json(['message' => 'No puedes eliminar tu propio usuario'], 400);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado exitosamente']);
    }
}
