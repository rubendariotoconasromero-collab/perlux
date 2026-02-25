<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailBodyController extends Controller
{
    public function index(Request $request){
        return view('site.DetailBody')->with(['product_id'=>$request->product_id]);
    }
}
