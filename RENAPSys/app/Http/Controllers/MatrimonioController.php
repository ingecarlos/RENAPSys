<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class MatrimonioController extends Controller
{
    private $host = '35.232.40.193';

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
        
        
    }
}
