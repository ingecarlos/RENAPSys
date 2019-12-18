<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class DefuncionController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('defuncion');
    }

    public function store(Request $request)
    {
        return Redirect::to("/defuncion")->withSuccess('Bien hecho!');
        
    }
}
