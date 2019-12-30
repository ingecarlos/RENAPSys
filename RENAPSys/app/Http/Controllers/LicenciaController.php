<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class LicenciaController extends Controller
{
    private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';

    public function __construct()
    {

    }

    public function index()
    {
        return view('licencia');
    }

    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        /*
        $response = $client->request('POST', $this->host.':9005/', [
        'form_params' => [
            'dpi' => $request->input('dpi'),
            'tipo' => $request->input('tipo'),
            'añosAntiguedad' => $request->input('añosAntiguedad'),            
            ]   
        ]);
        $response = $response->getBody()->getContents();
        
        echo '<pre>';
        print_r($response);    
        $apiResult = json_decode($response->getBody(), true);           
        var_dump($apiResult);
        return Redirect::to("/licencia")->withSuccess('Bien hecho!');
        */

        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => '/setLicencia',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi'),
                             'tipo' => $request->input('tipo'),
                             'añosAntiguedad' => $request->input('añosAntiguedad'),
                                )                       
                ]   
            ]);

            $res = (string) $response->getBody();
            $json = json_decode($res); 
            $est = $json->estado;
            $msj = $json->mensaje;

            if($est=="200"){
                return Redirect::to("/licencia")->withSuccess('Registro almacenado.');  
            }else{
                return View::make('info')->with('est', $est)->with('msj', $msj);
            }   
    }
}
