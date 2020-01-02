<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class DefuncionController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    private $host;

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
        /*
        $response = $client->request('POST', $this->host.':9002/', [
        'form_params' => [
            'dpi' => $request->input('dpi'),
            'fecha' => $request->input('fechaf'),
            ]   
        ]);
        $response = $response->getBody()->getContents();
        return Redirect::to("/defuncion")->withSuccess('Bien hecho!');  
        echo '<pre>';
        print_r($response);
        */

        
        //$response = $client->request('POST', $this->host.':9002/', [        
            $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9002/setDefuncion',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi'),
                                    'fecha' => $request->input('fechaf')
                                    )
                ]
            ]);

                //$response = $response->getBody()->getContents();
            //echo '<pre>';
            //print_r($response);
            //$apiResult = json_decode($response->getBody(), true);
            //var_dump($apiResult);
            
            $res = (string) $response->getBody();
            $json = json_decode($res); 
            $est = $json->estado;
            $msj = $json->mensaje;

            if($est=="200"){
                return Redirect::to("/defuncion")->withSuccess('Registro almacenado.');  
            }else{
                return View::make('info')->with('est', $est)->with('msj', $msj);
            }                    
    }
}
