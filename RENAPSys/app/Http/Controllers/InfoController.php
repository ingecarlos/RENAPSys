<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class InfoController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('info');
    }

}
