<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CodigoContableController;
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


/* Route::get('/register', [RegisterController::class, 'show']);
Route::post('/action-register', [RegisterController::class, 'register']); */


Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    //
    Route::get('/', 'LoginController@show')->name('login.show');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/login', 'LoginController@show')->name('login.show');
    Route::post('/login', 'LoginController@login')->name('login.perform');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        

        Route::get('/actuales/actualver/{id}', 'ActualController@verinvitado')->name('actuales.actualver');

    });
    Route::group(['middleware' => ['auth']], function() {
    
        /**
         * Logout Routes
         */
        
        Route::get('/home', 'HomeController@index')->name('home.index');
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        //Route::get('/codcont', 'CodigoContableController@index')->name('codconts');
        //Route::post('/auxiliar', 'CodigoContableController@auxiliar')->name('auxiliar');
        //Route::get('/codcont/crear', 'CodigoContableController@create')->name('codconts.crear');
        //Route::get('/codcont/actualizar', 'CodigoContableController@actualizar')->name('actualizar');
        //Route::post('/codcont/crear', [CodigoContableController::class, 'store']);
        //Route::get('/codcont/eliminar/{id}', [CodigoContableController::class, 'destroy']);
        
        Route::get('/unidad', 'UnidadadminController@index')->name('unidad');
        Route::get('/unidad/select','UnidadadminController@selectUnidad');
        Route::put('/unidad/actualizar', 'UnidadadminController@update');
  
        
        //Route::post('/cambiarunidad', 'UnidadadminController@updateunidad')->name('cambiarunidad');

        Route::get('/oficinas', 'OficinasController@index')->name('oficinas');
        Route::post('/oficinas/registrar', 'OficinasController@store');
        Route::put('/oficinas/actualizar', 'OficinasController@update');
        Route::put('/oficinas/activar', 'OficinasController@activar');
        Route::put('/oficinas/desactivar', 'OficinasController@desactivar');
        Route::get('/oficinas/buscarOficina', 'OficinasController@buscarOficina');
        Route::get('/oficinas/datos','OficinasController@actualizarDatos');
        //Route::post('/responsables', 'OficinasController@responsables')->name('responsables');

        Route::get('/actuales', 'ActualController@index')->name('actuales');
        Route::get('/actuales/datos', 'ActualController@actualizarDatos')->name('actuales.datos');
        Route::get('/actuales/ver/{id}', 'ActualController@show')->name('actuales.ver');
        Route::put('/actual/actualizar', 'ActualController@update')->name('actual.actualizar');
        Route::get('/actuales/imprimir/{id}', 'ActualController@imprimir')->name('print');
        Route::get('/actuales/buscarActivos', 'ActualController@buscarActivos');
        Route::get('/actuales/repactivos', 'ActualController@reporteActivos');
        Route::get('/actuales/buscarActivoResp', 'ActualController@buscarActivoResp');
        Route::get('/actuales/buscarRespxcodigo', 'ActualController@buscarRespxcodigo');
        Route::put('/actual/actualizarResponsable', 'ActualController@updateResponasable');
        Route::put('/actual/actualizarasingacion', 'ActualController@updateAsignacion');
        Route::get('/actual/repAsignaciones', 'ActualController@repAsignaciones');
        Route::get('/actual/repDevoluciones', 'ActualController@repDevoluciones');
        Route::get('/actuales/inventario', 'ActualController@buscarActivoEstado');
        Route::get('/actuales/gcontable','ActualController@gcontable');
        Route::get('/actuales/auxiliar', 'ActualController@auxiliar');
        Route::get('/actuales/responsable','ActualController@responsable');

        Route::get('/bajas', 'BajasController@index')->name('bajas');
        Route::get('/bajas/auxiliar', 'BajasController@auxiliar');
        
        //Route::name('print')->get('/imprimir', 'ActualController@imprimir');
        Route::post('/image/crear', 'ImageController@create')->name('image.crear');
        Route::get('/image/ver/{id}', 'ImageController@show')->name('image.ver');

        Route::get('/escritorio', 'EscritorioController@index')->name('escritorio');
        Route::get('/escritorio/grafica1', 'EscritorioController@grafica1');
        Route::get('/escritorio/grafica2', 'EscritorioController@grafica2');

        Route::get('/responsable', 'ResponsablesController@index');
        Route::post('/responsable/registrar', 'ResponsablesController@store');
        Route::get('/responsable/datos', 'ResponsablesController@actualizarDatos')->name('responsable.datos');
        Route::get('/responsable/buscarResponsable', 'ResponsablesController@buscarResponsable');
        Route::get('/responsable/buscar', 'ResponsablesController@buscarRespActivo');
        Route::put('/responsable/actualizar', 'ResponsablesController@update');
        Route::put('/responsable/eliminar', 'ResponsablesController@delete');
        Route::get('/responsable/repResponsables', 'ResponsablesController@repResponsables');
        Route::get('/responsable/listar','ResponsablesController@listarporOficina');


        Route::get('/contable', 'CodigoContableController@index');
        Route::get('/contable/datos', 'CodigoContableController@actualizarDatos')->name('contable.datos');
        Route::put('/contable/actualizar', 'CodigoContableController@update');

        Route::get('/auxiliar', 'AuxiliaresController@index');
        Route::get('/auxiliar/{id}', 'AuxiliaresController@selectAuxiliar');
        Route::get('/auxiliar/datos', 'AuxiliaresController@actualizarDatos');
        Route::put('/auxiliar/update', 'AuxiliaresController@update');

        Route::get('/rol', 'RolesController@index');
        Route::get('/rol/selectRol', 'RolesController@selectRol');

        Route::get('/users', 'UsersController@index');
        Route::post('/user/registrar', 'UsersController@store');
        Route::put('/user/actualizar', 'UsersController@update');
        Route::put('/user/desactivar', 'UsersController@desactivar');
        Route::put('/user/activar', 'UsersController@activar');

        Route::get('/log/replogs', 'LogsController@repLogs');
        Route::get('/asignaciones/repAsignaciones', 'AsignacionesController@repAsignaciones');
        Route::get('/asignaciones/actaAsignaciones', 'AsignacionesController@actaAsignaciones');
        Route::get('/devoluciones/actaDevoluciones', 'DevolucionesController@actaDevoluciones');
        
        Route::get('/download-zipvsiaf', 'ZipArchiveController@downloadZip');
        });
    });

