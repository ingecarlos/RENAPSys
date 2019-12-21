<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class NacimientoController extends Controller
{
    private $host = '35.232.40.193';

    public function __construct()
    {

    }

    public function index()
    {
        return view('nacimiento');
    }

    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->host.':9000/', [
        'form_params' => [
            'dpiHhombre' => $request->input('dpimadre'),
            'dpiMujer' => $request->input('dpipadre'),
            'apellido' => $request->input('apellidos'),
            'nombre' => $request->input('nombres'),            
            'fechaNacimiento' => $request->input('fechaf'),
            'sexo' => $request->input('sexo'),
            'depto' => $request->input('depto'),
            'municipio' => $request->input('municipio'),            
            ]   
        ]);
        $response = $response->getBody()->getContents();
        return Redirect::to("/nacimiento")->withSuccess('Bien hecho!');
        //echo '<pre>';
        //print_r($response);                
    }
}
