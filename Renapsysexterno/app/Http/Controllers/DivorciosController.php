<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Session;
use Illuminate\Support\Facades\View;

class DivorciosController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    public $host;

    public function __construct()
    {

    }

    public function index()
    {
        return view('divorcios');
    }

    public function index2()
    {
        return view('divorciosInfo');
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
                'url' => 'http://35.232.40.193:9003/getDivorcios',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi')                                    
                                    )                
                    	   ]
            ]);              
        /*
        $res =  $response->getBody();            
        $respuesta = json_decode($res, true);
        return View::make('divorciosInfo')->with('respuesta', $respuesta);
        */
        $res = (string) $response->getBody();            
        $json = json_decode($res);
        
        $numero = $json->nodivorcio;   
        $fecha = $json->fecha;  
        $dpihombre = $json->dpihombre;
        $nombrehombre = $json->nombrehombre;
        $apellidohombre = $json->apellidohombre;
        $dpimujer = $json->dpimujer;
        $nombremujer = $json->nombremujer;
        $apellidomujer = $json->apellidomujer; 
        return View::make('divorciosInfo')->with('numero', $numero)->with('fecha', $fecha)->with('dpihombre', $dpihombre)->with('nombrehombre', $nombrehombre)->with('apellidohombre', $apellidohombre)->with('dpimujer', $dpimujer)->with('nombremujer', $nombremujer)->with('apellidomujer', $apellidomujer);                                  
        

        
    }
}
