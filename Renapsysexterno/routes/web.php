<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/personas', 'PersonasController@index')->name('personas');
Route::post('/personas', 'PersonasController@store')->name('personas');
Route::get('/personasInfo', 'PersonasController@info')->name('personasInfo');

Route::get('/nacimientos', 'NacimientosController@index')->name('nacimiento');
Route::get('/nacimientosInfo', 'NacimientosInfoController@info')->name('InfoNacimiento');

Route::get('/matrimonios', 'MatrimoniosController@index')->name('matrimonio');
Route::post('/matrimoniosInfo', 'MatrimoniosController@info')->name('InfoMatrimonio');

Route::get('/defunciones', 'DefuncionesController@index')->name('defuncion');
Route::post('/defuncionesInfo', 'DefuncionesInfoController@info')->name('InfoDefuncion');

Route::get('/divorcios', 'DivorciosController@index')->name('divorcio');
Route::post('/divorciosInfo', 'DivorciosInfoController@info')->name('InfoDivorcio');
