<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Dashboard as Dashboard;

use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;

use Illuminate\Support\Facades\Route;

// guest routes
 Route::middleware('guest')->group(function () {
    Route::get('login',[AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login',[AuthenticatedSessionController::class, 'store'])->name('login.store');
 });

 // logout route
 Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

 // authenticated routes
 Route::middleware('auth')->group(function () {

    Route::get('/', [Dashboard\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/contacts', Dashboard\ContactsController::class);
    Route::resource('/organizations', Dashboard\OrganizationsController::class);
    Route::resource('/reports', Dashboard\ReportsController::class);
    Route::resource('/users', Dashboard\UsersController::class);
 });


// images handler
Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
