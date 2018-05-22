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
    //return view('welcome');
    return redirect('/view/index');
});
Route::get('/test', function() {
    /*
    $n = 6887; $m=7; $key = 3721;
    $val = 1; $i = 0;
    while ($i++ < $key) {
        $val *= $m;
        $val %= $n;
    }
    return $val;
    */
    return \Illuminate\Support\Facades\Cache::rememberForever('test', function (){
        return 'abbcc';
    });
});
Route::get('/flush', function() {
    Cache::flush();
    return "flush ok";
});

Route::get('/view/show_pic', 'ViewCtrl@show_pic');
Route::get('/view/{part}', 'ViewCtrl');
Route::post('/logic/{part}', 'LogicCtrl');
Route::any('/open/{part}', 'OpenCtrl');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
