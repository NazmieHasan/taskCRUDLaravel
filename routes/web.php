<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/articles', 'ArticleController@index');
Route::get('/fetch-articles', 'ArticleController@fetchArticle');
Route::post('/articles', 'ArticleController@store');
Route::get('/edit-article/{id}', 'ArticleController@edit');
Route::post('/update-article/{id}', 'ArticleController@update');
Route::post('/delete-article/{id}', 'ArticleController@destroy');
Route::get('/articles-search', 'ArticleController@searchByNameAndPrice');
Route::post('/articles-search', 'ArticleController@searchByNameAndPrice');
Route::get('/search', 'ArticleController@search');
Route::get('/add-articles','ArticleController@create');
Route::post('/store-articles','ArticleController@storenew');

Route::get('/', function () {
    return view('welcome');
});
