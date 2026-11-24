<?php

use App\Http\Controllers\Administration\RoleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route UI Showcase
Route::get('/ui-showcase', function () {
    return view('pages.ui-showcase');
})->name('ui.showcase');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'post'])->name('login.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'post'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'post'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'post'])->name('logout.post');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/roles', RoleController::class);
});
