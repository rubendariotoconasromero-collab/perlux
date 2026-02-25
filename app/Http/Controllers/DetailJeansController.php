<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailJeansController extends Controller
{
    public function index(Request $request){
        return view('site.DetailJeans')->with(['product_id'=>$request->product_id]);
    }
}
