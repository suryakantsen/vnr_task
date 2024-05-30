<?php

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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\PostController::class, 'index'])->name('home');
    Route::post('/create', [App\Http\Controllers\PostController::class, 'create'])->name('create');
    Route::get('/get_data', [App\Http\Controllers\PostController::class, 'get_data'])->name('get_data');
    Route::get('/delete', [App\Http\Controllers\PostController::class, 'delete'])->name('delete');
    Route::get('/delete_account', [App\Http\Controllers\PostController::class, 'delete_account'])->name('delete_account');
});
