<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductDetail;
use App\Models\ProductSetting;
use App\Models\ProductPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.frmProduct');
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $query = Product::with(['collection', 'colors', 'sizes', 'images', 'details', 'settings', 'policies']);

        if ($search) {
            $query->where('Name', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
        }

        $products = $query->orderBy('ProductID', 'desc')->paginate(10);
        return response()->json($products);
    }

    public function store(Request $request)
    {
        if ($request->has('IsFeatured')) {
            $request->merge([
                'IsFeatured' => filter_var($request->IsFeatured, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:100',
            'Tipo' => 'nullable|string|max:500',
            'Description' => 'nullable|string|max:500',
            'Price' => 'required|numeric|min:0',
            'StockQuantity' => 'required|integer|min:0',
            'IsFeatured' => 'boolean',
            'CollectionID' => 'nullable|exists:collections,CollectionID',
            'Fabric' => 'nullable|string|max:100',
            'ReturnPolicy' => 'nullable|string|max:500',
            'ColorIDs' => 'array',
            'ColorIDs.*' => 'exists:colors,ColorID',
            'SizeIDs' => 'array',
            'SizeIDs.*' => 'exists:sizes,SizeID',
            'Images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'Details' => 'array',
            'Details.*.DetailName' => 'required_with:details|string|max:100',
            'Details.*.DetailValue' => 'required_with:details|string|max:500',
            'Settings' => 'array',
            'Settings.*.SettingName' => 'required_with:settings|string|max:100',
            'Settings.*.SettingValue' => 'required_with:settings|string|max:100',
            'Policies' => 'array',
            'Policies.*.PolicyName' => 'required_with:policies|string|max:100',
            'Policies.*.PolicyValue' => 'required_with:policies|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'Name', 'Tipo','Description', 'Price', 'StockQuantity', 
            'IsFeatured', 'CollectionID', 'Fabric', 'ReturnPolicy'
        ]);

        $product = Product::create($data);

        if ($request->has('ColorIDs')) {
            $product->colors()->sync($request->ColorIDs);
        }

        if ($request->has('SizeIDs')) {
            $product->sizes()->sync($request->SizeIDs);
        }

        if ($request->hasFile('Images')) {
            foreach ($request->file('Images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $filename);
                ProductImage::create([
                    'ProductID' => $product->ProductID,
                    'ImagePath' => 'images/products/' . $filename,
                ]);
            }
        }

        if ($request->has('Details')) {
            foreach ($request->Details as $detail) {
                ProductDetail::create([
                    'ProductID' => $product->ProductID,
                    'DetailName' => $detail['DetailName'],
                    'DetailValue' => $detail['DetailValue'],
                ]);
            }
        }

        if ($request->has('Settings')) {
            foreach ($request->Settings as $setting) {
                ProductSetting::create([
                    'ProductID' => $product->ProductID,
                    'SettingName' => $setting['SettingName'],
                    'SettingValue' => $setting['SettingValue'],
                ]);
            }
        }

        if ($request->has('Policies')) {
            foreach ($request->Policies as $policy) {
                ProductPolicy::create([
                    'ProductID' => $product->ProductID,
                    'PolicyName' => $policy['PolicyName'],
                    'PolicyValue' => $policy['PolicyValue'],
                ]);
            }
        }

        return response()->json(['message' => 'Producto creado exitosamente', 'product' => $product->load(['images', 'details', 'settings', 'policies'])], 201);
    }

    public function show($id)
    {
        $product = Product::with(['collection', 'colors', 'sizes', 'images', 'details', 'settings', 'policies'])->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->has('IsFeatured')) {
            $request->merge([
                'IsFeatured' => filter_var($request->IsFeatured, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:100',
            'Tipo' => 'nullable|string|max:500',
            'Description' => 'nullable|string|max:500',
            'Price' => 'required|numeric|min:0',
            'StockQuantity' => 'required|integer|min:0',
            'IsFeatured' => 'boolean',
            'CollectionID' => 'nullable|exists:collections,CollectionID',
            'Fabric' => 'nullable|string|max:100',
            'ReturnPolicy' => 'nullable|string|max:500',
            'ColorIDs' => 'array',
            'ColorIDs.*' => 'exists:colors,ColorID',
            'SizeIDs' => 'array',
            'SizeIDs.*' => 'exists:sizes,SizeID',
            'Images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'Details' => 'array',
            'Details.*.DetailName' => 'required_with:details|string|max:100',
            'Details.*.DetailValue' => 'required_with:details|string|max:500',
            'Settings' => 'array',
            'Settings.*.SettingName' => 'required_with:settings|string|max:100',
            'Settings.*.SettingValue' => 'required_with:settings|string|max:100',
            'Policies' => 'array',
            'Policies.*.PolicyName' => 'required_with:policies|string|max:100',
            'Policies.*.PolicyValue' => 'required_with:policies|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'Name', 'Tipo','Description', 'Price', 'StockQuantity', 
            'IsFeatured', 'CollectionID', 'Fabric', 'ReturnPolicy'
        ]);

        $product->update($data);

        if ($request->has('ColorIDs')) {
            $product->colors()->sync($request->ColorIDs);
        }

        if ($request->has('SizeIDs')) {
            $product->sizes()->sync($request->SizeIDs);
        }

        if ($request->hasFile('Images')) {
            foreach ($request->file('Images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $filename);
                ProductImage::create([
                    'ProductID' => $product->ProductID,
                    'ImagePath' => 'images/products/' . $filename,
                ]);
            }
        }

        if ($request->has('Details')) {
            $product->details()->delete();
            foreach ($request->Details as $detail) {
                ProductDetail::create([
                    'ProductID' => $product->ProductID,
                    'DetailName' => $detail['DetailName'],
                    'DetailValue' => $detail['DetailValue'],
                ]);
            }
        } else {
            $product->details()->delete();
        }

        if ($request->has('Settings')) {
            $product->settings()->delete();
            foreach ($request->Settings as $setting) {
                ProductSetting::create([
                    'ProductID' => $product->ProductID,
                    'SettingName' => $setting['SettingName'],
                    'SettingValue' => $setting['SettingValue'],
                ]);
            }
        } else {
            $product->settings()->delete();
        }

        if ($request->has('Policies')) {
            $product->policies()->delete();
            foreach ($request->Policies as $policy) {
                ProductPolicy::create([
                    'ProductID' => $product->ProductID,
                    'PolicyName' => $policy['PolicyName'],
                    'PolicyValue' => $policy['PolicyValue'],
                ]);
            }
        } else {
            $product->policies()->delete();
        }

        return response()->json(['message' => 'Producto actualizado exitosamente', 'product' => $product->load(['images', 'details', 'settings', 'policies'])]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->images as $image) {
            if (File::exists(public_path($image->ImagePath))) {
                File::delete(public_path($image->ImagePath));
            }
        }
        $product->images()->delete();
        $product->details()->delete();
        $product->settings()->delete();
        $product->policies()->delete();
        $product->delete();
        return response()->json(['message' => 'Producto eliminado exitosamente']);
    }

    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if (File::exists(public_path($image->ImagePath))) {
            File::delete(public_path($image->ImagePath));
        }
        $image->delete();
        return response()->json(['message' => 'Imagen eliminada exitosamente']);
    }
}