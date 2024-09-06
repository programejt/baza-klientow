<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\NoAuth;
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

Route::get('/', [ClientsController::class, 'index']);
Route::post('/client/add', [ClientsController::class, 'store']);
Route::get('/client/{id}', [ClientsController::class, 'show']);
Route::get('/json/{id}', [ClientsController::class, 'json']);

Route::middleware(Auth::class)->group(function () {
  Route::get('/clients', [ClientsController::class, 'read']);
  Route::get('/client/edit/{id}', [ClientsController::class, 'index']);
  Route::post('/client/delete/', [ClientsController::class, 'delete']);
  Route::get('/logout', [LoginController::class, 'logout']);
});

Route::middleware(NoAuth::class)->group(function () {
  Route::get('/admin', [LoginController::class, 'index']);
  Route::post('/auth', [LoginController::class, 'auth']);
});
