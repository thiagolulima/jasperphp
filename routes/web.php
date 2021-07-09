<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('report' , 'ControllerReport@generateReport' )->name('report');

Route::get('parametros' , 'ControllerReport@getParametros') ->name('parametros');
