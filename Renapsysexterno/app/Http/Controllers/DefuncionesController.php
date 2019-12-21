<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Session;
use Illuminate\Support\Facades\View;

class DefuncionesController extends Controller
{
    public function index()
    {
        return view('defunciones');
    }

    public function index2()
    {
        return view('defuncionesInfo');
    }

    public function getRequest(Request $request)
    {

        //$client = new \GuzzleHttp\Client();
        //$request = $client->get('localhost:9002/servicio_defuncion.php');
        //$response = $request->getBody()->getContents();
       $client = new \GuzzleHttp\Client();
       /*
       $response = $client->request('GET', 'localhost:9002/servicio_defuncion.php', [
        'form_params' => [
            'dpi' => $request->input('dpih'),
            ]   
        ]);
        $response = $response->getBody()->getContents();        

        var_dump($response);
        */
        //$nombre = 'Fernando';        

        $respuesta1 = $client->request('GET','localhost:9002/servicio_defuncion.php', 
    		[
                'query' => ['dpi' => $request->input('dpi'),                    		
                    	   ]
            ])->getBody();              
        
        $respuesta = json_decode($respuesta1);                
        return View::make('defuncionesInfo')->with('respuesta', $respuesta);
        
        
    }
}
