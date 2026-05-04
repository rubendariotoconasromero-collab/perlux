<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class CollectionController extends Controller
{
    public function indexAdmin(){
        return view('admin.frmCollection');
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $query = Collection::query();

        if ($search) {
            $query->where('CollectionName', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
        }

        $collections = $query->orderBy('CollectionID', 'desc')->paginate(10);
        return response()->json($collections);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CollectionName' => 'required|string|max:100',
            'Tipo' => 'nullable|string|max:100',
            'Description' => 'nullable|string|max:500',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'LaunchDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['CollectionName', 'Tipo', 'Description', 'LaunchDate']);
        
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['Image'] = 'images/products/' . $filename;
        }

        $collection = Collection::create($data);
        return response()->json(['message' => 'Colección creada exitosamente', 'collection' => $collection], 201);
    }

    public function show($id)
    {
        $collection = Collection::findOrFail($id);
        return response()->json($collection);
    }

    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'CollectionName' => 'required|string|max:100',
            'Tipo' => 'nullable|string|max:100',
            'Description' => 'nullable|string|max:500',
            // 'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'LaunchDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['CollectionName', 'Tipo','Description', 'LaunchDate']);
        
        if ($request->hasFile('Image')) {
            // Delete old image if exists
            if ($collection->Image && File::exists(public_path($collection->Image))) {
                File::delete(public_path($collection->Image));
            }
            $file = $request->file('Image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['Image'] = 'images/products/' . $filename;
        }

        $collection->update($data);
        return response()->json(['message' => 'Colección actualizada exitosamente', 'collection' => $collection]);
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();
        return response()->json(['message' => 'Colección eliminada exitosamente']);
    }

    public function getCollections(){
        $collections=Collection::orderBy('CollectionID', 'desc')->where('Tipo', 'glam')->get();
        return response()->json($collections);
    }

    public function getCollectionsNovias(){
        $collections=Collection::orderBy('CollectionID', 'desc')->where('Tipo', 'novias')->get();
        return response()->json($collections);
    }

    public function getCollectionsCarteras(){
        $collections=Collection::orderBy('CollectionID', 'desc')->where('Tipo', 'Carteras')->get();
        return response()->json($collections);
    }
}