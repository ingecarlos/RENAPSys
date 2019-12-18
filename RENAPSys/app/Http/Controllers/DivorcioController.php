<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class DivorcioController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('divorcio');
    }

    public function store(Request $request)
    {
        return Redirect::to("/divorcio")->withSuccess('Bien hecho!');
        
    }

}
