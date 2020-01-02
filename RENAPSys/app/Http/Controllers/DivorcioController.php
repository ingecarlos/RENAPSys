<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\View;

class DivorcioController extends Controller
{
    //private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';
    private $host;

    public function __construct()
    {

    }

    public function index()
    {
        return view('divorcio');
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
        $response = $client->request('POST',  $this->host.':9003/', [
        'form_params' => [
            'dpiEsposo' => $request->input('dpih'),
            'dpiEsposa' => $request->input('dpim'),
            'fecha' => $request->input('fecham'),
            ]   
        ]);
        $response = $response->getBody()->getContents();  
        //$response2 = json_decode($response->getBody())
        echo '<pre>';        
        print_r($response);        
        //print_r($response2);        
        return Redirect::to("/info")->withSuccess('bien hecho!');    
        */
        
        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9003/setDivorcio',
                'tipo' => 'POST',
                'parametros' =>
                             array(
                                'dpiesposo' => $request->input('dpih'),
                                'dpiesposa' => $request->input('dpim'),
                                'fecha' => $request->input('fecham')  
                             )
                ]
            ]);

            $res = (string) $response->getBody();
            $json = json_decode($res); 
            $est = $json->estado;
            $msj = $json->mensaje;

            if($est=="200"){
                return Redirect::to("/divorcio")->withSuccess('Registro almacenado.');  
            }else{
                return View::make('info')->with('est', $est)->with('msj', $msj);
            } 
        
        
    }

}
