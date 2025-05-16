<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;


// user routes 

Route::get('/', function () {
     if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('LoginForm');
})->name('login');

Route::get('/signup', function () {
     if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('SignupForm');
})->name('signup');

Route::post('/RegisterUser', [AuthController::class, 'RegisterUser'])->name('RegisterUser');
Route::post('/LoginUser', [AuthController::class, 'LoginUser'])->name('LoginUser');

Route::middleware('auth')->group(function () {
Route::post('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::get('/dashboard', function () {
    return view('layout');
})->name('dashboard');

    Route::resource('tasks', TaskController::class);
});
