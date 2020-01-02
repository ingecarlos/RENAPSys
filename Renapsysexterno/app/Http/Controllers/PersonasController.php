<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Session;
use Illuminate\Support\Facades\View;

class PersonasController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    public $host;

    public function __construct()
    {

    }

    public function index()
    {
        return view('personas');
    }

    public function index2()
    {
        return view('personasInfo');
    }

    public function getRequest(Request $request)
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
    
       
        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9004/getDPI',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi')                                    
                                    )                
                    	   ]
            ]);              
        
        $res = (string) $response->getBody();            
        $json = json_decode($res);

        $apellidos = $json->apellidos;  
        $nombre = $json->nombre;     
        $fechanac = $json->fechanac;
        $departamento = $json->departamento;   
        $municipio = $json->municipio;   
        $genero = $json->genero;   
        $estadocivil = $json->estadocivil;   
        return View::make('personasInfo')->with('apellidos', $apellidos)->with('nombre', $nombre)->with('fechanac', $fechanac)->with('departamento', $departamento)->with('municipio', $municipio)->with('genero', $genero)->with('estadocivil', $estadocivil);                              
    }
}
