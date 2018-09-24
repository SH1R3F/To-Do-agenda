<?php
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

Route::get('/', 'TasksController@index');

Route::view('/authenticate', 'authenticate')->middleware('guest')->name('authenticate');

// Password Restoring
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Login
Route::post('/login', 'Auth\LoginController@login');
// Register
Route::post('/register', 'Auth\RegisterController@register');

// Logging in
Route::get('/home', function(){
    return 'You are logged in right now';
})->middleware('auth');

Route::post('/store', 'TasksController@store')->name('task.store');
Route::put('/update/{task}', 'TasksController@update')->name('task.update');
Route::delete('/delete/{task}', 'TasksController@destroy')->name('task.destroy');
