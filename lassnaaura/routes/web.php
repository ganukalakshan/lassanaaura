<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Name the login route so middleware redirects (route('login')) work correctly
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

use App\Http\Controllers\Auth\LoginController;

Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');
