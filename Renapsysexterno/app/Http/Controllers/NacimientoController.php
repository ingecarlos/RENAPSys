<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\View;

class NacimientoController extends Controller
{
    private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';

    public function __construct()
    {

    }

    public function index()
    {
        return view('nacimiento');
    }

    public function store(Request $request)
    {
        $apellidosLower = strtolower($request->input('apellidos'));
        $nombresLower = strtolower($request->input('nombres'));
        $sexoLower = strtolower($request->input('sexo'));
        $client = new \GuzzleHttp\Client();
        /*
        $response = $client->request('POST', $this->host.':9000/', [
        'form_params' => [
            'dpiHombre' => $request->input('dpimadre'),
            'dpiMujer' => $request->input('dpipadre'),
            'apellido' => $request->input('apellidos'),
            'nombre' => $request->input('nombres'),            
            'fechaNacimiento' => $request->input('fechaf'),
            'genero' => $request->input('sexo'),
            'departamento' => $request->input('depto'),
            'municipio' => $request->input('municipio'),            
            ]   
        ]);
        $response = $response->getBody()->getContents();
        return Redirect::to("/nacimiento")->withSuccess('Bien hecho!');
        //echo '<pre>';
        //print_r($response);   
        */
        
        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9000/setNacimiento',
                'tipo' => 'POST',
                'parametros' =>
                             array(                
                                'dpipadre' => $request->input('dpipadre'),
                                'dpimadre' => $request->input('dpimadre'),
                                'apellido' => $apellidosLower,
                                'nombre' => $nombresLower,
                                'fechanacimiento' => $request->input('fechaf'),
                                'genero' => $sexoLower,
                                'departamento' => $request->input('depto'),
                                'municipio' => $request->input('municipio')
                             )
                ]   
            ]);

            $res = (string) $response->getBody();
            $json = json_decode($res); 
            $est = $json->estado;
            $msj = $json->mensaje;

            if($est=="200"){
                return Redirect::to("/nacimiento")->withSuccess('Registro almacenado.');  
            }else{
                return View::make('info')->with('est', $est)->with('msj', $msj);
            }   
    }
}