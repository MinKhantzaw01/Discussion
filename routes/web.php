<?php

use Illuminate\Support\Facades\Route;

Route::get('/',"PageController@index");
Route::get('/article/{slug}','PageController@detail');

Route::get('/language/{slug}','PageController@articleByLanguage');
Route::get('/category/{slug}','PageController@articleByCategory');


Route::get('/login',"AuthController@showLogin");
Route::post('/login',"AuthController@postLogin")->name('post');
Route::get('/register',"AuthController@showRegister");
Route::post('/register',"AuthController@postRegister")->name('register');
Route::get('/logout',"AuthController@logout");


Route::get('/create-article','PageController@createArticle');
Route::post('/create-article','PageController@postArticle')->name('create-article');


Route::get('/article/like/{id}','PageController@createLike');
Route::post('/comment/create','PageController@createComment');
