<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class MatrimonioController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('matrimonio');
    }

    public function store(Request $request)
    {
        return Redirect::to("/matrimonio")->withSuccess('Bien hecho!');
        
    }
}
