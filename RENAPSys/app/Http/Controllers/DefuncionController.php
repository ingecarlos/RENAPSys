<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;

class DefuncionController extends Controller
{
    private $host = '35.232.40.193';

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
        
              
    }
}
