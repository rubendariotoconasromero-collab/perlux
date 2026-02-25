<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PersonalDataController extends Controller
{
    public function index(){
        return view('site.personal');
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validación
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:20',
                'document_type' => 'required|in:DNI,CE,PASAPORTE',
                'dni' => 'required_if:document_type,DNI|nullable|string|size:8|unique:users,dni,' . $user->id,
            ], [
                'name.required' => 'El nombre es obligatorio',
                'last_name.required' => 'Los apellidos son obligatorios',
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El correo electrónico debe tener un formato válido',
                'email.unique' => 'Este correo electrónico ya está registrado',
                'phone.required' => 'El teléfono es obligatorio',
                'document_type.required' => 'El tipo de documento es obligatorio',
                'document_type.in' => 'El tipo de documento debe ser DNI, CE o PASAPORTE',
                'dni.required_if' => 'El DNI es obligatorio si el tipo de documento es DNI',
                'dni.unique' => 'Este DNI ya está registrado',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Actualizar datos
            $user->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'document_type' => $request->document_type,
                'dni' => $request->dni
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Datos actualizados correctamente',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener direcciones del usuario
     */
    public function getAddresses()
    {
        try {
            $user = Auth::user();
            $addresses = $user->addresses()->orderBy('created_at', 'desc')->get();

            return response()->json($addresses);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las direcciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear nueva dirección
     */
    public function storeAddress(Request $request)
    {
        try {
            $user = Auth::user();

            // Validación
            $validator = Validator::make($request->all(), [
                'department' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'street' => 'required|string|max:255',
                'number' => 'required|string|max:20',
                'detail' => 'nullable|string|max:500'
            ], [
                'department.required' => 'El departamento es obligatorio',
                'province.required' => 'La provincia es obligatoria',
                'district.required' => 'El distrito es obligatorio',
                'street.required' => 'La calle/avenida es obligatoria',
                'number.required' => 'El número es obligatorio'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Crear dirección
            $address = $user->addresses()->create([
                'department' => $request->department,
                'province' => $request->province,
                'district' => $request->district,
                'street' => $request->street,
                'number' => $request->number,
                'detail' => $request->detail
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dirección agregada correctamente',
                'address' => $address
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la dirección: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar dirección existente
     */
    public function updateAddress(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $address = $user->addresses()->findOrFail($id);

            // Validación
            $validator = Validator::make($request->all(), [
                'department' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'street' => 'required|string|max:255',
                'number' => 'required|string|max:20',
                'detail' => 'nullable|string|max:500'
            ], [
                'department.required' => 'El departamento es obligatorio',
                'province.required' => 'La provincia es obligatoria',
                'district.required' => 'El distrito es obligatorio',
                'street.required' => 'La calle/avenida es obligatoria',
                'number.required' => 'El número es obligatorio'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Actualizar dirección
            $address->update([
                'department' => $request->department,
                'province' => $request->province,
                'district' => $request->district,
                'street' => $request->street,
                'number' => $request->number,
                'detail' => $request->detail
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dirección actualizada correctamente',
                'address' => $address
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dirección no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la dirección: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar dirección
     */
    public function deleteAddress($id)
    {
        try {
            $user = Auth::user();
            $address = $user->addresses()->findOrFail($id);
            
            $address->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dirección eliminada correctamente'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dirección no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la dirección: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Renombramos 'confirmPassword' a 'newPassword_confirmation' para la validación 'confirmed'
        $request->merge(['newPassword_confirmation' => $request->input('confirmPassword')]);

        $validated = $request->validate([
            'password' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed',
        ], [
            'newPassword.confirmed' => 'Las contraseñas nuevas no coinciden.',
            'newPassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['La contraseña actual es incorrecta.'],
            ])->status(401);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
    }
}
