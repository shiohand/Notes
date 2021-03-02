<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\HelloController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('hello/view', [HelloController::class, 'view']);
Route::get('hello/list', [HelloController::class, 'list']);

Route::get('view', [ViewController::class, 'master']);