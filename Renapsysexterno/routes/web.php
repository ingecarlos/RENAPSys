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
Route::post('/personas', 'PersonasController@getRequest')->name('personas');
Route::get('/personasInfo', 'PersonasController@index2')->name('personasInfo');

Route::get('/nacimientos', 'NacimientosController@index')->name('nacimientos');
Route::post('/nacimientos', 'NacimientosController@getRequest')->name('nacimientos');
Route::get('/nacimientosInfo', 'NacimientosController@index2')->name('nacimientosInfo');

Route::get('/matrimonios', 'MatrimoniosController@index')->name('matrimonios');
Route::post('/matrimonios', 'MatrimoniosController@getRequest')->name('matrimonios');
Route::get('/matrimoniosInfo', 'MatrimoniosController@index2')->name('matrimoniosInfo');

Route::get('/defunciones', 'DefuncionesController@index')->name('defunciones');
Route::post('/defunciones', 'DefuncionesController@getRequest')->name('defunciones');
Route::get('/defuncionesInfo', 'DefuncionesController@index2')->name('defuncionesInfo');

Route::get('/divorcios', 'DivorciosController@index')->name('divorcios');
Route::post('/divorcios', 'DivorciosController@getRequest')->name('divorcios');
Route::get('/divorciosInfo', 'DivorciosController@index2')->name('divorciosInfo');

Route::get('/licencias', 'LicenciasController@index')->name('licencias');
Route::post('/licencias', 'LicenciasController@getRequest')->name('licencias');
Route::get('/licenciasInfo', 'LicenciasController@index2')->name('licenciasInfo');
