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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function() {
    \App\User::find(2)->update(['info'=>'abc', 'name'=>'vb love guang']);
});
Route::get('/view/{part}', 'ViewCtrl');
Route::post('/logic/{part}', 'LogicCtrl');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
