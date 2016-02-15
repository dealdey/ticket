<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'WelcomeController@index');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/support', 'HomeController@index');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/support', 'HomeController@index');
});

Route::get('/password/change', ['as' => 'password.change.get', 'uses' => 'Auth\PasswordController@showPasswordForm'], function(){
    if(!(Auth::user()->hasRole('super-admin'))){
        session()->flash('notification', 'You have no permission to perform this task');
        session()->flash('notification-type', 'alert-warning');
        session()->flash('notification-important', true);
        return redirect()->route('tickets.index');
    }
});

Route::post('/password/change', ['as' => 'password.change.post', 'uses' => 'Auth\PasswordController@changePassword'], function(){
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/register', ['uses' => 'Auth\AuthController@showRegistrationForm', 'as' => 'register.get']);
    Route::post('/register', ['uses' => 'Auth\AuthController@register', 'as' => 'register.post']);
});