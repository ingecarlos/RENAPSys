<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Facades\View;

class DpiController extends Controller
{
    private $host = 'http://35.232.40.193:10000/post/comunicacionesb/';

    public function __construct()
    {

    }

    public function index()
    {
        return view('dpi');
    }

    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();        
        $response = $client->request('POST', $this->host, [
            'json' => [
                'url' => 'http://35.232.40.193:9004/setDPI',
                'tipo' => 'POST',
                'parametros' =>
                             array('numeroacta' => $request->input('numeroacta')                                    
                                    )
                ]
            ]);
            $res = (string) $response->getBody();
            $json = json_decode($res); 
            $est = $json->estado;
            $msj = $json->mensaje;

            if($est=="200"){
                return Redirect::to("/dpi")->withSuccess('Registro almacenado.');  
            }else{
                return View::make('info')->with('est', $est)->with('msj', $msj);
            }                      
    }
}
