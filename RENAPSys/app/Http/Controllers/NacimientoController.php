<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class NacimientoController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('nacimiento');
    }

    public function store(Request $request)
    {
        return Redirect::to("/nacimiento")->withSuccess('Bien hecho!');
        
    }
}
