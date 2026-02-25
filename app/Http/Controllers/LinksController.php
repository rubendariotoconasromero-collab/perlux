<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function indexClaimsBook(){
        return view('site.claims-book');
    }

    public function indexBusinessInfo(){
        return view('site.business-info');
    }

    
}
