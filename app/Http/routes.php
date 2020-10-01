<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

// Ruta Home
Route::get('/Home', array(
    'as' => 'home',
    'uses' => 'HomeController@index'
));

// Rutas del controlador de Videos
Route::get('/crear-video', array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));


Route::post('/guardar-video', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));



Route::get('/miniatura/{filename}', array(
    'as' => 'imageVideo', // Le especificamos el nombre que va a tener esta ruta 
    'uses' => 'VideoController@getImage' // Va a utilizar el controlador videoContorller y el método getImage 
));

