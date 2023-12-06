<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/create-task', function () {
    return view('create-task');
});


Route::post('/createTask', function () {
    return view('App\Livewire\CreateTaskForm');
});

Route::get('tasks', "App\Http\Controllers\ControllerTask@getTasks")->name("controller-task");
