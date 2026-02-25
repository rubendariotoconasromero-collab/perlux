<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function indexAdmin(){
        return view('admin.frmColor');                                                           
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $query = Color::query();

        if ($search) {
            $query->where('ColorName', 'like', "%{$search}%")
                  ->orWhere('HexCode', 'like', "%{$search}%");
        }

        $colors = $query->orderBy('ColorID','desc')->paginate(10);
        return response()->json($colors);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ColorName' => 'required|string|max:50',
            'HexCode' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $color = Color::create($request->only(['ColorName', 'HexCode']));
        return response()->json(['message' => 'Color creado exitosamente', 'color' => $color], 201);
    }

    public function show($id)
    {
        $color = Color::findOrFail($id);
        return response()->json($color);
    }

    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'ColorName' => 'required|string|max:50',
            'HexCode' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $color->update($request->only(['ColorName', 'HexCode']));
        return response()->json(['message' => 'Color actualizado exitosamente', 'color' => $color]);
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return response()->json(['message' => 'Color eliminado exitosamente']);
    }
}
