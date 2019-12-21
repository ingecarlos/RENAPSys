<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Session;

class PersonasController extends Controller
{
    public function index()
    {
        return view('personas');
    }

    public function store(Request $request)
    {
        return Redirect::to("/personasInfo");
    }

    public function info()
    {
        return view('personasInfo');
        
    }
}
