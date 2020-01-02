<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Session;
use Illuminate\Support\Facades\View;

class MatrimoniosController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    public $host;

    public function __construct()
    {

    }

    public function index()
    {
        return view('matrimonios');
    }

    public function index2()
    {
        return view('matrimoniosInfo');
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
                'url' => 'http://35.232.40.193:9001/getMatrimonio',
                'tipo' => 'POST',
                'parametros' =>
                             array('dpi' => $request->input('dpi')                                    
                                    )                
                    	   ]
            ]);              
        
            /*
        $res = $response->getBody();      
        $respuesta = json_decode($res, true);
        return View::make('matrimoniosInfo')->with('respuesta', $respuesta);
        */
        
        $res = (string) $response->getBody();     
        $json = json_decode($res);
        $numero = $json->nomatrimonio;            
        $dpihombre = $json->dpihombre;
        $nombrehombre = $json->nombrehombre;
        $apellidohombre = $json->apellidohombre;
        $dpimujer = $json->dpimujer;
        $nombremujer = $json->nombremujer;
        $apellidomujer = $json->apellidomujer; 
        $fecha = $json->fecha; 
        return View::make('matrimoniosInfo')->with('numero', $numero)->with('fecha', $fecha)->with('dpihombre', $dpihombre)->with('nombrehombre', $nombrehombre)->with('apellidohombre', $apellidohombre)->with('dpimujer', $dpimujer)->with('nombremujer', $nombremujer)->with('apellidomujer', $apellidomujer);                                  
        
        /*
        $res = (string) $response->getBody(); 
        var_dump($res);
        print_r($res);
        return View::make('matrimoniosInfo');
        */

    }
}
