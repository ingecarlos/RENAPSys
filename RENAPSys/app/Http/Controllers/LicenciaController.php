<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LicenciaController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('licencia');
    }
}
