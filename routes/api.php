<?php

use Illuminate\Http\Request;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('register/verify/{confirmationCode}', 
[
    'as' => 'confirmation_path',
    'uses' => 'UserController@confirm',
]);

Route::group(['middleware' => ['jwt.verify']], function()
{
    Route::get('logout', 'UserController@logout');
    Route::get('user', 'UserController@getAuthenticatedUser');
});