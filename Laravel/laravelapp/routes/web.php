<?php

use Illuminate\Support\Facades\Route;

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

Route::get('hello', function() {
    return '<html><body><h1>Hello</h1><p>This is sample page.</p></body></html>';
  });

Route::get('/hello/{msg}', function($msg) {
    return "{$msg}";
});

Route::get('/hello/{id}/{pass}', function($userId, $password) {
    return "{$userId}, {$password}";
});

Route::get('/hello2/{param?}', function($param = 'default') {
    return "{$param}";
});

Route::get('hello3', 'HelloController');