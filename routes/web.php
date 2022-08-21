<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/articles', 'ArticleController@index');
Route::get('/fetch-articles', 'ArticleController@fetchArticle');
Route::post('/articles', 'ArticleController@store');
Route::get('/edit-article/{id}', 'ArticleController@edit');
Route::put('/update-article/{id}', 'ArticleController@update');
Route::delete('/delete-article/{id}', 'ArticleController@destroy');
Route::get('/articles-search', 'ArticleController@searchByName');
Route::post('/articles-search', 'ArticleController@searchByName');

Route::get('/', function () {
    return view('welcome');
});
