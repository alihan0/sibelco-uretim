<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(MainController::class)->middleware('auth')->group(function(){
    Route::get('/', 'index');

    Route::post('/read-notification', 'notification_read');
});

Route::controller(AuthController::class)->prefix('auth')->group(function(){
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'do_login');
});

Route::controller(FormController::class)->prefix('form')->group(function(){
    Route::get('/new', 'new');
    Route::get('/all', 'all');
    Route::get('/detail/{id}', 'detail');
    Route::get('/edit/{id}', 'edit');
    Route::post('/save', 'save');
    Route::post('/update', 'update');
    Route::post('/delete', 'delete');
});
