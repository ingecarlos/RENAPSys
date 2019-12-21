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
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'localhost:9002/servicio_defuncion.php', [
        'form_params' => [
            'dpi' => $request->input('dpi'),
            ]
        ]);
        $response = $response->getBody()->getContents();
        return Redirect::to("/defuncion")->withSuccess('Bien hecho!');  
        echo '<pre>';
        print_r($response);
        
              
    }
}
