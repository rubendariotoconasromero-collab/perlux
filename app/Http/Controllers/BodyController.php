<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;

class BodyController extends Controller
{
    //
    public function index(Request $request){
        return view('site.body')->with(['CollectionID'=>$request->CollectionID]);
    }

    // public function loadData(){
    //     $sizes=Size::get();
    //     $colors=Color::get();
    //     $products=Product::with('colors', 'sizes', 'collection', 'images', 'details', 'settings', 'policies')->orderBy('ProductID', 'desc')->get();

    //     return [
    //         'sizes'=>$sizes,
    //         'colors'=>$colors,
    //         'products'=>$products,
    //     ];
    // }
    public function loadData(){
        $sizes = Size::get();
        $colors = Color::get();
        $products = Product::with([
            'collection', 
            'images', 
            'details', 
            'settings', 
            'policies',
            'variants.size',
            'variants.color'
        ])->orderBy('ProductID', 'desc')->get();

        // Agregar stock total calculado a cada producto
        $products->transform(function ($product) {
            $product->StockQuantity = $product->variants->sum('StockQuantity');
            return $product;
        });

        return [
            'sizes' => $sizes,
            'colors' => $colors,
            'products' => $products,
        ];
    }
}
