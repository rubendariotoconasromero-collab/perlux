<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JeansController extends Controller
{
    public function index(Request $request){
        return view('site.jeans')->with(['CollectionID'=>$request->CollectionID]);
    }

    
}
