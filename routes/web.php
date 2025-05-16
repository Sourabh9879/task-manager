<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('LoginForm');
})->name('login');

Route::get('/signup', function () {
    return view('SignupForm');
})->name('signup');

Route::post('/RegisterUser', [AuthController::class, 'RegisterUser'])->name('RegisterUser');
Route::post('/LoginUser', [AuthController::class, 'LoginUser'])->name('LoginUser');

Route::get('/dashboard', function () {
    return 'welcome to the dashboard';
});
