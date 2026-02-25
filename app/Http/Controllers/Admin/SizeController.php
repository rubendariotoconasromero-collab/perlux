<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    public function indexAdmin(){
        return view('admin.frmSize');
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $query = Size::query();

        if ($search) {
            $query->where('SizeName', 'like', "%{$search}%");
        }

        $sizes = $query->orderBy('SizeID', 'desc')->paginate(10);
        return response()->json($sizes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SizeName' => 'required|string|max:10',
            'Bust' => 'nullable|numeric|between:0,999.99',
            'Waist' => 'nullable|numeric|between:0,999.99',
            'Hips' => 'nullable|numeric|between:0,999.99',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $size = Size::create($request->only(['SizeName', 'Bust', 'Waist', 'Hips']));
        return response()->json(['message' => 'Talla creada exitosamente', 'size' => $size], 201);
    }

    public function show($id)
    {
        $size = Size::findOrFail($id);
        return response()->json($size);
    }

    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'SizeName' => 'required|string|max:10',
            'Bust' => 'nullable|numeric|between:0,999.99',
            'Waist' => 'nullable|numeric|between:0,999.99',
            'Hips' => 'nullable|numeric|between:0,999.99',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $size->update($request->only(['SizeName', 'Bust', 'Waist', 'Hips']));
        return response()->json(['message' => 'Talla actualizada exitosamente', 'size' => $size]);
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        return response()->json(['message' => 'Talla eliminada exitosamente']);
    }
}
