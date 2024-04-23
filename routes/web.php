<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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

// Auth
Route::controller(AuthenticatedSessionController::class)
    ->group(function(){
        Route::get('login', 'create')->name('login')->middleware('guest');
        Route::post('login', 'store')->name('login.store')->middleware('guest');
        Route::delete('logout', 'destroy')->name('logout')->middleware('auth');
    });


// Dashboard
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users
Route::controller(UsersController::class)
    ->middleware('auth')
    ->prefix('users')
    ->as('users.')
    ->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::get('{user}/edit', 'edit')->name('edit');
        Route::put('{user}', 'update')->name('update');
        Route::delete('{user}', 'destroy')->name('destroy');
        Route::put('{user}/restore', 'restore')->name('restore');
    });
//organizations
Route::controller(OrganizationsController::class)
    ->middleware('auth')
    ->prefix('organizations')
    ->as('organizations.')
    ->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::get('{organization}/edit', 'edit')->name('edit');
        Route::put('{organization}', 'update')->name('update');
        Route::delete('{organization}', 'destroy')->name('destroy');
        Route::put('{organization}/restore', 'restore')->name('restore');
    });

// Contacts

Route::controller(ContactsController::class)
    ->middleware('auth')
    ->prefix('contacts')
    ->as('contacts.')
    ->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::get('{contact}/edit', 'edit')->name('edit');
        Route::put('{contact}', 'update')->name('update');
        Route::delete('{contact}', 'destroy')->name('destroy');
        Route::put('{contact}/restore', 'restore')->name('restore');
    });


// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
