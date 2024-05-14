<?php

use App\Http\Controllers\EntradasController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Models\Entrada;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        if (session()->has('logged') && session('logged')) { // Verifica si la sesión 'logged' está activa
            return redirect()->route('entradas');
        }
        return view('usuarios.index');
    });

    Route::get('/login', function () {
        return view('usuarios.index');
    })->name('login');
    Route::post('/login', [UsuariosController::class, 'login'])->name('login');

    Route::get('/registro', [UsuariosController::class, 'registro'])->name('registro');
    Route::post('/registro', [UsuariosController::class, 'guardarRegistro'])->name('registro');

    Route::get('/entradas/{page}', [EntradasController::class, 'listado'])->name('entradas');

    Route::get('/nuevaEntrada', [EntradasController::class, 'crearEntrada'])->name('nuevaEntrada');
    Route::post('/nuevaEntrada', [EntradasController::class, 'guardarEntrada'])->name('nuevaEntrada');

    Route::get('/detalle/{id}', [EntradasController::class, 'detalle'])->name('detalle');

    Route::get('/editar/{id}', [EntradasController::class, 'edicion'])->name('editar');
    Route::patch('/editar/{id}', [EntradasController::class, 'editar'])->name('editar');

    Route::get('/eliminar/{id}', [EntradasController::class, 'eliminar'])->name('eliminar');
    Route::delete('/eliminar/{id}', [EntradasController::class, 'borrar'])->name('eliminar');

    Route::get('/logs', [LogsController::class, 'listado'])->name('logs');

    Route::get('/excel', [UsuariosController::class, 'exportar'])->name('exportar');

    Route::post('/logout', [UsuariosController::class, 'logout'])->name('logout');

    Route::get('/generar-pdf', [EntradasController::class, 'generarPDF'])->name('generar.pdf');

    Route::get('/recuperar-contrasena', [PasswordResetController::class, 'showResetForm'])->name('password.request');
    Route::post('/recuperar-contrasena', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
});