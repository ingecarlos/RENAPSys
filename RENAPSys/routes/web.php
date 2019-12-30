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
Route::get('/info', 'InfoController@index')->name('info');

Route::get('/nacimiento', 'NacimientoController@index')->name('nacimiento');
Route::post('/nacimiento', 'NacimientoController@store')->name('nacimiento');

Route::get('/matrimonio', 'MatrimonioController@index')->name('matrimonio');
Route::post('/matrimonio', 'MatrimonioController@store')->name('matrimonio');

Route::get('/defuncion', 'DefuncionController@index')->name('defuncion');
Route::post('/defuncion', 'DefuncionController@store')->name('defuncion');

Route::get('/divorcio', 'DivorcioController@index')->name('divorcio');
Route::post('/divorcio', 'DivorcioController@store')->name('divorcio');

Route::get('/dpi', 'DpiController@index')->name('dpi');

Route::get('/licencia', 'LicenciaController@index')->name('licencia');
Route::post('/licencia', 'LicenciaController@store')->name('licencia');

