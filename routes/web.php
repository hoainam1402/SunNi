<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/home', function () {
    return redirect('/admin');
});

Route::group(['prefix' => 'admin'], function () {
    App::setLocale('vi');
    Auth::routes();
});

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin', 'name' => 'admin.'],
    function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');


        //user
        Route::get('user/data', 'UserController@data')->name('user.data');
        Route::resource('user', 'UserController');
        //category
        Route::get('category/data', 'CategoryController@data')->name('category.data');
        Route::resource('category', 'CategoryController');
        //product
        Route::get('product/data', 'ProductController@data')->name('product.data');
        Route::resource('product', 'ProductController');
    });
