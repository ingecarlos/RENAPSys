<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class DefuncionController extends Controller
{
    private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';

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
                'url' => '/setDefuncion',
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
            $dp = $json->estado;
            $dp2 = $json->mensaje;

            if($dp=="200"){
                return Redirect::to("/defuncion")->withSuccess('Registro almacenado.');  
            }else{
                return Redirect::to("/info")->withSuccess($dp2);  
            }                     
    }
}
