<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\View;

class LicenciaController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    private $host;

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

        $grupo = $request->input("combogrupos");            
        if($grupo=="grupo6"){
            $this->host = 'http://35.232.40.193:10000/post/comunicacionesb/';
            //var_dump($grupo);
            //print_r($grupo);
            //return View::make('defuncionesInfo');
        }
        elseif($grupo=="grupo1")  {
            $this->host = 'http://35.184.41.20:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo2")  {
            $this->host = 'http://35.239.54.7:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo3")  {
            $this->host = 'http://35.184.97.83:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo4")  {
            $this->host = 'http://35.193.113.191:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo5")  {
            //$this->host = 'http://35.232.40.193:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo7")  {
            $this->host = 'http://35.211.247.121:10000/post/comunicacionesb/';
        }
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
        $grupo = $request->input("combogrupos");            
        if($grupo=="grupo6"){
            $this->host = 'http://35.232.40.193:10000/post/comunicacionesb/';
            //var_dump($grupo);
            //print_r($grupo);
            //return View::make('defuncionesInfo');
        }
        elseif($grupo=="grupo1")  {
            //$this->host = 'http://35.232.40.193:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo2")  {
            $this->host = 'http://35.239.54.7:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo3")  {
            $this->host = 'http://35.184.97.83:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo4")  {
            $this->host = 'http://35.193.113.191:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo5")  {
            //$this->host = 'http://35.232.40.193:10000/post/comunicacionesb/';
        }
        elseif($grupo=="grupo7")  {
            $this->host = 'http://35.211.247.121:10000/post/comunicacionesb/';
        }

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
