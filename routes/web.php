<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route UI Showcase
Route::get('/ui-showcase', function () {
    return view('pages.ui-showcase');
})->name('ui.showcase');

// Rute Login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'post'])->name('login.post');


Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
