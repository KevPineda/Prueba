<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\RequestPublicacionesController;
use App\Http\Controllers\AdminController;

Route::get('/', [PublicacionesController::class, 'listado'])->name('listado');
Route::post('/publicaciones', [RequestPublicacionesController::class, 'store'])->name('publicaciones.store');

Route::get('/login',   [AdminController::class, 'showLogin'])->name('login');
Route::post('/login',  [AdminController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/publicaciones',        [AdminController::class, 'adminListado'])->name('listado');
    Route::get('/publicaciones/{id}',   [AdminController::class, 'adminDetalle'])->name('detalle');
    Route::delete('/publicaciones/{id}', [AdminController::class, 'eliminar'])->name('eliminar');
});