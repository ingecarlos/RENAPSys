<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Session;
use Illuminate\Support\Facades\View;

class LicenciasController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    public $host;

    public function __construct()
    {

    }

    public function index()
    {
        return view('licencias');
    }

    public function index2()
    {
        return view('licenciasInfo');
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
                'url' => 'http://35.232.40.193:9005/getLicencia',
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
        $tipo = $json->tipo;            
        $fechanac = $json->fechanac;  
        $anosantiguedad = $json->anosantiguedad;                   
        
        return View::make('licenciasInfo')->with('apellidos', $apellidos)->with('nombre', $nombre)->with('tipo', $tipo)->with('fechanac', $fechanac)->with('anosantiguedad', $anosantiguedad);                              
    }
}
