<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return "<h1>VASCO MAIOR QUE O FOGUINHO </h1>";
});

Route::resource('/eixo', 'App\Http\Controllers\EixoController');
route::resource('/aluno', 'App\Http\Controllers\AlunoController');
