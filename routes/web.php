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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/add_compaign_page', [App\Http\Controllers\HomeController::class, 'add_compaign_page']);
Route::post('/add_compaign', [App\Http\Controllers\HomeController::class, 'add_compaign']);
Route::get('/compaign_edit_page/{id}', [App\Http\Controllers\HomeController::class, 'compaign_edit_page']);
Route::post('/edit_compaign', [App\Http\Controllers\HomeController::class, 'edit_compaign']);
Route::get('/delete_compaign/{id}', [App\Http\Controllers\HomeController::class, 'delete_compaign']);
