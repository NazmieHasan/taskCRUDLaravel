<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', 'ArticleController@index');
Route::post('/create-article', 'ArticleController@create');
Route::get('/fetch-articles', 'ArticleController@fetchArticle');

Route::get('/edit-article/{id}', 'ArticleController@edit');
Route::post('/update-article/{id}', 'ArticleController@update');
Route::post('/delete-article/{id}', 'ArticleController@destroy');

Route::get('/custom-values-slider', 'ArticleController@customValuesSlider');
Route::get('/search', 'ArticleController@search');
