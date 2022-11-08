<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\DependenciasController;
use App\Http\Controllers\DirectoriosController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\GerenciasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Livewire\ShowDirectorios;

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

Route::resource('/', HomeController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resources([
    'areas' => AreasController::class,
    'dependencias' => DependenciasController::class,
    'directorios' => DirectoriosController::class,
    'gerencias' => GerenciasController::class,
    'issues' => IssuesController::class,
    'users' => UsersController::class,
    'roles' => RolesController::class,
]);

Route::get('/livewire', ShowDirectorios::class);

// Route::post('issues/ajax', [IssuesController::class, 'ajax']);


