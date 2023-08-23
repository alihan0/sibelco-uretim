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
    Route::get('/new/subform', 'new_subform');
    Route::get('/all', 'all');
    Route::get('/all/subform', 'all_subform');
    Route::get('/detail/{id}', 'detail');
    Route::get('/detail/subform/{id}', 'detail_subform');
    Route::get('/edit/{id}', 'edit');
    
    Route::post('/save', 'save');
    Route::post('/save/subform', 'save_subform');
    Route::post('/update', 'update');
    Route::post('/delete', 'delete');
    Route::post('/delete/question', 'delete_question');
    Route::post('/delete/subform/question', 'delete_question_subform');
    Route::post('/add/question', 'add_question');
    Route::post('/add/subform/question', 'add_question_subform');
    Route::post('/set/passive', 'question_passive');
    Route::post('/set/active', 'question_active');
    Route::post('/update/question', 'update_question');
    Route::post('/update/subform/question', 'update_question_subform');
});
