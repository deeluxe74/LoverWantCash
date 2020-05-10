<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signUp', 'UserController@signUp');
Route::post('/login', 'UserController@login');
Route::post('/get', 'UserController@get');

Route::post('/profil/sendLove', 'UserController@sendLove');

Route::post('/newNote', 'NoteController@new');
Route::post('/getNote', 'NoteController@get');
Route::post('/deleteNote', 'NoteController@deleteNote');

Route::post('/profil/loverDelete', 'CoupleController@loverDelete');
Route::post('/Statistic', 'CoupleController@Statistic');