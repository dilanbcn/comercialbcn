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
	$user = auth()->user();
	if ($user){
		$ruta = ($user->rol_id == 4 || $user->rol_id == 5) ? '/home-prospector' : '/home-comercial';
	} else {
		$ruta = '/login';
	}
	return redirect($ruta);
})->name('principal');

Auth::routes();
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@getLogout')->name('logout');
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');

Route::group(['middleware' => 'auth'], function () {

	Route::get('/home-prospector', 'App\Http\Controllers\HomeController@indexProspector')->name('home.prospector');
	Route::get('/home-comercial', 'App\Http\Controllers\HomeController@indexComercial')->name('home.comercial');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::post('user-password', 'App\Http\Controllers\UserController@renew')->name('usuario.contrasena');
	Route::get('grafico', 'App\Http\Controllers\UserController@grafico')->name('user.grafico');
	
	Route::get('comercial-indicadores', 'App\Http\Controllers\ComercialController@index')->name('comercial.indicadores');

	Route::resource('cliente', 'App\Http\Controllers\ClienteController');
	Route::get('cliente-comercial/{comercial_id?}', 'App\Http\Controllers\ClienteController@index')->name('cliente.comercial');
	Route::get('clientes-disponibles', 'App\Http\Controllers\ClienteController@prospectos')->name('cliente.prospectos');
	Route::get('clientes-disponibles-json', 'App\Http\Controllers\ClienteController@prospectosJSON')->name('cliente.prospectos.json');
	Route::get('clientes-vigencia', 'App\Http\Controllers\ClienteController@vigencia')->name('cliente.vigencia');
	Route::get('clientes-vigencia-json', 'App\Http\Controllers\ClienteController@vigenciaJSON')->name('cliente.vigencia.json');
	Route::get('clientes-vigencia-actividad/{cliente}', 'App\Http\Controllers\ClienteController@vigenciaActividad')->name('cliente.vigencia.actividad');
	Route::get('clientes-cerrados', 'App\Http\Controllers\ClienteController@cerrados')->name('cliente.cerrados');
	Route::get('clientes-cerrados-json', 'App\Http\Controllers\ClienteController@cerradosJSON')->name('cliente.cerrados.json');
	Route::get('clientes-all', 'App\Http\Controllers\ClienteController@allClientes')->name('cliente.all');
	Route::post('clientes-json', 'App\Http\Controllers\ClienteController@clientesJSON')->name('clientes.json');
	Route::post('clientes-discard/{cliente}', 'App\Http\Controllers\ClienteController@discard')->name('cliente.discard');
	Route::post('clientes-inicio-relacion/{cliente}', 'App\Http\Controllers\ClienteController@updateInicioRelacion')->name('cliente.inicio-relacion');

	Route::resource('cliente-contacto', 'App\Http\Controllers\ClienteContactoController', ['except' => ['index', 'show', 'store', 'create']]);
	Route::get('cliente-contacto/{cliente}', 'App\Http\Controllers\ClienteContactoController@index')->name('cliente-contacto.index');
	Route::get('cliente-contacto-json/{cliente}', 'App\Http\Controllers\ClienteContactoController@json')->name('cliente-contacto.json');
	Route::get('cliente-contacto/{cliente}/create', 'App\Http\Controllers\ClienteContactoController@create')->name('cliente-contacto.create');
	Route::post('cliente-contacto/{cliente}', 'App\Http\Controllers\ClienteContactoController@store')->name('cliente-contacto.store');

	Route::get('cliente-proyecto/{cliente}', 'App\Http\Controllers\ProyectoController@clienteProyecto')->name('proyecto.cliente-proyecto');
	Route::post('proyectos-json', 'App\Http\Controllers\ProyectoController@proyectosJson')->name('proyectos.json');
	Route::resource('proyecto', 'App\Http\Controllers\ProyectoController', ['except' => ['show', 'store', 'create']]);
	Route::post('proyecto/{cliente}', 'App\Http\Controllers\ProyectoController@store')->name('proyecto.store');

	Route::resource('prospeccion', 'App\Http\Controllers\ProspeccionController', ['except' => ['show']]);
	Route::get('prospeccion-contactos', 'App\Http\Controllers\ProspeccionController@contactos')->name('prospeccion.contactos');
	Route::post('prospeccion-contactos', 'App\Http\Controllers\ProspeccionController@contactoStore')->name('prospeccion.contactos.store');
	Route::get('prospeccion-contactos/{cliente_contacto}/edit', 'App\Http\Controllers\ProspeccionController@contactoEdit')->name('prospeccion.contactos.edit');
	Route::put('prospeccion-contactos/{cliente_contacto}', 'App\Http\Controllers\ProspeccionController@contactoUpdate')->name('prospeccion.contactos.update');
	Route::get('prospeccion-indicadores', 'App\Http\Controllers\ProspeccionController@indicadores')->name('prospeccion.indicadores');
	Route::post('prospeccion-indicadores', 'App\Http\Controllers\ProspeccionController@indicadores')->name('prospeccion.indicadores');

	Route::get('prospeccion-asignacion', 'App\Http\Controllers\ProspeccionController@index')->name('prospeccion.asignacion.index');
	Route::post('prospeccion-asignacion', 'App\Http\Controllers\ProspeccionController@store')->name('prospeccion.asignacion.store');

	Route::resource('cliente-comunicacion', 'App\Http\Controllers\ClienteComunicacionController', ['except' => ['show']]);
	Route::get('cliente-comunicacion-json', 'App\Http\Controllers\ClienteComunicacionController@indexJson')->name('cliente-comunicacion.json');
	Route::get('cliente-comunicacion/reuniones', 'App\Http\Controllers\ClienteComunicacionController@reuniones')->name('cliente-comunicacion.reuniones');
	Route::get('cliente-comunicacion/resumen', 'App\Http\Controllers\ClienteComunicacionController@resumen')->name('cliente-comunicacion.resumen');
	Route::get('conversación/{cliente}', 'App\Http\Controllers\ClienteComunicacionController@conversacion')->name('cliente-comunicacion.conversacion');
	Route::post('valida-reunion/{cliente_comunicacion}', 'App\Http\Controllers\ClienteComunicacionController@validar')->name('cliente-comunicacion.validar');
	Route::get('calendario', 'App\Http\Controllers\ClienteComunicacionController@calendario')->name('cliente-comunicacion.calendario');
	Route::post('calendario', 'App\Http\Controllers\ClienteComunicacionController@calendarioStore')->name('cliente-calendario.store');
	Route::put('calendario-update/{cliente-comunicacion}', 'App\Http\Controllers\ClienteComunicacionController@calendarioUpdate')->name('cliente-calendario.update');

	// Route::get('proyecto-factura/{proyecto}', 'App\Http\Controllers\ProyectoFacturaController@proyectoFactura')->name('factura.proyecto-factura');
	Route::post('factura/{proyecto}', 'App\Http\Controllers\ProyectoFacturaController@store')->name('factura.store');
	Route::get('factura/{proyecto_factura}/edit', 'App\Http\Controllers\ProyectoFacturaController@edit')->name('factura.edit');
	Route::put('factura/{proyecto_factura}', 'App\Http\Controllers\ProyectoFacturaController@update')->name('factura.update');
	Route::delete('factura/{proyecto_factura}', 'App\Http\Controllers\ProyectoFacturaController@destroy')->name('factura.destroy');

	Route::resource('producto', 'App\Http\Controllers\ProductoController', ['except' => ['show', 'edit', 'create', 'update']]);
	
	Route::resource('notificacion', 'App\Http\Controllers\NotificacionController', ['except' => ['show', 'edit', 'create', 'update']]);
	Route::get('notificaciones-json', 'App\Http\Controllers\NotificacionController@indexJSON')->name('notificaciones.json');
	Route::get('notificaciones-push', 'App\Http\Controllers\NotificacionController@pushJSON')->name('notificaciones.push');
	Route::get('notificaciones-recientes', 'App\Http\Controllers\NotificacionController@recientesJSON')->name('notificaciones.recientes');
	Route::post('notificaciones-marcar', 'App\Http\Controllers\NotificacionController@marcar')->name('notificaciones.marcar');
	Route::post('notificaciones-comerciales/{cliente}/{user}', 'App\Http\Controllers\NotificacionController@notificacionComercial')->name('notificaciones.comerciales');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::get('reportes/{tipo}', 'App\Http\Controllers\ClienteController@reportes')->name('cliente.reportes');
});

Route::post('custom-login', 'App\Http\Controllers\Auth\CustomLoginController@login')->name('custom-login')->middleware('guest');
