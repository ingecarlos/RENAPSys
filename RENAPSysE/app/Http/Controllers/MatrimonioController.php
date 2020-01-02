<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\View;

class MatrimonioController extends Controller
{
    private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';

    public function __construct()
    {

    }

    public function index()
    {
        return view('matrimonio');
    }

    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();        
        /*
        $response = $client->request('POST', $this->host.':9001/', [
        'form_params' => [
            'dpiHombre' => $request->input('dpih'),
            'dpiMujer' => $request->input('dpim'),
            'fecha' => $request->input('fecham'),
            ]   
        ]);
        $response = $response->getBody()->getContents();
        return Redirect::to("/info")->withSuccess('Bien hecho!'); 
        echo '<pre>';
        print_r($response);
        */

        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9001/setMatrimonio',
                'tipo' => 'POST',
                'parametros' =>
                             array(
                                'dpihombre' => $request->input('dpih'),
                                'dpimujer' => $request->input('dpim'),
                                'fecha' => $request->input('fecham')
                             )
                ]   
            ]);

            $res = (string) $response->getBody();
            $json = json_decode($res); 
            $est = $json->estado;
            $msj = $json->mensaje;

            if($est=="200"){
                return Redirect::to("/matrimonio")->withSuccess('Registro almacenado.');  
            }else{
                return View::make('info')->with('est', $est)->with('msj', $msj);
            } 
        
    }
}
