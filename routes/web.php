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

// pacientes
Route::get('/pacientes','PadronController@buscar');
Route::get('/pacientes/traer/{texto}','PadronController@traer');

Route::post('/padron/buscar','PadronController@index');
Route::get('/padron/ver/{id}','PadronController@show');
Route::get('/padron/cumples','PadronController@cumples');
Route::post('/padron/cumples','PadronController@cumples_listar');
Route::get('/pacientes/nuevo','PadronController@create');
Route::get('/padron/nuevo','PadronController@create');
Route::post('/padron/nuevo','PadronController@store');
Route::post('/padron/nuevo2','PadronController@store2');
Route::post('/padron/nuevo3','PadronController@store3');
Route::get('/padron/editar/{id}','PadronController@edit');
Route::post('/padron/editar','PadronController@update');
Route::get('/padron/editar2/{id}','PadronController@edit2');
Route::post('/padron/editar2','PadronController@update2');
Route::get('/padron/editar3/{id}','PadronController@edit3');
Route::post('/padron/editar3','PadronController@update3');
Route::get('/padron/turnos/{id}','TurnosController@porpaciente');

Route::get('/padron/porcuil/{cuil}','PadronController@porcuil');
Route::get('/padron/pordocumento/{documento}','PadronController@pordocumento');
Route::get('/padron/porid/{id}','PadronController@porid');

// calendario
Route::get('/calendario','FechasController@edit');
Route::post('/calendario','FechasController@show');
Route::get('/calendario/bloquear/{id}','FechasController@bloquear');
Route::post('/calendario/bloquear','FechasController@bloquear_do');
Route::get('/calendario/liberar/{id}','FechasController@liberar');
Route::get('/calendario/generar','FechasController@generar');

// mensajes
Route::get('/mensaje/enviar/{numero}/{texto}','HomeController@enviar');
// pago
Route::get('/pago','TurnosController@pagorapido');

// procesos
Route::get('/recordatorio','ProcesosController@recordatorio');
Route::get('/recordatorio/finalizar/{fecha}','ProcesosController@recordatorio_finalizar');
Route::get('/recordatoriomail/{id}','ProcesosController@recordatorio_mail');

// turnos
Route::get('/turnos/actual','TurnosController@actual');
Route::get('/turnos/asignar/{id}/{paciente}','TurnosController@asignar');
Route::post('/turnos/asignar','TurnosController@update');
Route::get('/turnos/asistencia/{id}','TurnosController@asistencia');
Route::get('/turnos/asistencia2/{id}','TurnosController@asistencia2');
Route::get('/turnos/bloquear/{id}','TurnosController@bloquear');
Route::post('/turnos/bloquear','TurnosController@bloquear_do');
Route::get('/turnos/buscapagos/{texto}','TurnosController@buscapagos');
Route::get('/turnos/cancelar/{id}','TurnosController@cancelar');
Route::post('/turnos/cancelar','TurnosController@cancelar_do');
Route::get('/turnos/consultar/{id}','TurnosController@index');
Route::get('/turnos/disponibles','TurnosController@disponibles');
Route::post('/turnos/disponibles','TurnosController@disponibles_do');
Route::get('/turnos/escancelacion/{turno}/{cancelacion}','TurnosController@escancelacion');
Route::post('/turnos/escancelacion','TurnosController@escancelacion_do');
Route::get('/turnos/generar','TurnosController@create');
Route::post('/turnos/generar','TurnosController@store');
Route::get('/turnos/impagos','TurnosController@impagos_get');
Route::post('/turnos/impagos','TurnosController@impagos_post');

Route::get('/turnos/liberar/{id}','TurnosController@liberar');
Route::get('/turnos/notifica/{id}','TurnosController@notificar');
Route::get('/turnos/preasignar/{id}','TurnosController@preasignar');
Route::get('/turnos/repaso','TurnosController@repaso_get');
Route::post('/turnos/repaso','TurnosController@repaso_post');
Route::get('/turnos/repaso/{id}','TurnosController@repaso');
Route::get('/turnos/pago/{id}','TurnosController@pago');
Route::get('/turnos/pago2/{id}','TurnosController@pago2');
Route::get('/turnos/pago3/{id}','TurnosController@pago3');
Route::get('/turnos/pago4/{id}','TurnosController@pago4');
Route::get('/turnos/eliminar','TurnosController@eliminar');
Route::post('/turnos/eliminar','TurnosController@eliminar_masivo');

