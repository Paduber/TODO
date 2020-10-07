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
    return redirect('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('login', 'LoginController@getLogin');
    Route::post('login', 'LoginController@authenticate')->name('login');

    Route::get('register', 'LoginController@getRegister')->name('register');
    Route::post('register', 'LoginController@register');
});

Route::middleware(['auth'])->group(function () {

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::get('tasks', 'TasklistController@tasks');

    Route::post('ajax/tasks', 'TasklistController@addTaskAjax');
    Route::get('ajax/tasks/{id}', 'TasklistController@getTaskAjax');
    Route::put('ajax/tasks/{id}', 'TasklistController@updateTaskAjax');

});
