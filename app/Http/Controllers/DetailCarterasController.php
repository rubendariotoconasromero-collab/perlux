<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailCarterasController extends Controller
{
    public function index(Request $request){
        return view('site.detail_carteras');
    }
}