// provincias
Route::get('/provincias/','ProvinciasController@index');
Route::get('/provincias/nueva','ProvinciasController@create');
Route::post('/provincias/nueva','ProvinciasController@store');
Route::get('/provincias/editar/{id}','ProvinciasController@edit');
Route::post('/provincias/editar','ProvinciasController@update');
Route::get('/provincias/eliminar/{id}','ProvinciasController@show');
Route::post('/provincias/eliminar','ProvinciasController@destroy');

// usuarios
Route::get('/usuarios/','UserController@index');
Route::get('/usuarios/eliminar/{id}','UserController@eliminar');
Route::post('/usuarios/eliminar_do/','UserController@destroy');
Route::get('/usuarios/editar/{id}','UserController@edit');
Route::post('/usuarios/editar_do/','UserController@update');
Route::get('/usuarios/efectores/{usuario}','UserEfecController@create');
Route::get('/usuarios/asignar/{usuario}/{estructura}','UserEfecController@asignar');
Route::get('/usuarios/desasignar/{id}','UserEfecController@destroy');

Route::get('/usuarios/select','UserController@show');
Route::get('/usuarios/tipo','UserController@tipodeusuario');

// localidades
Route::get('/localidades','LocalidadesController@index');
Route::post('/localidades/buscar','LocalidadesController@buscar');
Route::get('/localidades/editar/{id}','LocalidadesController@edit');
Route::post('/localidades/editar','LocalidadesController@update');
Route::get('/localidades/eliminar/{id}','LocalidadesController@show');
Route::post('/localidades/eliminar','LocalidadesController@destroy');
Route::get('/localidades/nueva','LocalidadesController@create');
Route::post('/localidades/nueva','LocalidadesController@store');

Route::get('/localidades/opciones/{id}','LocalidadesController@opciones');
// tablas
Route::get('/tablas/opciones/{tipo}','TablasController@opciones');
Route::get('/tablas/descripcion/{tipo}/{valor}','TablasController@descripcion');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/mantenimiento', 'HomeController@index_mantenimiento')->name('mantenimiento');
Route::get('/reportes', 'HomeController@index_reportes')->name('reportes');
Route::get('/reportes/cumples', 'HomeController@cumples');
Route::post('/reportes/cumples','HomeController@cumples_do');
Route::get('/reportes/asistencia/general', 'HomeController@asistencia');
Route::post('/reportes/asistencia', 'HomeController@asistencia_do');
Route::get('/reportes/asistencia/cmmatanza', 'HomeController@asistencia_matanza');
Route::get('/reportes/asistencia/discapacidad', 'HomeController@asistencia_discapacidad');
Route::get('/reportes/asistencia/particular', 'HomeController@asistencia_particular');
Route::get('/reportes/cancelaciones', 'HomeController@cancelaciones');
Route::post('/reportes/cancelaciones', 'HomeController@cancelaciones_do');

// Exportaciones Excel 

use App\Exports\PadronExport;
use App\Exports\InformesExport;

use Maatwebsite\Excel\Facades\Excel;

Route::get('/pacientes/exportar',function(){
	$objeto=new PadronExport;
	return Excel::download($objeto,'pacientes.xlsx');
}); 

Route::get('/padron/informe/{id}',function($id){
	$objeto=new InformesExport;
	$objeto->set_paciente($id);
	return Excel::download($objeto,'informe.xlsx');
});


// Clear
//Clase Config
Route::get('/clearall','ConfigController@clearAll');
Route::get('/cacheall','ConfigController@cacheAll');

//Otras
Route::get('/clearcache',function(){ $exitCode = Artisan::call('cache:clear'); return $exitCode;});
Route::get('/clearvistas',function(){ $exitCode = Artisan::call('view:clear'); return $exitCode;});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
