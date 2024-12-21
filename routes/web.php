<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\auth\authController;
use App\Http\Middleware\AdminAuth;


Route::middleware([AdminAuth::class])->group(function() {
    Route::get('/', function () {
        return view('admin/index');
    });
    
});



Route::get('/login', function () {
    return view('auth/signIn');
});

Route::post('/login_user',[authController::class,'loginUser']);


Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
});