<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ComentariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuariosController;

//Productos
Route::get('/productos', [ProductosController::class, 'index']);
Route::post('/productos', [ProductosController::class, 'store']);
Route::put('/productos', [ProductosController::class, 'update']);
Route::delete('/productos', [ProductosController::class, 'destroy']);

//Categorias
Route::get('/categorias', [CategoriasController::class, 'index']);
Route::post('/categorias', [CategoriasController::class, 'store']);
Route::put('/categorias', [CategoriasController::class, 'update']);
Route::delete('/categorias', [CategoriasController::class, 'destroy']);

//Usuarios
Route::get('/usuarios', [UsuariosController::class, 'index']);
Route::post('/usuarios', [UsuariosController::class, 'store']);
Route::post('/usuarios/validate', [UsuariosController::class, 'validate']);
Route::put('/usuarios', [UsuariosController::class, 'update']);
Route::put('/usuarios/email', [UsuariosController::class, 'updateEmail']);
Route::put('/usuarios/telefono', [UsuariosController::class, 'updateTelefono']);
Route::delete('/usuarios', [UsuariosController::class, 'destroy']);

//Comentarios
Route::get('/comentarios', [ComentariosController::class, 'index']);
Route::post('/comentarios', [ComentariosController::class, 'store']);
Route::put('/comentarios', [ComentariosController::class, 'update']);
Route::delete('/comentarios', [ComentariosController::class, 'destroy']);