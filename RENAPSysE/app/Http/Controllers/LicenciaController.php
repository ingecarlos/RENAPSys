<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\View;

class LicenciaController extends Controller
{
    private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';

    public function __construct()
    {

    }

    public function indexMenu()
    {
        return view('licenciamenu');
    }

    public function indexAsignar()
    {
        return view('licencia');
    }

    public function indexActualizar()
    {
        return view('licenciaActualizar');
    }

    public function store(Request $request)
    {

        $tipoLower = strtolower($request->input('tipo'));
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
                'url' => 'http://35.232.40.193:9005/setLicencia',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi'),
                             'tipo' => $tipoLower,
                             'añosantiguedad' => $request->input('añosAntiguedad'),
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

    public function update(Request $request)
    {

        $tipoLower = strtolower($request->input('tipo'));
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9005/setActualizar',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi'),
                             'tipo' => $tipoLower,                             
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
