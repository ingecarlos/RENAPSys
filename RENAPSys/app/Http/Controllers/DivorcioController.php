<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class DivorcioController extends Controller
{
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
        $response = $client->request('POST', 'localhost:9003/servicio_divorcio.php', [
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
        
        
    }

}
