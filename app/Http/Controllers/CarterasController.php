<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarterasController extends Controller
{
    public function index(Request $request){
        return view('site.carteras')->with(['CollectionID' => $request->CollectionID]);
    }
}
