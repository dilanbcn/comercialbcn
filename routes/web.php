<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('/home');
});

Auth::routes();
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@getLogout')->name('logout');
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');

Route::group(['middleware' => 'auth'], function () {
	
	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::resource('cliente', 'App\Http\Controllers\ClienteController', ['except' => ['show']]);
	Route::get('clientes-disponibles', 'App\Http\Controllers\ClienteController@prospectos')->name('cliente.prospectos');
	
	
	Route::get('cliente-proyecto/{cliente}', 'App\Http\Controllers\ProyectoController@clienteProyecto')->name('proyecto.cliente-proyecto');
	Route::resource('proyecto', 'App\Http\Controllers\ProyectoController', ['except' => ['show', 'store', 'create', 'edit']]);
	Route::post('proyecto/{cliente}', 'App\Http\Controllers\ProyectoController@store')->name('proyecto.store');
	Route::get('proyecto-factura/{proyecto}', 'App\Http\Controllers\ProyectoController@proyectoFacrtura')->name('proyecto.proyecto-factura');
	
	// Route::resource('factura', 'App\Http\Controllers\ProyectoFacturaController', ['except' => ['show', 'store', 'create', 'edit']]);
	Route::post('factura/{proyecto}', 'App\Http\Controllers\ProyectoFacturaController@store')->name('factura.store');
	Route::get('factura/{proyecto_factura}/edit', 'App\Http\Controllers\ProyectoFacturaController@edit')->name('factura.edit');
	Route::put('factura/{proyecto_factura}', 'App\Http\Controllers\ProyectoFacturaController@update')->name('factura.update');
	Route::delete('factura/{proyecto_factura}', 'App\Http\Controllers\ProyectoFacturaController@destroy')->name('factura.destroy');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});


Route::post('custom-login', 'App\Http\Controllers\Auth\CustomLoginController@login')->name('custom-login')->middleware('guest');

