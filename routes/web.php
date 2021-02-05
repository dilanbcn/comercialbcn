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
})->name('principal');

Auth::routes();
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@getLogout')->name('logout');
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');

Route::group(['middleware' => 'auth'], function () {
	
	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('grafico', 'App\Http\Controllers\UserController@grafico')->name('user.grafico');
	
	Route::resource('cliente', 'App\Http\Controllers\ClienteController', ['except' => ['show']]);
	Route::get('clientes-disponibles', 'App\Http\Controllers\ClienteController@prospectos')->name('cliente.prospectos');
	
	Route::resource('cliente-contacto', 'App\Http\Controllers\ClienteContactoController', ['except' => ['index', 'show', 'store', 'create']]);
	Route::get('cliente-contacto/{cliente}', 'App\Http\Controllers\ClienteContactoController@index')->name('cliente-contacto.index');
	Route::get('cliente-contacto/{cliente}/create', 'App\Http\Controllers\ClienteContactoController@create')->name('cliente-contacto.create');
	Route::post('cliente-contacto/{cliente}', 'App\Http\Controllers\ClienteContactoController@store')->name('cliente-contacto.store');
	
	Route::get('cliente-proyecto/{cliente}', 'App\Http\Controllers\ProyectoController@clienteProyecto')->name('proyecto.cliente-proyecto');
	Route::resource('proyecto', 'App\Http\Controllers\ProyectoController', ['except' => ['show', 'store', 'create']]);
	Route::post('proyecto/{cliente}', 'App\Http\Controllers\ProyectoController@store')->name('proyecto.store');
	
	Route::resource('prospeccion', 'App\Http\Controllers\ProspeccionController', ['except' => ['show']]);
	Route::get('prospeccion-contactos', 'App\Http\Controllers\ProspeccionController@contactos')->name('prospeccion.contactos');
	Route::post('prospeccion-contactos', 'App\Http\Controllers\ProspeccionController@contactoStore')->name('prospeccion.contactos.store');
	Route::get('prospeccion-contactos/{cliente_contacto}/edit', 'App\Http\Controllers\ProspeccionController@contactoEdit')->name('prospeccion.contactos.edit');
	Route::put('prospeccion-contactos/{cliente_contacto}', 'App\Http\Controllers\ProspeccionController@contactoUpdate')->name('prospeccion.contactos.update');
	
	Route::get('prospeccion-asignacion', 'App\Http\Controllers\ProspeccionController@index')->name('prospeccion.asignacion.index');
	Route::post('prospeccion-asignacion', 'App\Http\Controllers\ProspeccionController@store')->name('prospeccion.asignacion.store');
	
	Route::resource('cliente-comunicacion', 'App\Http\Controllers\ClienteComunicacionController', ['except' => ['show']]);
	Route::get('cliente-comunicacion/reuniones', 'App\Http\Controllers\ClienteComunicacionController@reuniones')->name('cliente-comunicacion.reuniones');
	Route::get('conversación/{cliente}', 'App\Http\Controllers\ClienteComunicacionController@conversacion')->name('cliente-comunicacion.conversacion');
	Route::post('valida-reunion/{cliente_comunicacion}', 'App\Http\Controllers\ClienteComunicacionController@validar')->name('cliente-comunicacion.validar');
	Route::get('calendario', 'App\Http\Controllers\ClienteComunicacionController@calendario')->name('cliente-comunicacion.calendario');
	Route::post('calendario', 'App\Http\Controllers\ClienteComunicacionController@calendarioStore')->name('cliente-calendario.store');
	Route::put('calendario-update/{cliente-comunicacion}', 'App\Http\Controllers\ClienteComunicacionController@calendarioUpdate')->name('cliente-calendario.update');
	
	Route::get('proyecto-factura/{proyecto}', 'App\Http\Controllers\ProyectoFacturaController@proyectoFactura')->name('factura.proyecto-factura');
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

