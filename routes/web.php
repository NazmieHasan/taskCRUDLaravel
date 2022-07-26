<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/articles', 'ArticleController@index');
Route::post('/articles', 'ArticleController@store');

Route::get('/', function () {
    return view('welcome');
});
