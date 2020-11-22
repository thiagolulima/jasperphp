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
Use App\Cadastro;

Route::get('/', function () {
    return view('welcome');
});

Route::get('cadastros',function(){

     $cadastros = Cadastro::all();

     foreach($cadastros as $cadastro)
     {
         echo $cadastro->NmPessoa . '<br>';
     }

});

Route::get('report' , 'ControllerReport@generateReport' )->name('report');

Route::get('parametros' , 'ControllerReport@getParametros') ->name('parametros');
